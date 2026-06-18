<?php

require 'base.inc';
require BASE . '/../config.inc';
require BASE . '/../includes/header.inc';

if (!$user->checkDroit('parameters_all')) {
	$_SESSION['erreur'] = 'droitsInsuffisants';
	header('Location: index');
	exit;
}

$crsfRecu = $_GET['crsf'] ?? $_POST['crsf'] ?? '';
if (!isset($_SESSION['CRSF']) || !hash_equals($_SESSION['CRSF'], (string) $crsfRecu)) {
	$_SESSION['erreur'] = 'droitsInsuffisants';
	header('Location: ' . BASE . '/supervisor_levels');
	exit;
}

function back($msg = null, $key = 'message') {
	if ($msg !== null) { $_SESSION[$key] = $msg; }
	header('Location: ' . BASE . '/supervisor_levels');
	exit;
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
	case 'save_all':
		// Posted parallel arrays keyed by level_id.
		$labels = $_POST['label'] ?? array();
		$ordres = $_POST['ordre'] ?? array();
		$lead = $_POST['lead_group'] ?? array();   // checkbox: present => on
		$cover = $_POST['cover'] ?? array();
		$assign = $_POST['assignable'] ?? array();
		foreach ($labels as $id => $label) {
			$id = (int) $id;
			$label = trim($label);
			if ($id <= 0 || $label === '') { continue; }
			$lv = new Supervisor_level();
			if (!$lv->db_load(array('level_id', '=', $id))) { continue; }
			$lv->label = $label;
			$lv->ordre = (int) ($ordres[$id] ?? 0);
			$lv->lead_group = isset($lead[$id]) ? 'oui' : 'non';
			$lv->cover = isset($cover[$id]) ? 'oui' : 'non';
			$lv->assignable = isset($assign[$id]) ? 'oui' : 'non';
			$lv->db_save();
		}
		back('traitementOK');
		break;

	case 'add':
		$label = trim($_POST['label'] ?? '');
		if ($label === '') { back('A label is required.', 'erreur'); }
		// Derive a stable, unique code from the label.
		$base = preg_replace('/[^a-z0-9]/', '', strtolower($label));
		if ($base === '') { $base = 'level'; }
		$base = substr($base, 0, 16);
		$code = $base; $i = 1;
		$probe = new Supervisor_level();
		while ($probe->db_load(array('code', '=', $code))) { $code = $base . $i; $i++; $probe = new Supervisor_level(); }
		$maxRow = db_fetch_array(db_query("SELECT COALESCE(MAX(ordre),0) AS m FROM planning_supervisor_level"));
		$lv = new Supervisor_level();
		$lv->code = $code;
		$lv->label = $label;
		$lv->ordre = (int) ($maxRow['m'] ?? 0) + 1;
		$lv->lead_group = isset($_POST['lead_group']) ? 'oui' : 'non';
		$lv->cover = isset($_POST['cover']) ? 'oui' : 'non';
		$lv->assignable = isset($_POST['assignable']) ? 'oui' : 'non';
		$lv->db_save();
		back('traitementOK');
		break;

	case 'delete':
		$lv = new Supervisor_level();
		if ($lv->db_load(array('level_id', '=', (int) ($_GET['level_id'] ?? 0)))) {
			// Clear this level from any supervisors using it (becomes "no level set").
			db_query("UPDATE planning_ressource SET niveau = NULL WHERE niveau = " . val2sql($lv->code));
			$lv->db_delete();
		}
		back('traitementOK');
		break;
}

back();
