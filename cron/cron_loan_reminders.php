<?php
/**
 * Book-loan reminders: emails borrowers whose loans are overdue or due soon.
 * Mirrors cron_email_notification_before_after.php. Safe to run repeatedly:
 * each loan is reminded at most once per day (reminded_at guard).
 *
 * CLI:  php cron/cron_loan_reminders.php [--trace] [--dry]
 *   --trace  print what is processed
 *   --dry    do everything except actually send / stamp (for testing)
 */

set_time_limit(5000);

$TRACE = in_array('--trace', $argv) || in_array('trace', $argv);
$DRY   = in_array('--dry', $argv) || in_array('dry', $argv);

require_once './base.inc';
require_once BASE . '/../config.inc';

$DUE_SOON_DAYS = 3;            // remind this many days before due
$today = date('Y-m-d');
$soon  = date('Y-m-d', strtotime("+$DUE_SOON_DAYS days"));

// Loans still out, due on/before the "soon" horizon, not reminded in the last ~day.
$loans = new GCollection('Loan');
$loans->db_loadSQL(
	"SELECT l.* FROM planning_loan l
	 WHERE l.statut = 'out'
	   AND l.date_due IS NOT NULL
	   AND l.date_due <= " . val2sql($soon) . "
	   AND (l.reminded_at IS NULL OR l.reminded_at < " . val2sql(date('Y-m-d H:i:s', strtotime('-20 hours'))) . ")"
);

$sent = 0; $skipped = 0;
while ($loan = $loans->fetch()) {
	$overdue = ($loan->date_due < $today);
	$book = new Ressource();
	$book->db_load(array('ressource_id', '=', $loan->resource_id));

	// NB: GObject overloads properties via __get without __isset, so empty()/isset()
	// on a magic property is unreliable — read into a local first.
	$loanUserId = (string) $loan->user_id;
	$email = ''; $who = (string) $loan->borrower_name;
	if ($loanUserId !== '') {
		$u = new User();
		if ($u->db_load(array('user_id', '=', $loanUserId))) { $email = (string) $u->email; $who = (string) $u->nom; }
	}

	if ($email === '') {
		$skipped++;
		if ($TRACE) { echo "skip (no email): {$book->nom} -> {$who}\n"; }
		continue;
	}

	$subject = $overdue ? 'Overdue library book' : 'Library book due soon';
	$body = 'Hello ' . htmlspecialchars($who) . ',<br><br>'
		. ($overdue
			? 'The book "' . htmlspecialchars($book->nom) . '" was due on ' . $loan->date_due . ' and is now overdue. Please return it.'
			: 'The book "' . htmlspecialchars($book->nom) . '" is due on ' . $loan->date_due . '. Please return or renew it.');

	if ($TRACE) { echo ($overdue ? 'OVERDUE' : 'due-soon') . ": {$book->nom} -> {$who} <{$email}> (due {$loan->date_due})\n"; }

	if (!$DRY) {
		try { new Mailer($email, $subject, $body, true); } catch (Exception $e) { /* SMTP not configured */ }
		$loan->reminded_at = date('Y-m-d H:i:s');
		$loan->db_save();
	}
	$sent++;
}

echo "loan reminders: $sent processed, $skipped skipped (no email)" . ($DRY ? " [dry-run]" : "") . "\n";
