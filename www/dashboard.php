<?php

require('./base.inc');
require(BASE . '/../config.inc');
require(BASE . '/../includes/header.inc');

if (!$user->checkDroit('parameters_all')) {
	$_SESSION['erreur'] = 'droitsInsuffisants';
	header('Location: index');
	exit;
}

// supervisor id -> name (supervisors are the non-exclusive resources)
$supName = array();
$res = db_query("SELECT ressource_id, nom FROM planning_ressource WHERE exclusif = 0");
while ($r = db_fetch_array($res)) { $supName[$r['ressource_id']] = $r['nom']; }

// assigned supervision per trainee, sorted by start date: 1st row = First Half, 2nd = Second Half
$byTrainee = array();
$order = array();
$res = db_query("SELECT s.trainee_id, u.nom AS tnom, s.supervisor_ref, s.date_debut
	FROM planning_supervision s
	JOIN planning_user u ON u.user_id = s.trainee_id
	WHERE s.fonction = 'assigned' AND s.actif = 'oui'
	ORDER BY u.nom, s.date_debut");
while ($r = db_fetch_array($res)) {
	$t = $r['trainee_id'];
	if (!isset($byTrainee[$t])) { $byTrainee[$t] = array('nom' => $r['tnom'], 'halves' => array()); $order[] = $t; }
	$byTrainee[$t]['halves'][] = $r['supervisor_ref'];
}

// build trainee lookup + invert into supervisor load
$lookup = array();
$load = array(); // supervisor_ref => ['h1'=>[trainee names], 'h2'=>[...]]
foreach ($order as $t) {
	$h = $byTrainee[$t]['halves'];
	$h1 = $h[0] ?? null;
	$h2 = $h[1] ?? null;
	$lookup[] = array(
		'trainee' => $byTrainee[$t]['nom'],
		'h1' => $h1 ? ($supName[$h1] ?? $h1) : '—',
		'h2' => $h2 ? ($supName[$h2] ?? $h2) : '—',
	);
	if ($h1) { $load[$h1]['h1'][] = $byTrainee[$t]['nom']; }
	if ($h2) { $load[$h2]['h2'][] = $byTrainee[$t]['nom']; }
}

$loadRows = array();
foreach ($load as $ref => $halves) {
	$h1 = $halves['h1'] ?? array();
	$h2 = $halves['h2'] ?? array();
	$loadRows[] = array(
		'supervisor' => $supName[$ref] ?? $ref,
		'h1' => implode(', ', $h1),
		'h2' => implode(', ', $h2),
		'total' => count($h1) + count($h2),
	);
}
usort($loadRows, fn($a, $b) => strcmp($a['supervisor'], $b['supervisor']));

$smarty->assign('lookup', $lookup);
$smarty->assign('loadRows', $loadRows);
$smarty->assign('xajax', $xajax->getJavascript("", "assets/js/xajax.js"));
$smarty->display('www_dashboard.tpl');
?>
