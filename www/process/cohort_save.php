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
	header('Location: ' . BASE . '/requirements');
	exit;
}

$act = $_GET['action'] ?? $_POST['action'] ?? '';

// Add a person to (or move them into) a cohort.
if ($act === 'add_member') {
	$cohortId = (int) ($_POST['cohort_id'] ?? 0);
	$userId = trim($_POST['user_id'] ?? '');
	if ($cohortId > 0 && $userId !== '') {
		$u = new User();
		if ($u->db_load(array('user_id', '=', $userId))) {
			$u->cohort_id = $cohortId;
			$u->db_save();
			$_SESSION['message'] = 'traitementOK';
		}
	}
	header('Location: ' . BASE . '/completions?cohort_id=' . $cohortId);
	exit;
}

// Remove a person from a cohort (detach).
if ($act === 'remove_member') {
	$cohortId = (int) ($_GET['cohort_id'] ?? 0);
	$userId = trim($_GET['user_id'] ?? '');
	if ($userId !== '') {
		$u = new User();
		if ($u->db_load(array('user_id', '=', $userId))) {
			$u->cohort_id = NULL;
			$u->db_save();
			$_SESSION['message'] = 'traitementOK';
		}
	}
	header('Location: ' . BASE . '/completions?cohort_id=' . $cohortId);
	exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['cohort_id'])) {
	$c = new Cohort();
	if ($c->db_load(array('cohort_id', '=', (int) $_GET['cohort_id']))) {
		$c->db_delete(); // detaches trainees + cascades requirements/completions
		$_SESSION['message'] = 'traitementOK';
	}
	header('Location: ' . BASE . '/requirements');
	exit;
}

// Add a cohort
$libelle = trim($_POST['libelle'] ?? '');
$annee = trim($_POST['annee'] ?? '');
$population = ($_POST['population'] ?? 'trainee') === 'supervisor' ? 'supervisor' : 'trainee';
if ($libelle !== '') {
	$c = new Cohort();
	$c->libelle = $libelle;
	if ($annee !== '') { $c->annee = $annee; }
	$c->population = $population;
	$c->db_save();
	$_SESSION['message'] = 'traitementOK';
	// jump to the new cohort
	$back = new GCollection('Cohort');
	$back->db_load(array('libelle', '=', $libelle));
	$new = $back->fetch();
	header('Location: ' . BASE . '/requirements?cohort_id=' . ($new ? $new->cohort_id : ''));
	exit;
}

header('Location: ' . BASE . '/requirements');
exit;
