<?php

require('./base.inc');
require(BASE . '/../config.inc');
require(BASE . '/../includes/header.inc');

if (!$user->checkDroit('parameters_all')) {
	$_SESSION['erreur'] = 'droitsInsuffisants';
	header('Location: index');
	exit;
}

// Levels with a usage count (how many supervisors are at each level)
$levels = array();
$res = db_query("SELECT level_id, code, label, ordre, lead_group, cover, assignable FROM planning_supervisor_level ORDER BY ordre, label");
while ($r = db_fetch_array($res)) {
	$cnt = db_fetch_array(db_query("SELECT COUNT(*) AS n FROM planning_ressource WHERE niveau = " . val2sql($r['code'])));
	$r['in_use'] = (int) ($cnt['n'] ?? 0);
	$levels[] = $r;
}

$smarty->assign('levels', $levels);
$smarty->assign('xajax', $xajax->getJavascript("", "assets/js/xajax.js"));
$smarty->display('www_supervisor_levels.tpl');
?>
