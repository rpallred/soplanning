<?php

require 'base.inc';
require BASE . '/../config.inc';
require BASE . '/../includes/header.inc';

if (!$user->checkDroit('parameters_all')) {
	$_SESSION['erreur'] = 'droitsInsuffisants';
	header('Location: index');
	exit;
}

// CSRF: required for both delete (GET) and add (POST)
$crsfRecu = $_GET['crsf'] ?? $_POST['crsf'] ?? '';
if (!isset($_SESSION['CRSF']) || !hash_equals($_SESSION['CRSF'], (string) $crsfRecu)) {
	$_SESSION['erreur'] = 'droitsInsuffisants';
	header('Location: ' . BASE . '/requirements');
	exit;
}

$cohortId = (int) ($_GET['cohort_id'] ?? $_POST['cohort_id'] ?? 0);

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['requirement_id'])) {
	$req = new Requirement();
	if ($req->db_load(array('requirement_id', '=', (int) $_GET['requirement_id']))) {
		$req->db_delete(); // cascades completion rows
		$_SESSION['message'] = 'traitementOK';
	}
	header('Location: ' . BASE . '/requirements?cohort_id=' . $cohortId);
	exit;
}

// Add a new requirement
$libelle = trim($_POST['libelle'] ?? '');
$type = $_POST['response_type'] ?? 'bool';
if ($cohortId > 0 && $libelle !== '' && in_array($type, array('date', 'bool', 'link', 'file'), true)) {
	// next order = max+1 in this cohort
	$res = db_query("SELECT MAX(ordre) AS m FROM planning_requirement WHERE cohort_id = " . val2sql($cohortId));
	$row = db_fetch_array($res);
	$next = ((int) ($row['m'] ?? 0)) + 1;

	$req = new Requirement();
	$req->cohort_id = $cohortId;
	$req->libelle = $libelle;
	$req->response_type = $type;
	$req->ordre = $next;
	$req->actif = 'oui';
	$req->db_save();
	$_SESSION['message'] = 'traitementOK';
}

header('Location: ' . BASE . '/requirements?cohort_id=' . $cohortId);
exit;
