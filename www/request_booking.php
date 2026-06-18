<?php

require('./base.inc');
require(BASE . '/../config.inc');
require(BASE . '/../includes/header.inc');

// Self-service users, or anyone who manages resources, may use this page.
if (!$user->checkDroit('self_service') && !$user->checkDroit('ressources_all') && !$user->checkDroit('parameters_all')) {
	$_SESSION['erreur'] = 'droitsInsuffisants';
	header('Location: index');
	exit;
}

$me = (string) $user->user_id;

// Bookable books (exclusive resources)
$books = array();
$res = db_query("SELECT ressource_id, nom FROM planning_ressource WHERE exclusif = 1 ORDER BY nom");
while ($b = db_fetch_array($res)) { $books[] = $b; }

// This user's own requests (newest first), with the resource name
$mine = array();
$res = db_query("SELECT r.*, res.nom AS resource_name FROM planning_booking_request r
	LEFT JOIN planning_ressource res ON res.ressource_id = r.resource_id
	WHERE r.user_id = " . val2sql($me) . " ORDER BY r.created_at DESC, r.request_id DESC");
while ($r = db_fetch_array($res)) { $mine[] = $r; }

$smarty->assign('books', $books);
$smarty->assign('mine', $mine);
$smarty->assign('xajax', $xajax->getJavascript("", "assets/js/xajax.js"));
$smarty->display('www_request_booking.tpl');
?>
