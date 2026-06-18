<?php

require('./base.inc');
require(BASE . '/../config.inc');
require(BASE . '/../includes/header.inc');

if (!$user->checkDroit('ressources_all') && !$user->checkDroit('parameters_all')) {
	$_SESSION['erreur'] = 'droitsInsuffisants';
	header('Location: index');
	exit;
}

// Pending first, then recently decided
$rows = array();
$res = db_query("SELECT r.*, res.nom AS resource_name, u.nom AS requester_name
	FROM planning_booking_request r
	LEFT JOIN planning_ressource res ON res.ressource_id = r.resource_id
	LEFT JOIN planning_user u ON u.user_id = r.user_id
	ORDER BY (r.statut = 'pending') DESC, r.created_at DESC, r.request_id DESC");
while ($r = db_fetch_array($res)) {
	// Is the book currently out? (so the reviewer knows if approval can fulfil now)
	$out = db_fetch_array(db_query("SELECT COUNT(*) AS n FROM planning_loan WHERE resource_id = " . val2sql($r['resource_id']) . " AND statut = 'out'"));
	$r['book_out'] = ((int) ($out['n'] ?? 0) > 0);
	$rows[] = $r;
}

$smarty->assign('rows', $rows);
$smarty->assign('xajax', $xajax->getJavascript("", "assets/js/xajax.js"));
$smarty->display('www_request_queue.tpl');
?>
