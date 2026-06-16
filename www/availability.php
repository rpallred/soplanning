<?php

require('./base.inc');
require(BASE . '/../config.inc');
require(BASE . '/../includes/header.inc');

if (!$user->checkDroit('ressources_all') && !$user->checkDroit('parameters_all')) {
	$_SESSION['erreur'] = 'droitsInsuffisants';
	header('Location: index');
	exit;
}

// Resources to choose from
$resources = array();
$res = db_query("SELECT ressource_id, nom, exclusif FROM planning_ressource ORDER BY exclusif DESC, nom");
while ($r = db_fetch_array($res)) { $resources[] = $r; }

$selected = trim($_GET['resource_id'] ?? ($resources[0]['ressource_id'] ?? ''));
$resourceName = $selected;
foreach ($resources as $r) { if ($r['ressource_id'] === $selected) { $resourceName = $r['nom']; break; } }

$days = array(1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat', 7 => 'Sun');

$windows = array();
$blackouts = array();
if ($selected !== '') {
	$res = db_query("SELECT * FROM planning_availability WHERE resource_id = " . val2sql($selected) . " ORDER BY type, jour_semaine, date_debut");
	while ($a = db_fetch_array($res)) {
		if ($a['type'] === 'window') {
			$windows[] = array(
				'avail_id' => $a['avail_id'],
				'jour' => $days[(int) $a['jour_semaine']] ?? '',
				'heure_debut' => substr((string) $a['heure_debut'], 0, 5),
				'heure_fin' => substr((string) $a['heure_fin'], 0, 5),
			);
		} else {
			$blackouts[] = array(
				'avail_id' => $a['avail_id'],
				'date_debut' => $a['date_debut'],
				'date_fin' => $a['date_fin'],
				'note' => $a['note'],
			);
		}
	}
}

// Limits + linked user account for this resource
$quotaMaxJours = '';
$linkedUser = '';
if ($selected !== '') {
	$r = new Ressource();
	if ($r->db_load(array('ressource_id', '=', $selected))) {
		$quotaMaxJours = $r->quota_max_jours;
		$linkedUser = $r->user_id;
	}
}
$people = array();
$res = db_query("SELECT user_id, nom FROM planning_user WHERE user_id NOT IN ('publicspl') ORDER BY nom");
while ($p = db_fetch_array($res)) { $people[] = $p; }
$smarty->assign('people', $people);
$smarty->assign('linkedUser', $linkedUser);
$smarty->assign('quotaMaxJours', $quotaMaxJours);
$smarty->assign('loanMaxPerUser', defined('CONFIG_LOAN_MAX_ACTIVE_PER_USER') ? CONFIG_LOAN_MAX_ACTIVE_PER_USER : 0);

$smarty->assign('resources', $resources);
$smarty->assign('selected', $selected);
$smarty->assign('resourceName', $resourceName);
$smarty->assign('windows', $windows);
$smarty->assign('blackouts', $blackouts);
$smarty->assign('hasWindows', count($windows) > 0);
$smarty->assign('xajax', $xajax->getJavascript("", "assets/js/xajax.js"));
$smarty->display('www_availability.tpl');
?>
