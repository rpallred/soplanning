<?php

require 'base.inc';
require BASE . '/../config.inc';
require BASE . '/../includes/header.inc';

$crsfRecu = $_GET['crsf'] ?? $_POST['crsf'] ?? '';
if (!isset($_SESSION['CRSF']) || !hash_equals($_SESSION['CRSF'], (string) $crsfRecu)) {
	$_SESSION['erreur'] = 'droitsInsuffisants';
	header('Location: ' . BASE . '/index');
	exit;
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$me = (string) $user->user_id;
$isManager = $user->checkDroit('ressources_all') || $user->checkDroit('parameters_all');

function back($where, $msg = null, $key = 'erreur') {
	if ($msg !== null) { $_SESSION[$key] = $msg; }
	header('Location: ' . BASE . '/' . $where);
	exit;
}

switch ($action) {
	case 'submit':
		// A self-service user (or a manager) files a request for themselves.
		if (!$user->checkDroit('self_service') && !$isManager) { back('index', 'droitsInsuffisants'); }
		$resourceId = trim($_POST['resource_id'] ?? '');
		$debut = trim($_POST['date_debut'] ?? '');
		$fin = trim($_POST['date_fin'] ?? '');
		if ($resourceId === '' || $debut === '') { back('request_booking', 'Pick a book and a start date.'); }
		$r = new Booking_request();
		$r->user_id = $me;
		$r->resource_id = $resourceId;
		$r->date_debut = $debut;
		if ($fin !== '') { $r->date_fin = $fin; }
		if (trim($_POST['note'] ?? '') !== '') { $r->note = trim($_POST['note']); }
		$r->statut = 'pending';
		$r->created_at = date('Y-m-d H:i:s');
		$r->db_save();
		back('request_booking', 'traitementOK', 'message');
		break;

	case 'approve':
		if (!$isManager) { back('index', 'droitsInsuffisants'); }
		$r = new Booking_request();
		if (!$r->db_load(array('request_id', '=', (int) ($_GET['request_id'] ?? 0)))) { back('request_queue'); }
		if ($r->statut !== 'pending') { back('request_queue', 'That request was already decided.'); }
		// Fulfil by creating a loan — but only if the book is free.
		$busy = db_fetch_array(db_query("SELECT COUNT(*) AS n FROM planning_loan WHERE resource_id = " . val2sql($r->resource_id) . " AND statut = 'out'"));
		if ((int) ($busy['n'] ?? 0) > 0) { back('request_queue', 'That book is currently out — approve again once it is returned.'); }
		$loan = new Loan();
		$loan->resource_id = $r->resource_id;
		$loan->user_id = $r->user_id;
		$loan->date_out = date('Y-m-d');
		if ((string) $r->date_fin !== '') { $loan->date_due = $r->date_fin; }
		$loan->statut = 'out';
		$loan->db_save();
		$r->statut = 'approved';
		$r->decided_by = $me;
		$r->decided_at = date('Y-m-d H:i:s');
		$r->db_save();
		back('request_queue', 'traitementOK', 'message');
		break;

	case 'deny':
		if (!$isManager) { back('index', 'droitsInsuffisants'); }
		$r = new Booking_request();
		if (!$r->db_load(array('request_id', '=', (int) ($_GET['request_id'] ?? $_POST['request_id'] ?? 0)))) { back('request_queue'); }
		if ($r->statut !== 'pending') { back('request_queue', 'That request was already decided.'); }
		$r->statut = 'denied';
		$r->decided_by = $me;
		$r->decided_at = date('Y-m-d H:i:s');
		if (trim($_POST['decision_note'] ?? '') !== '') { $r->decision_note = trim($_POST['decision_note']); }
		$r->db_save();
		back('request_queue', 'traitementOK', 'message');
		break;
}

back('request_queue');
