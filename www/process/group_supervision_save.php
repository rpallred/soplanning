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
	header('Location: ' . BASE . '/group_supervision');
	exit;
}

function backToGroups($msg = null) {
	if ($msg !== null) { $_SESSION['erreur'] = $msg; }
	header('Location: ' . BASE . '/group_supervision');
	exit;
}
function levelOf($resourceId) {
	$res = db_query("SELECT niveau FROM planning_ressource WHERE ressource_id = " . val2sql($resourceId));
	$row = db_fetch_array($res);
	return $row ? (string) $row['niveau'] : '';
}
function toTime($v) { $v = trim((string) $v); return ($v !== '' && strlen($v) === 5) ? $v . ':00' : $v; }

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
	case 'add_group':
		$libelle = trim($_POST['libelle'] ?? '');
		$leadRef = trim($_POST['lead_ref'] ?? '');
		if ($libelle === '' || $leadRef === '') { backToGroups('A name and a group leader are required.'); }
		// The leader must be cleared to lead a group (BHC I and up).
		if (!supervisorCapabilities(levelOf($leadRef))['lead_group']) {
			backToGroups('That supervisor (' . htmlspecialchars(supervisorLevelLabel(levelOf($leadRef))) . ') is not cleared to lead a group (BHC I and up).');
		}
		$g = new Group_session();
		$g->libelle = $libelle;
		$g->lead_ref = $leadRef;
		$jour = (int) ($_POST['jour_semaine'] ?? 0);
		if ($jour >= 1 && $jour <= 7) { $g->jour_semaine = $jour; }
		if (trim($_POST['heure_debut'] ?? '') !== '') { $g->heure_debut = toTime($_POST['heure_debut']); }
		if (trim($_POST['heure_fin'] ?? '') !== '') { $g->heure_fin = toTime($_POST['heure_fin']); }
		if (trim($_POST['date_debut'] ?? '') !== '') { $g->date_debut = trim($_POST['date_debut']); }
		if (trim($_POST['date_fin'] ?? '') !== '') { $g->date_fin = trim($_POST['date_fin']); }
		$g->actif = 'oui';
		$g->db_save();
		$_SESSION['message'] = 'traitementOK';
		break;

	case 'del_group':
		$g = new Group_session();
		if ($g->db_load(array('group_id', '=', (int) ($_GET['group_id'] ?? 0)))) { $g->db_delete(); }
		break;

	case 'add_member':
		$groupId = (int) ($_POST['group_id'] ?? 0);
		$traineeId = trim($_POST['trainee_id'] ?? '');
		if ($groupId > 0 && $traineeId !== '') {
			$m = new Group_member();
			if (!$m->db_load(array('group_id', '=', $groupId, 'trainee_id', '=', $traineeId))) {
				$m->group_id = $groupId;
				$m->trainee_id = $traineeId;
				$m->db_save();
			}
			$_SESSION['message'] = 'traitementOK';
		}
		break;

	case 'del_member':
		$groupId = (int) ($_GET['group_id'] ?? 0);
		$traineeId = trim($_GET['trainee_id'] ?? '');
		if ($groupId > 0 && $traineeId !== '') {
			db_query("DELETE FROM planning_group_member WHERE group_id = " . $groupId . " AND trainee_id = " . val2sql($traineeId));
		}
		break;
}

backToGroups();
