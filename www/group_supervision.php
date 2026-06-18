<?php

require('./base.inc');
require(BASE . '/../config.inc');
require(BASE . '/../includes/header.inc');

if (!$user->checkDroit('parameters_all')) {
	$_SESSION['erreur'] = 'droitsInsuffisants';
	header('Location: index');
	exit;
}

$days = array(1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat', 7 => 'Sun');

// Supervisors (resources) with their level + lead capability
$supervisors = array();
$supName = array();
$res = db_query("SELECT ressource_id, nom, niveau FROM planning_ressource WHERE exclusif = 0 ORDER BY nom");
while ($s = db_fetch_array($res)) {
	$cap = supervisorCapabilities($s['niveau']);
	$s['level_label'] = supervisorLevelLabel($s['niveau']);
	$s['lead_group'] = $cap['lead_group'] ? 1 : 0;
	$supName[$s['ressource_id']] = $s['nom'];
	$supervisors[] = $s;
}

// Trainees (cohort members) for adding to a group
$trainees = array();
$traineeName = array();
$res = db_query("SELECT user_id, nom FROM planning_user WHERE cohort_id IS NOT NULL ORDER BY nom");
while ($t = db_fetch_array($res)) { $trainees[] = $t; $traineeName[$t['user_id']] = $t['nom']; }

// Groups + their members
$groups = array();
$res = db_query("SELECT * FROM planning_group_session ORDER BY libelle");
while ($g = db_fetch_array($res)) {
	$members = array();
	$mres = db_query("SELECT trainee_id FROM planning_group_member WHERE group_id = " . (int) $g['group_id']);
	while ($m = db_fetch_array($mres)) {
		$members[] = array('user_id' => $m['trainee_id'], 'nom' => $traineeName[$m['trainee_id']] ?? $m['trainee_id']);
	}
	$sched = '';
	if ($g['jour_semaine']) {
		$sched = ($days[(int) $g['jour_semaine']] ?? '');
		if ($g['heure_debut']) { $sched .= ' ' . substr((string) $g['heure_debut'], 0, 5); }
		if ($g['heure_fin']) { $sched .= '–' . substr((string) $g['heure_fin'], 0, 5); }
	}
	$groups[] = array(
		'group_id' => $g['group_id'],
		'libelle' => $g['libelle'],
		'lead' => $supName[$g['lead_ref']] ?? $g['lead_ref'],
		'schedule' => $sched,
		'actif' => $g['actif'],
		'members' => $members,
	);
}

$smarty->assign('supervisors', $supervisors);
$smarty->assign('trainees', $trainees);
$smarty->assign('groups', $groups);
$smarty->assign('xajax', $xajax->getJavascript("", "assets/js/xajax.js"));
$smarty->display('www_group_supervision.tpl');
?>
