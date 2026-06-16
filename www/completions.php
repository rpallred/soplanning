<?php

require('./base.inc');
require(BASE . '/../config.inc');
require(BASE . '/../includes/header.inc');

if (!$user->checkDroit('parameters_all')) {
	$_SESSION['erreur'] = 'droitsInsuffisants';
	header('Location: index');
	exit;
}

// Cohorts
$cohorts = new GCollection('Cohort');
$cohorts->db_loadSQL("SELECT * FROM planning_cohort ORDER BY population, annee, libelle");
$cohortData = $cohorts->getSmartyData(TRUE);

$selected = isset($_GET['cohort_id']) ? (int) $_GET['cohort_id'] : 0;
if ($selected === 0 && count($cohortData) > 0) {
	$selected = (int) $cohortData[0]['cohort_id'];
}

// Determine population of the selected cohort
$population = 'trainee';
foreach ($cohortData as $co) {
	if ((int) $co['cohort_id'] === $selected) { $population = $co['population']; break; }
}
$subjectType = ($population === 'supervisor') ? 'resource' : 'user';

// Active requirements for this cohort
$reqRows = array();
$res = db_query("SELECT * FROM planning_requirement WHERE cohort_id = " . val2sql($selected) . " AND actif = 'oui' ORDER BY ordre, libelle");
while ($r = db_fetch_array($res)) { $reqRows[] = $r; }

// Members of the cohort
$members = array();
if ($subjectType === 'user') {
	$res = db_query("SELECT user_id AS id, nom FROM planning_user WHERE cohort_id = " . val2sql($selected) . " ORDER BY nom");
} else {
	// supervisors are the non-exclusive resources (books are exclusive)
	$res = db_query("SELECT ressource_id AS id, nom FROM planning_ressource WHERE exclusif = 0 ORDER BY nom");
}
while ($m = db_fetch_array($res)) { $members[] = $m; }

// Completion values keyed [subject_id][requirement_id]
$completions = array();
$res = db_query("SELECT rc.* FROM planning_requirement_completion rc
	JOIN planning_requirement r ON r.requirement_id = rc.requirement_id
	WHERE r.cohort_id = " . val2sql($selected) . " AND rc.subject_type = " . val2sql($subjectType));
while ($c = db_fetch_array($res)) {
	$completions[$c['subject_id']][$c['requirement_id']] = $c;
}

// Build display rows
$matrix = array();
foreach ($members as $m) {
	$cells = array();
	$doneCount = 0;
	foreach ($reqRows as $req) {
		$comp = $completions[$m['id']][$req['requirement_id']] ?? null;
		$done = false;
		$partial = false;
			$display = '';
		if ($comp !== null) {
			switch ($req['response_type']) {
				case 'bool': $done = ($comp['valeur'] === 'yes'); $display = $done ? 'Yes' : 'No'; break;
				case 'date': $done = !empty($comp['valeur']); $display = $comp['valeur']; break;
				case 'number':
					$val = (isset($comp['valeur']) && $comp['valeur'] !== '') ? (int) $comp['valeur'] : null;
					$target = !empty($req['cible']) ? (int) $req['cible'] : null;
					if ($val !== null) {
						$display = $target ? ($val . '/' . $target) : (string) $val;
						if ($target) { $done = ($val >= $target); $partial = (!$done && $val > 0); }
						else { $done = ($val > 0); }
					}
					break;
				case 'link': $done = !empty($comp['valeur']); $display = $done ? 'Link' : ''; break;
				case 'file': $done = !empty($comp['fichier']); $display = $done ? 'File' : ''; break;
			}
		}
		if ($done) { $doneCount++; }
		$cells[] = array('done' => $done, 'partial' => $partial, 'display' => $display, 'type' => $req['response_type']);
	}
	$matrix[] = array(
		'id' => $m['id'],
		'nom' => $m['nom'],
		'cells' => $cells,
		'done' => $doneCount,
		'total' => count($reqRows),
	);
}

// For trainee cohorts, offer people who can be added/moved into this cohort
// (anyone not already in it; choosing someone from another cohort moves them —
// e.g. promoting an intern into a fellow cohort).
$assignable = array();
if ($subjectType === 'user') {
	$res = db_query("SELECT user_id, nom FROM planning_user
		WHERE user_id NOT IN ('publicspl','ADM')
		  AND (cohort_id IS NULL OR cohort_id <> " . val2sql($selected) . ")
		ORDER BY nom");
	while ($u = db_fetch_array($res)) { $assignable[] = $u; }
}

$smarty->assign('cohorts', $cohortData);
$smarty->assign('selectedCohort', $selected);
$smarty->assign('subjectType', $subjectType);
$smarty->assign('assignable', $assignable);
$smarty->assign('reqRows', $reqRows);
$smarty->assign('matrix', $matrix);
$smarty->assign('xajax', $xajax->getJavascript("", "assets/js/xajax.js"));
$smarty->display('www_completions.tpl');
?>
