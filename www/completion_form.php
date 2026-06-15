<?php

require('./base.inc');
require(BASE . '/../config.inc');
require(BASE . '/../includes/header.inc');

if (!$user->checkDroit('parameters_all')) {
	$_SESSION['erreur'] = 'droitsInsuffisants';
	header('Location: index');
	exit;
}

$subjectType = ($_GET['subject_type'] ?? 'user') === 'resource' ? 'resource' : 'user';
$subjectId = trim($_GET['subject_id'] ?? '');
$cohortId = (int) ($_GET['cohort_id'] ?? 0);

// Resolve the subject's display name
$subjectName = $subjectId;
if ($subjectType === 'user') {
	$u = new User();
	if ($u->db_load(array('user_id', '=', $subjectId))) { $subjectName = $u->nom; }
} else {
	$r = new Ressource();
	if ($r->db_load(array('ressource_id', '=', $subjectId))) { $subjectName = $r->nom; }
}

// Active requirements for the cohort, with the subject's current values
$items = array();
$res = db_query("SELECT * FROM planning_requirement WHERE cohort_id = " . val2sql($cohortId) . " AND actif = 'oui' ORDER BY ordre, libelle");
while ($req = db_fetch_array($res)) {
	$comp = new Requirement_completion();
	$loaded = $comp->db_load(array(
		'requirement_id', '=', $req['requirement_id'],
		'subject_type', '=', $subjectType,
		'subject_id', '=', $subjectId,
	));
	$items[] = array(
		'requirement_id' => $req['requirement_id'],
		'libelle' => $req['libelle'],
		'response_type' => $req['response_type'],
		'valeur' => $loaded ? $comp->valeur : '',
		'fichier' => $loaded ? $comp->fichier : '',
		'date_completion' => $loaded ? $comp->date_completion : '',
	);
}

$smarty->assign('subjectType', $subjectType);
$smarty->assign('subjectId', $subjectId);
$smarty->assign('subjectName', $subjectName);
$smarty->assign('cohortId', $cohortId);
$smarty->assign('items', $items);
$smarty->assign('xajax', $xajax->getJavascript("", "assets/js/xajax.js"));
$smarty->display('www_completion_form.tpl');
?>
