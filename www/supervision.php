<?php

require('./base.inc');
require(BASE . '/../config.inc');
require(BASE . '/../includes/header.inc');

if (!$user->checkDroit('parameters_all')) {
	$_SESSION['erreur'] = 'droitsInsuffisants';
	header('Location: index');
	exit;
}

// Trainees and supervisors
$trainees = array();
$res = db_query("SELECT user_id, nom FROM planning_user WHERE cohort_id IS NOT NULL ORDER BY nom");
while ($t = db_fetch_array($res)) { $trainees[] = $t; }

$supervisors = array();
$res = db_query("SELECT ressource_id, nom, niveau FROM planning_ressource WHERE exclusif = 0 ORDER BY nom");
while ($s = db_fetch_array($res)) {
	$cap = supervisorCapabilities($s['niveau']);
	$s['level_label'] = supervisorLevelLabel($s['niveau']);
	$s['assignable'] = $cap['assignable'] ? 1 : 0;
	$s['cover'] = $cap['cover'] ? 1 : 0;
	$supervisors[] = $s;
}
$supName = array();
foreach ($supervisors as $s) { $supName[$s['ressource_id']] = $s['nom']; }

$selected = trim($_GET['trainee_id'] ?? ($trainees[0]['user_id'] ?? ''));

$labels = array('assigned' => 'Assigned (primary)', 'individual' => 'Individual supervision', 'notes' => 'Note signing');
$days = array(1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat', 7 => 'Sun');

// Current supervision rows
$supRows = array();
if ($selected !== '') {
	$res = db_query("SELECT * FROM planning_supervision WHERE trainee_id = " . val2sql($selected) . " ORDER BY fonction, date_debut");
	while ($r = db_fetch_array($res)) {
		$slot = '';
		if ($r['fonction'] === 'individual' && $r['jour_semaine']) {
			$slot = ($days[$r['jour_semaine']] ?? '') . ' ' . substr((string) $r['heure_debut'], 0, 5) . '-' . substr((string) $r['heure_fin'], 0, 5);
		}
		$supRows[] = array(
			'sup_id' => $r['sup_id'],
			'fonction' => $labels[$r['fonction']] ?? $r['fonction'],
			'supervisor' => $supName[$r['supervisor_ref']] ?? $r['supervisor_ref'],
			'date_debut' => $r['date_debut'],
			'date_fin' => $r['date_fin'],
			'slot' => $slot,
		);
	}
}

// Coverage rows
$covRows = array();
if ($selected !== '') {
	$res = db_query("SELECT * FROM planning_supervision_coverage WHERE trainee_id = " . val2sql($selected) . " ORDER BY date_debut");
	while ($r = db_fetch_array($res)) {
		$covRows[] = array(
			'cov_id' => $r['cov_id'],
			'fonction' => ($r['fonction'] === 'all') ? 'All functions' : ($labels[$r['fonction']] ?? $r['fonction']),
			'covering' => $supName[$r['covering_ref']] ?? $r['covering_ref'],
			'date_debut' => $r['date_debut'],
			'date_fin' => $r['date_fin'],
			'note' => $r['note'],
		);
	}
}

$smarty->assign('trainees', $trainees);
$smarty->assign('supervisors', $supervisors);
$smarty->assign('selectedTrainee', $selected);
$smarty->assign('supRows', $supRows);
$smarty->assign('covRows', $covRows);
$smarty->assign('xajax', $xajax->getJavascript("", "assets/js/xajax.js"));
$smarty->display('www_supervision.tpl');
?>
