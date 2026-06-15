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
	header('Location: ' . BASE . '/supervision');
	exit;
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$traineeId = trim($_GET['trainee_id'] ?? $_POST['trainee_id'] ?? '');

switch ($action) {
	case 'add_sup':
		$fonction = $_POST['fonction'] ?? 'assigned';
		$supRef = trim($_POST['supervisor_ref'] ?? '');
		$debut = trim($_POST['date_debut'] ?? '');
		if ($traineeId !== '' && $supRef !== '' && $debut !== '' && in_array($fonction, array('assigned', 'individual', 'notes'), true)) {
			$s = new Supervision();
			$s->trainee_id = $traineeId;
			$s->fonction = $fonction;
			$s->supervisor_ref = $supRef;
			$s->date_debut = $debut;
			if (trim($_POST['date_fin'] ?? '') !== '') { $s->date_fin = trim($_POST['date_fin']); }
			if ($fonction === 'individual') {
				$jour = (int) ($_POST['jour_semaine'] ?? 0);
				if ($jour >= 1 && $jour <= 7) { $s->jour_semaine = $jour; }
				// HTML time inputs send HH:MM; GTime requires HH:MM:SS
				$hd = trim($_POST['heure_debut'] ?? '');
				$hf = trim($_POST['heure_fin'] ?? '');
				if ($hd !== '') { $s->heure_debut = (strlen($hd) === 5) ? $hd . ':00' : $hd; }
				if ($hf !== '') { $s->heure_fin = (strlen($hf) === 5) ? $hf . ':00' : $hf; }
			}
			$s->actif = 'oui';
			$s->db_save();
			$_SESSION['message'] = 'traitementOK';
		}
		break;

	case 'del_sup':
		$s = new Supervision();
		if ($s->db_load(array('sup_id', '=', (int) ($_GET['sup_id'] ?? 0)))) { $s->db_delete(); }
		break;

	case 'add_cov':
		$fonction = $_POST['fonction'] ?? 'all';
		$covRef = trim($_POST['covering_ref'] ?? '');
		$debut = trim($_POST['date_debut'] ?? '');
		$fin = trim($_POST['date_fin'] ?? '');
		if ($traineeId !== '' && $covRef !== '' && $debut !== '' && $fin !== '' && in_array($fonction, array('assigned', 'individual', 'notes', 'all'), true)) {
			$c = new Supervision_coverage();
			$c->trainee_id = $traineeId;
			$c->fonction = $fonction;
			$c->covering_ref = $covRef;
			$c->date_debut = $debut;
			$c->date_fin = $fin;
			if (trim($_POST['note'] ?? '') !== '') { $c->note = trim($_POST['note']); }
			$c->db_save();
			$_SESSION['message'] = 'traitementOK';
		}
		break;

	case 'del_cov':
		$c = new Supervision_coverage();
		if ($c->db_load(array('cov_id', '=', (int) ($_GET['cov_id'] ?? 0)))) { $c->db_delete(); }
		break;
}

header('Location: ' . BASE . '/supervision?trainee_id=' . urlencode($traineeId));
exit;
