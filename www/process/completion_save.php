<?php

require 'base.inc';
require BASE . '/../config.inc';
require BASE . '/../includes/header.inc';

if (!$user->checkDroit('parameters_all')) {
	$_SESSION['erreur'] = 'droitsInsuffisants';
	header('Location: index');
	exit;
}

$crsfRecu = $_POST['crsf'] ?? '';
if (!isset($_SESSION['CRSF']) || !hash_equals($_SESSION['CRSF'], (string) $crsfRecu)) {
	$_SESSION['erreur'] = 'droitsInsuffisants';
	header('Location: ' . BASE . '/completions');
	exit;
}

$subjectType = ($_POST['subject_type'] ?? 'user') === 'resource' ? 'resource' : 'user';
$subjectId = trim($_POST['subject_id'] ?? '');
$cohortId = (int) ($_POST['cohort_id'] ?? 0);

// Iterate the cohort's active requirements and upsert each provided value.
$res = db_query("SELECT * FROM planning_requirement WHERE cohort_id = " . val2sql($cohortId) . " AND actif = 'oui'");
$reqs = array();
while ($r = db_fetch_array($res)) { $reqs[] = $r; }

foreach ($reqs as $req) {
	$rid = (int) $req['requirement_id'];
	$type = $req['response_type'];

	$comp = new Requirement_completion();
	$comp->db_load(array('requirement_id', '=', $rid, 'subject_type', '=', $subjectType, 'subject_id', '=', $subjectId));
	$comp->requirement_id = $rid;
	$comp->subject_type = $subjectType;
	$comp->subject_id = $subjectId;

	$changed = false;

	if ($type === 'file') {
		$field = "file_$rid";
		if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
			$ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
			$allowed = explode(',', CONFIG_WHITELIST_UPLOAD);
			if (in_array($ext, $allowed, true) && $_FILES[$field]['size'] <= MAX_SIZE_UPLOAD) {
				$dir = UPLOAD_DIR . 'completions/';
				if (!is_dir($dir)) { @mkdir($dir, 0775, true); }
				$safeSubject = preg_replace('/[^a-z0-9]/i', '', $subjectId);
				$fname = $rid . '_' . $subjectType . '_' . $safeSubject . '.' . $ext;
				if (move_uploaded_file($_FILES[$field]['tmp_name'], $dir . $fname)) {
					$comp->fichier = $fname;
					$changed = true;
				}
			}
		}
	} else {
		$val = trim($_POST["value_$rid"] ?? '');
		// only treat as a change when something was entered (keeps blanks from clobbering)
		if ($val !== '') {
			$comp->valeur = $val;
			$changed = true;
		}
	}

	if ($changed) {
		$comp->date_completion = date('Y-m-d H:i:s');
		$comp->completed_by = $user->user_id;
		$comp->db_save();
	}
}

$_SESSION['message'] = 'traitementOK';
header('Location: ' . BASE . '/completion_form?subject_type=' . $subjectType . '&subject_id=' . urlencode($subjectId) . '&cohort_id=' . $cohortId);
exit;
