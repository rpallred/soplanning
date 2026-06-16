<?php

require 'base.inc';
require BASE . '/../config.inc';
require BASE . '/../includes/header.inc';

if (!$user->checkDroit('ressources_all') && !$user->checkDroit('parameters_all')) {
	$_SESSION['erreur'] = 'droitsInsuffisants';
	header('Location: index');
	exit;
}

$crsfRecu = $_GET['crsf'] ?? $_POST['crsf'] ?? '';
if (!isset($_SESSION['CRSF']) || !hash_equals($_SESSION['CRSF'], (string) $crsfRecu)) {
	$_SESSION['erreur'] = 'droitsInsuffisants';
	header('Location: ' . BASE . '/checkout');
	exit;
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$back = 'Location: ' . BASE . '/checkout';

switch ($action) {
	case 'checkout':
		$resourceId = trim($_POST['resource_id'] ?? '');
		$userId = trim($_POST['user_id'] ?? '');
		$name = trim($_POST['borrower_name'] ?? '');
		$due = trim($_POST['date_due'] ?? '');
		// Guard: refuse if this book is already out (exclusive resource).
		$res = db_query("SELECT loan_id FROM planning_loan WHERE resource_id = " . val2sql($resourceId) . " AND statut = 'out'");
		// Guard: refuse if the requested dates clash with the resource's availability rules.
		$dateOut = date('Y-m-d');
		$conflict = ($resourceId !== '') ? Availability::bookingConflict($resourceId, $dateOut, ($due !== '' ? $due : $dateOut)) : '';

		// Quota: max loan duration for this resource
		$quotaMsg = '';
		if ($resourceId !== '' && $due !== '') {
			$book = new Ressource();
			if ($book->db_load(array('ressource_id', '=', $resourceId))) {
				$maxJours = (int) $book->quota_max_jours;
				if ($maxJours > 0) {
					$span = (strtotime($due) - strtotime($dateOut)) / 86400;
					if ($span > $maxJours) {
						$quotaMsg = 'the loan exceeds the ' . $maxJours . '-day limit for this resource';
					}
				}
			}
		}
		// Quota: max active loans per borrower (global, 0 = unlimited)
		if ($quotaMsg === '' && $userId !== '' && (int) CONFIG_LOAN_MAX_ACTIVE_PER_USER > 0) {
			$cnt = db_fetch_array(db_query("SELECT COUNT(*) AS n FROM planning_loan WHERE user_id = " . val2sql($userId) . " AND statut = 'out'"));
			if ((int) $cnt['n'] >= (int) CONFIG_LOAN_MAX_ACTIVE_PER_USER) {
				$quotaMsg = 'this borrower already has the maximum of ' . (int) CONFIG_LOAN_MAX_ACTIVE_PER_USER . ' books out';
			}
		}

		if ($conflict !== '') {
			$_SESSION['erreur'] = 'Cannot check out: resource ' . $conflict . '.';
		} elseif ($quotaMsg !== '') {
			$_SESSION['erreur'] = 'Cannot check out: ' . $quotaMsg . '.';
		} elseif ($resourceId !== '' && db_num_rows($res) === 0) {
			$loan = new Loan();
			$loan->resource_id = $resourceId;
			if ($userId !== '') { $loan->user_id = $userId; }
			if ($name !== '') { $loan->borrower_name = $name; }
			$loan->date_out = date('Y-m-d');
			if ($due !== '') { $loan->date_due = $due; }
			$loan->statut = 'out';
			$loan->db_save();
			$_SESSION['message'] = 'traitementOK';
		}
		break;

	case 'checkin':
	case 'lost':
		$loanId = (int) ($_GET['loan_id'] ?? $_POST['loan_id'] ?? 0);
		$loan = new Loan();
		if ($loan->db_load(array('loan_id', '=', $loanId))) {
			$loan->date_in = date('Y-m-d');
			$loan->statut = ($action === 'lost') ? 'lost' : 'returned';
			$loan->db_save();
			// On return, flag the next waiting hold as available.
			if ($action === 'checkin') {
				$holds = new GCollection('Loan_hold');
				$holds->db_loadSQL("SELECT * FROM planning_loan_hold WHERE resource_id = " . val2sql($loan->resource_id) . " AND statut = 'waiting' ORDER BY requested_at LIMIT 1");
				if ($h = $holds->fetch()) {
					$h->statut = 'notified';
					$h->db_save();
					// Email the requester that the book is available (best-effort).
					notifyHoldAvailable($h, $loan->resource_id);
					$_SESSION['message'] = 'traitementOK';
				}
			}
		}
		break;

	case 'hold':
		$resourceId = trim($_POST['resource_id'] ?? '');
		$userId = trim($_POST['user_id'] ?? '');
		$name = trim($_POST['borrower_name'] ?? '');
		if ($resourceId !== '') {
			$h = new Loan_hold();
			$h->resource_id = $resourceId;
			if ($userId !== '') { $h->user_id = $userId; }
			if ($name !== '') { $h->borrower_name = $name; }
			$h->requested_at = date('Y-m-d H:i:s');
			$h->statut = 'waiting';
			$h->db_save();
			$_SESSION['message'] = 'traitementOK';
		}
		break;

	case 'cancelhold':
		$holdId = (int) ($_GET['hold_id'] ?? 0);
		$h = new Loan_hold();
		if ($h->db_load(array('hold_id', '=', $holdId))) {
			$h->statut = 'cancelled';
			$h->db_save();
		}
		break;
}

header($back);
exit;

/**
 * Best-effort email when a held book becomes available. Silent if the
 * requester has no email or SMTP is not configured.
 */
function notifyHoldAvailable($hold, $resourceId)
{
	// GObject magic props are unreliable with empty()/isset() (no __isset) — read locals.
	$holdUserId = (string) $hold->user_id;
	if ($holdUserId === '') { return; }
	$u = new User();
	if (!$u->db_load(array('user_id', '=', $holdUserId)) || (string) $u->email === '') { return; }
	$book = new Ressource();
	$book->db_load(array('ressource_id', '=', $resourceId));
	$subject = 'A book you requested is now available';
	$body = 'Hello ' . htmlspecialchars($u->nom) . ',<br><br>The book "' . htmlspecialchars($book->nom)
		. '" you placed a hold on has been returned and is now available for checkout.';
	try { new Mailer($u->email, $subject, $body, true); } catch (Exception $e) { /* SMTP not set up */ }
}
