<?php

require_once('./base.inc');
require_once(BASE . '/../config.inc');

$smarty = new MySmarty();

$version = new Version();
$infoVersion = $version->getVersion();
$smarty->assign('infoVersion', $infoVersion);

$userTmp = new User();
if(!isset($_GET['user_id']) || !$userTmp->db_load(array('user_id', '=', $_GET['user_id']))) {
	$_SESSION['message'] = 'Invalid URL';
	header('Location: index');
	exit;
}

// link is only valid the day it was generated
if(!isset($_GET['date']) || $_GET['date'] !== date('Y-m-d')) {
	$_SESSION['message'] = 'Invalid URL';
	header('Location: index');
	exit;
}

// a user without a personal key cannot have a valid reset link
if(trim((string) $userTmp->cle) === '') {
	$_SESSION['message'] = 'Invalid URL';
	header('Location: index');
	exit;
}

$hashAttendu = hash_hmac('sha256', $userTmp->user_id . '|' . $_GET['date'], $userTmp->cle);
if(!isset($_GET['hash']) || !hash_equals($hashAttendu, (string) $_GET['hash'])) {
	$_SESSION['message'] = 'Invalid URL';
	header('Location: index');
	exit;
}

// variable en session pour securite
$_SESSION['change_password'] = $userTmp->user_id;

$smarty->assign('userTmp', $userTmp->getSmartyData());

$smarty->assign('xajax', $xajax->getJavascript("", "assets/js/xajax.js"));

$smarty->display('www_change_password.tpl');

?>
