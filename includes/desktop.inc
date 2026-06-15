<?php
/**
 * Desktop / portable build support.
 *
 * The data lives in a single SQLite file that the user keeps in a synced
 * folder (OneDrive/SharePoint). This module manages:
 *   - where that file is (a small JSON config that travels with the app, NOT
 *     in database.inc which can be overwritten on update);
 *   - automatic timestamped backups beside the data file (throttled + pruned);
 *   - a single-instance "soft lock" so the file is not opened live on two
 *     machines at once (the corruption case for synced DB files).
 *
 * All functions are dependency-free (no DB, no Smarty) so they can run during
 * the first-run flow before any database exists.
 */

// Config file that records the chosen SQLite path. Lives with the app.
function desktop_config_file()
{
	return BASE . '/../data-location.json';
}

function desktop_get_data_path()
{
	$f = desktop_config_file();
	if (!is_file($f)) {
		return null;
	}
	$j = json_decode((string) file_get_contents($f), true);
	$p = $j['sqlite_path'] ?? null;
	return ($p !== null && $p !== '') ? $p : null;
}

function desktop_set_data_path($path)
{
	return (bool) file_put_contents(
		desktop_config_file(),
		json_encode(array('sqlite_path' => $path), JSON_PRETTY_PRINT)
	);
}

/**
 * Back up the SQLite file beside itself, at most once per $throttleHours,
 * keeping the most recent $maxKeep copies. Returns the backup path or false.
 */
function desktop_backup($file, $maxKeep = 10, $throttleHours = 6)
{
	if (!is_file($file)) {
		return false;
	}
	$dir = dirname($file) . '/backups';
	if (!is_dir($dir)) {
		@mkdir($dir, 0775, true);
	}
	$existing = glob($dir . '/soplanning-*.sqlite');
	if (!empty($existing)) {
		$newest = max(array_map('filemtime', $existing));
		if ((time() - $newest) < ($throttleHours * 3600)) {
			return false; // a recent backup already exists
		}
	}
	$dest = $dir . '/soplanning-' . date('Ymd-His') . '.sqlite';
	if (!@copy($file, $dest)) {
		return false;
	}
	// prune oldest beyond $maxKeep
	$all = glob($dir . '/soplanning-*.sqlite');
	if (count($all) > $maxKeep) {
		usort($all, fn($a, $b) => filemtime($a) - filemtime($b));
		foreach (array_slice($all, 0, count($all) - $maxKeep) as $old) {
			@unlink($old);
		}
	}
	return $dest;
}

function desktop_lock_file($file)
{
	return $file . '.lock';
}

/**
 * Return the active lock holder (host/pid/ts array) if another live instance
 * holds the file, else null. A lock older than $staleMinutes is ignored.
 */
function desktop_check_lock($file, $staleMinutes = 10)
{
	$lf = desktop_lock_file($file);
	if (!is_file($lf)) {
		return null;
	}
	$data = json_decode((string) file_get_contents($lf), true);
	if (!is_array($data) || !isset($data['ts'])) {
		return null;
	}
	if ((time() - (int) $data['ts']) > ($staleMinutes * 60)) {
		return null; // stale -> treat as free
	}
	return $data;
}

// Take/refresh the lock for this host+process.
function desktop_acquire_lock($file)
{
	return (bool) file_put_contents(
		desktop_lock_file($file),
		json_encode(array('host' => gethostname(), 'pid' => getmypid(), 'ts' => time()))
	);
}

function desktop_release_lock($file)
{
	$lf = desktop_lock_file($file);
	if (is_file($lf)) {
		@unlink($lf);
	}
	return true;
}

// Best-effort detection of the user's OneDrive folder, to suggest a default.
function desktop_suggest_folder()
{
	foreach (array('OneDrive', 'OneDriveConsumer', 'OneDriveCommercial') as $env) {
		$v = getenv($env);
		if ($v && is_dir($v)) {
			return $v;
		}
	}
	$home = getenv('HOME') ?: (getenv('USERPROFILE') ?: '');
	foreach (array('/Library/CloudStorage', '/OneDrive') as $sub) {
		if ($home && is_dir($home . $sub)) {
			return $home . $sub;
		}
	}
	return $home;
}
