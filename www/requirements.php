<?php

require('./base.inc');
require(BASE . '/../config.inc');
require(BASE . '/../includes/header.inc');

if (!$user->checkDroit('parameters_all')) {
	$_SESSION['erreur'] = 'droitsInsuffisants';
	header('Location: index');
	exit;
}

// Cohorts with their item counts
$cohorts = new GCollection('Cohort');
$cohorts->db_loadSQL("SELECT * FROM planning_cohort ORDER BY population, annee, libelle");
$cohortData = $cohorts->getSmartyData(TRUE);

// Selected cohort (default: first)
$selected = isset($_GET['cohort_id']) ? (int) $_GET['cohort_id'] : 0;
if ($selected === 0 && count($cohortData) > 0) {
	$selected = (int) $cohortData[0]['cohort_id'];
}

$requirements = new GCollection('Requirement');
$requirements->db_loadSQL("SELECT * FROM planning_requirement WHERE cohort_id = " . val2sql($selected) . " ORDER BY ordre, libelle");

$smarty->assign('cohorts', $cohortData);
$smarty->assign('selectedCohort', $selected);
$smarty->assign('requirements', $requirements->getSmartyData(TRUE));
$smarty->assign('xajax', $xajax->getJavascript("", "assets/js/xajax.js"));
$smarty->display('www_requirements.tpl');
?>
