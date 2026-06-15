<?php
/**
 * Handles the first-run data-location setup (desktop build). No DB/auth — this
 * runs before a database exists. Creates a new SQLite database or points at an
 * existing one, records the location, then redirects to /setup with a result.
 */

require 'base.inc';
require BASE . '/../includes/desktop.inc';
require BASE . '/../includes/class_version.inc';

$version = new Version();
$action = $_POST['action'] ?? '';

function back($msg, $extra = '')
{
	header('Location: ' . BASE . '/setup?msg=' . urlencode($msg) . $extra);
	exit;
}

if ($action === 'create') {
	$folder = rtrim(trim($_POST['folder'] ?? ''), '/');
	if ($folder === '') {
		back('error', '&detail=' . urlencode('Please provide a folder.'));
	}
	if (!is_dir($folder)) {
		if (!@mkdir($folder, 0775, true)) {
			back('error', '&detail=' . urlencode('Could not create folder: ' . $folder));
		}
	}
	if (!is_writable($folder)) {
		back('error', '&detail=' . urlencode('Folder is not writable: ' . $folder));
	}
	$path = $folder . '/soplanning.sqlite';
	if (file_exists($path)) {
		back('error', '&detail=' . urlencode('A database already exists there. Use "open" instead.'));
	}
	$res = $version->installSqlite($path);
	if (!$res['ok']) {
		back('error', '&detail=' . urlencode('Install failed: ' . $res['error']));
	}
	desktop_set_data_path($path);
	back('created', '&pw=' . urlencode($res['admin_password']));
}

if ($action === 'open') {
	$path = trim($_POST['path'] ?? '');
	if ($path === '' || !is_file($path)) {
		back('error', '&detail=' . urlencode('File not found: ' . $path));
	}
	desktop_set_data_path($path);
	back('opened');
}

back('error', '&detail=' . urlencode('Unknown action.'));
