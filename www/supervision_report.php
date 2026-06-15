<?php

require('./base.inc');
require(BASE . '/../config.inc');
require(BASE . '/../includes/header.inc');

if (!$user->checkDroit('parameters_all')) {
	$_SESSION['erreur'] = 'droitsInsuffisants';
	header('Location: index');
	exit;
}

// Trainees (users in a cohort) and a resource_id -> name map for supervisors
$trainees = array();
$res = db_query("SELECT user_id, nom FROM planning_user WHERE cohort_id IS NOT NULL ORDER BY nom");
while ($t = db_fetch_array($res)) { $trainees[] = $t; }

$supName = array();
$res = db_query("SELECT ressource_id, nom FROM planning_ressource WHERE exclusif = 0");
while ($r = db_fetch_array($res)) { $supName[$r['ressource_id']] = $r['nom']; }

$selectedTrainee = trim($_GET['trainee_id'] ?? ($trainees[0]['user_id'] ?? ''));
$date = trim($_GET['date'] ?? date('Y-m-d'));

$rows = array();
$traineeName = $selectedTrainee;
if ($selectedTrainee !== '') {
	foreach ($trainees as $t) { if ($t['user_id'] === $selectedTrainee) { $traineeName = $t['nom']; break; } }
	$labels = array('assigned' => 'Assigned (primary)', 'individual' => 'Individual supervision', 'notes' => 'Note signing');
	$resolved = Supervision::resolveForDate($selectedTrainee, $date);
	foreach ($resolved as $fonction => $r) {
		$rows[] = array(
			'fonction' => $labels[$fonction],
			'base' => $r['base'] ? ($supName[$r['base']] ?? $r['base']) : '—',
			'covered' => $r['covered_by'] ? ($supName[$r['covered_by']] ?? $r['covered_by']) : '',
			'effective' => $r['effective'] ? ($supName[$r['effective']] ?? $r['effective']) : '—',
			'is_covered' => (bool) $r['covered_by'],
		);
	}
}

$smarty->assign('trainees', $trainees);
$smarty->assign('selectedTrainee', $selectedTrainee);
$smarty->assign('traineeName', $traineeName);
$smarty->assign('date', $date);
$smarty->assign('rows', $rows);
$smarty->assign('xajax', $xajax->getJavascript("", "assets/js/xajax.js"));
$smarty->display('www_supervision_report.tpl');
?>
