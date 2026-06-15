<?php

require('./base.inc');
require(BASE . '/../config.inc');
require(BASE . '/../includes/header.inc');

if (!$user->checkDroit('ressources_all') && !$user->checkDroit('parameters_all')) {
	$_SESSION['erreur'] = 'droitsInsuffisants';
	header('Location: index');
	exit;
}

// Books = exclusive resources. Mark which are currently out.
$books = array();
$res = db_query("SELECT ressource_id, nom FROM planning_ressource WHERE exclusif = 1 ORDER BY nom");
while ($b = db_fetch_array($res)) { $books[$b['ressource_id']] = array('id' => $b['ressource_id'], 'nom' => $b['nom'], 'out' => null); }

// Currently-out loans (statut out)
$loansOut = array();
$res = db_query("SELECT l.*, r.nom AS book_nom, u.nom AS user_nom
	FROM planning_loan l
	JOIN planning_ressource r ON r.ressource_id = l.resource_id
	LEFT JOIN planning_user u ON u.user_id = l.user_id
	WHERE l.statut = 'out' ORDER BY l.date_due");
$today = date('Y-m-d');
while ($l = db_fetch_array($res)) {
	$l['borrower'] = $l['user_nom'] ?: $l['borrower_name'];
	$l['overdue'] = (!empty($l['date_due']) && $l['date_due'] < $today);
	$loansOut[] = $l;
	if (isset($books[$l['resource_id']])) { $books[$l['resource_id']]['out'] = $l['borrower']; }
}

// Available books (not currently out) for the checkout dropdown
$available = array_values(array_filter($books, fn($b) => $b['out'] === null));

// People who can borrow (users; login optional)
$people = array();
$res = db_query("SELECT user_id, nom FROM planning_user WHERE user_id NOT IN ('publicspl') ORDER BY nom");
while ($p = db_fetch_array($res)) { $people[] = $p; }

// Active holds
$holds = array();
$res = db_query("SELECT h.*, r.nom AS book_nom, u.nom AS user_nom
	FROM planning_loan_hold h
	JOIN planning_ressource r ON r.ressource_id = h.resource_id
	LEFT JOIN planning_user u ON u.user_id = h.user_id
	WHERE h.statut IN ('waiting','notified') ORDER BY h.requested_at");
while ($h = db_fetch_array($res)) { $h['requester'] = $h['user_nom'] ?: $h['borrower_name']; $holds[] = $h; }

// Recent returned history
$history = array();
$res = db_query("SELECT l.*, r.nom AS book_nom, u.nom AS user_nom
	FROM planning_loan l
	JOIN planning_ressource r ON r.ressource_id = l.resource_id
	LEFT JOIN planning_user u ON u.user_id = l.user_id
	WHERE l.statut <> 'out' ORDER BY l.date_in DESC, l.loan_id DESC LIMIT 25");
while ($l = db_fetch_array($res)) { $l['borrower'] = $l['user_nom'] ?: $l['borrower_name']; $history[] = $l; }

$smarty->assign('available', $available);
$smarty->assign('booksOut', $loansOut);
$smarty->assign('people', $people);
$smarty->assign('holds', $holds);
$smarty->assign('history', $history);
$smarty->assign('defaultDue', date('Y-m-d', strtotime('+21 days')));
$smarty->assign('xajax', $xajax->getJavascript("", "assets/js/xajax.js"));
$smarty->display('www_checkout.tpl');
?>
