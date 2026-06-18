<?php

require('./base.inc');
require(BASE . '/../config.inc');
require(BASE . '/../includes/header.inc');

if (!$user->checkDroit('parameters_all') && !$user->checkDroit('stats_users') && !$user->checkDroit('stats_projects')) {
	$_SESSION['erreur'] = 'droitsInsuffisants';
	header('Location: index');
	exit;
}

$today = date('Y-m-d');

// ---- A. Completion by cohort (trainee cohorts) ----------------------------
$completionRows = array();
$res = db_query("SELECT cohort_id, libelle, annee FROM planning_cohort WHERE population = 'trainee' ORDER BY annee, libelle");
$cohorts = array();
while ($c = db_fetch_array($res)) { $cohorts[] = $c; }
foreach ($cohorts as $co) {
	$cid = (int) $co['cohort_id'];
	$reqs = array();
	$r = db_query("SELECT requirement_id, response_type, cible FROM planning_requirement WHERE cohort_id = " . $cid . " AND actif = 'oui'");
	while ($x = db_fetch_array($r)) { $reqs[$x['requirement_id']] = $x; }
	$members = array();
	$r = db_query("SELECT user_id, nom FROM planning_user WHERE cohort_id = " . $cid);
	while ($x = db_fetch_array($r)) { $members[$x['user_id']] = $x['nom']; }
	// completions for this cohort's reqs, keyed [user][requirement]
	$comp = array();
	if (!empty($reqs)) {
		$r = db_query("SELECT rc.subject_id, rc.requirement_id, rc.valeur, rc.fichier
			FROM planning_requirement_completion rc
			JOIN planning_requirement rq ON rq.requirement_id = rc.requirement_id
			WHERE rq.cohort_id = " . $cid . " AND rc.subject_type = 'user'");
		while ($x = db_fetch_array($r)) { $comp[$x['subject_id']][$x['requirement_id']] = $x; }
	}
	$nReq = count($reqs);
	$nMem = count($members);
	$done = 0; $fullyDone = 0; $behind = array();
	foreach ($members as $uid => $nom) {
		$mDone = 0;
		foreach ($reqs as $rid => $req) {
			if (requirementDone($req, $comp[$uid][$rid] ?? null)) { $mDone++; $done++; }
		}
		if ($nReq > 0 && $mDone >= $nReq) { $fullyDone++; }
		elseif ($nReq > 0) { $behind[] = $nom . ' (' . $mDone . '/' . $nReq . ')'; }
	}
	$total = $nReq * $nMem;
	$completionRows[] = array(
		'cohort' => $co['libelle'], 'members' => $nMem, 'reqs' => $nReq,
		'pct' => $total > 0 ? round($done / $total * 100) : 0,
		'fully' => $fullyDone, 'behind' => implode(', ', array_slice($behind, 0, 8)),
		'behind_more' => max(0, count($behind) - 8),
	);
}

// ---- B. Supervision load --------------------------------------------------
$loadRows = array();
$names = array(); $levels = array();
$r = db_query("SELECT ressource_id, nom, niveau FROM planning_ressource WHERE exclusif = 0");
while ($x = db_fetch_array($r)) { $names[$x['ressource_id']] = $x['nom']; $levels[$x['ressource_id']] = supervisorLevelLabel($x['niveau']); }
$agg = array();
$r = db_query("SELECT supervisor_ref,
		COUNT(DISTINCT CASE WHEN fonction='assigned' THEN trainee_id END) AS principals,
		COUNT(*) AS functions
	FROM planning_supervision WHERE actif = 'oui' GROUP BY supervisor_ref");
while ($x = db_fetch_array($r)) { $agg[$x['supervisor_ref']] = array('principals' => (int) $x['principals'], 'functions' => (int) $x['functions'], 'covers' => 0); }
$r = db_query("SELECT covering_ref, COUNT(*) AS n FROM planning_supervision_coverage
	WHERE date_debut <= " . val2sql($today) . " AND date_fin >= " . val2sql($today) . " GROUP BY covering_ref");
while ($x = db_fetch_array($r)) {
	if (!isset($agg[$x['covering_ref']])) { $agg[$x['covering_ref']] = array('principals' => 0, 'functions' => 0, 'covers' => 0); }
	$agg[$x['covering_ref']]['covers'] = (int) $x['n'];
}
foreach ($agg as $ref => $a) {
	$loadRows[] = array(
		'supervisor' => $names[$ref] ?? $ref, 'level' => $levels[$ref] ?? '',
		'principals' => $a['principals'], 'functions' => $a['functions'], 'covers' => $a['covers'],
	);
}
usort($loadRows, function ($a, $b) { return $b['principals'] - $a['principals']; });

// ---- C. Book circulation --------------------------------------------------
$g = function ($sql) { $row = db_fetch_array(db_query($sql)); return (int) ($row['n'] ?? 0); };
$circ = array(
	'total' => $g("SELECT COUNT(*) AS n FROM planning_ressource WHERE exclusif = 1"),
	'out' => $g("SELECT COUNT(*) AS n FROM planning_loan WHERE statut = 'out'"),
	'overdue' => $g("SELECT COUNT(*) AS n FROM planning_loan WHERE statut = 'out' AND date_due IS NOT NULL AND date_due < " . val2sql($today)),
	'holds' => $g("SELECT COUNT(*) AS n FROM planning_loan_hold"),
);
$overdueList = array();
$r = db_query("SELECT l.date_due, res.nom AS book, COALESCE(u.nom, l.borrower_name) AS borrower
	FROM planning_loan l
	LEFT JOIN planning_ressource res ON res.ressource_id = l.resource_id
	LEFT JOIN planning_user u ON u.user_id = l.user_id
	WHERE l.statut = 'out' AND l.date_due IS NOT NULL AND l.date_due < " . val2sql($today) . "
	ORDER BY l.date_due");
while ($x = db_fetch_array($r)) { $overdueList[] = $x; }

// ---- D. Group supervision -------------------------------------------------
$groupRows = array();
$r = db_query("SELECT g.libelle, g.lead_ref, COUNT(m.trainee_id) AS members
	FROM planning_group_session g
	LEFT JOIN planning_group_member m ON m.group_id = g.group_id
	GROUP BY g.group_id, g.libelle, g.lead_ref ORDER BY g.libelle");
while ($x = db_fetch_array($r)) {
	$groupRows[] = array('group' => $x['libelle'], 'lead' => $names[$x['lead_ref']] ?? $x['lead_ref'], 'members' => (int) $x['members']);
}
$ungrouped = $g("SELECT COUNT(*) AS n FROM planning_user
	WHERE cohort_id IS NOT NULL AND user_id NOT IN (SELECT trainee_id FROM planning_group_member)");

$smarty->assign('completionRows', $completionRows);
$smarty->assign('loadRows', $loadRows);
$smarty->assign('circ', $circ);
$smarty->assign('overdueList', $overdueList);
$smarty->assign('groupRows', $groupRows);
$smarty->assign('ungrouped', $ungrouped);
$smarty->assign('xajax', $xajax->getJavascript("", "assets/js/xajax.js"));
$smarty->display('www_program_stats.tpl');
?>
