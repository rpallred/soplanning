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
