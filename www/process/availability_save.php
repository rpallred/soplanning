<?php

require 'base.inc';
require BASE . '/../config.inc';
require BASE . '/../includes/header.inc';

if (!$user->checkDroit('ressources_all') && !$user->checkDroit('parameters_all')) {
	$_SESSION['erreur'] = 'droitsInsuffisants';
	header('Location: index');
	exit;
}

$crsfRecu = $_GET['crsf'] ?? $_POST['crsf'] ?? '';
if (!isset($_SESSION['CRSF']) || !hash_equals($_SESSION['CRSF'], (string) $crsfRecu)) {
	$_SESSION['erreur'] = 'droitsInsuffisants';
	header('Location: ' . BASE . '/availability');
	exit;
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$resourceId = trim($_GET['resource_id'] ?? $_POST['resource_id'] ?? '');

// normalize an HTML time (HH:MM) to GTime's HH:MM:SS
function toTime($v) { $v = trim((string) $v); return ($v !== '' && strlen($v) === 5) ? $v . ':00' : $v; }

switch ($action) {
	case 'add_window':
		$jour = (int) ($_POST['jour_semaine'] ?? 0);
		if ($resourceId !== '' && $jour >= 1 && $jour <= 7) {
			$a = new Availability();
			$a->resource_id = $resourceId;
			$a->type = 'window';
			$a->jour_semaine = $jour;
			if (trim($_POST['heure_debut'] ?? '') !== '') { $a->heure_debut = toTime($_POST['heure_debut']); }
			if (trim($_POST['heure_fin'] ?? '') !== '') { $a->heure_fin = toTime($_POST['heure_fin']); }
			$a->db_save();
			$_SESSION['message'] = 'traitementOK';
		}
		break;

	case 'add_blackout':
		$d1 = trim($_POST['date_debut'] ?? '');
		$d2 = trim($_POST['date_fin'] ?? '');
		if ($resourceId !== '' && $d1 !== '' && $d2 !== '') {
			$a = new Availability();
			$a->resource_id = $resourceId;
			$a->type = 'blackout';
			$a->date_debut = $d1;
			$a->date_fin = $d2;
			if (trim($_POST['note'] ?? '') !== '') { $a->note = trim($_POST['note']); }
			$a->db_save();
			$_SESSION['message'] = 'traitementOK';
		}
		break;

	case 'set_limits':
		if ($resourceId !== '') {
			// targeted UPDATE (avoids re-validating the whole resource row)
			$mj = trim($_POST['quota_max_jours'] ?? '');
			$val = ($mj !== '' && ctype_digit($mj) && (int) $mj > 0) ? (string) (int) $mj : 'NULL';
			db_query("UPDATE planning_ressource SET quota_max_jours = $val WHERE ressource_id = " . val2sql($resourceId));
			// global limit lives in planning_config
			$mpu = trim($_POST['loan_max_per_user'] ?? '');
			if ($mpu !== '' && ctype_digit($mpu)) {
				$cfg = new Config();
				if ($cfg->db_load(array('cle', '=', 'LOAN_MAX_ACTIVE_PER_USER'))) {
					$cfg->valeur = (int) $mpu;
					$cfg->db_save();
				}
			}
			$_SESSION['message'] = 'traitementOK';
		}
		break;

	case 'set_level':
		if ($resourceId !== '') {
			$lvl = trim($_POST['niveau'] ?? '');
			$allowed = array_keys(getSupervisorLevels());
			$val = in_array($lvl, $allowed, true) ? val2sql($lvl) : 'NULL';
			db_query("UPDATE planning_ressource SET niveau = $val WHERE ressource_id = " . val2sql($resourceId));
			$_SESSION['message'] = 'traitementOK';
		}
		break;

	case 'set_user_link':
		if ($resourceId !== '') {
			$uid = trim($_POST['user_id'] ?? '');
			$val = ($uid !== '') ? val2sql($uid) : 'NULL';
			db_query("UPDATE planning_ressource SET user_id = $val WHERE ressource_id = " . val2sql($resourceId));
			$_SESSION['message'] = 'traitementOK';
		}
		break;

	case 'create_login':
		// One-click: create a login account for this resource (e.g. a supervisor)
		// with sensible defaults, then link it. Keeps the manual pathway too.
		$r = new Ressource();
		if ($resourceId !== '' && $r->db_load(array('ressource_id', '=', $resourceId)) && trim((string) $r->user_id) === '') {
			// unique alphanumeric user_id derived from the resource name
			$base = preg_replace('/[^a-z0-9]/', '', strtolower((string) $r->nom));
			if ($base === '') { $base = preg_replace('/[^a-z0-9]/', '', strtolower($resourceId)); }
			$base = substr($base, 0, 16);
			$uid = $base; $i = 1;
			$probe = new User();
			while ($probe->db_load(array('user_id', '=', $uid))) { $uid = $base . $i; $i++; $probe = new User(); }

			$pw = generateRandomString(10);
			$u = new User();
			$u->user_id = $uid;
			$u->nom = $r->nom;
			$u->login = $uid;
			$u->password = password_hash($pw, PASSWORD_BCRYPT);
			$u->cle = MD5(generateRandomString());
			$u->visible_planning = 'non';        // already shown as a resource; keep the account login-only
			$u->notifications = 'oui';
			$u->login_actif = 'oui';
			$u->date_creation = date('Y-m-d H:i:s');
			$u->setDroits(array('self_service'));
			if ($u->db_save()) {
				db_query("UPDATE planning_ressource SET user_id = " . val2sql($uid) . " WHERE ressource_id = " . val2sql($resourceId));
				$_SESSION['message'] = 'Login created for ' . $r->nom . ' — login: ' . $uid . '   password: ' . $pw . '   (write this down; shown once)';
			} else {
				$_SESSION['erreur'] = 'Could not create the login account.';
			}
		}
		break;

	case 'delete':
		$a = new Availability();
		if ($a->db_load(array('avail_id', '=', (int) ($_GET['avail_id'] ?? 0)))) {
			$resourceId = $resourceId !== '' ? $resourceId : $a->resource_id;
			$a->db_delete();
		}
		break;
}

header('Location: ' . BASE . '/availability?resource_id=' . urlencode($resourceId));
exit;
