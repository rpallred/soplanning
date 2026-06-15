<?php
/**
 * First-run / data-location setup for the desktop build.
 *
 * Self-contained (no DB, no auth, no Smarty) so it runs before any database
 * exists. Lets the user choose where the SQLite data file lives (e.g. their
 * OneDrive folder) and either create a new database there or open an existing
 * one. Reached automatically when no data location is configured.
 */

require('./base.inc');
require(BASE . '/../includes/desktop.inc');
require(BASE . '/../includes/class_version.inc');

$version = new Version();
$current = desktop_get_data_path();
$suggest = desktop_suggest_folder();
$message = $_GET['msg'] ?? '';
$adminPw = $_GET['pw'] ?? '';

header('Content-Type: text/html; charset=utf-8');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SOPlanning — Data Location Setup</title>
	<style>
		body { font-family: -apple-system, Segoe UI, Roboto, sans-serif; max-width: 720px; margin: 40px auto; padding: 0 20px; color: #222; }
		h1 { font-size: 22px; } h2 { font-size: 17px; margin-top: 28px; }
		.box { border: 1px solid #ddd; border-radius: 8px; padding: 18px; margin: 16px 0; }
		label { display: block; font-weight: 600; margin-bottom: 6px; }
		input[type=text] { width: 100%; padding: 8px; border: 1px solid #bbb; border-radius: 5px; box-sizing: border-box; }
		button { background: #2196f3; color: #fff; border: 0; padding: 9px 16px; border-radius: 5px; cursor: pointer; font-size: 14px; }
		button.alt { background: #607d8b; }
		.muted { color: #777; font-size: 13px; }
		.msg { background: #e8f5e9; border: 1px solid #a5d6a7; padding: 12px; border-radius: 6px; }
		.pw { background: #fff8e1; border: 1px solid #ffe082; padding: 12px; border-radius: 6px; font-family: monospace; }
		code { background: #f5f5f5; padding: 1px 4px; border-radius: 3px; }
	</style>
</head>
<body>
	<h1>SOPlanning — Data Location</h1>
	<p class="muted">Choose where your data file lives. To use it across your own computers, put it
	in a synced folder such as OneDrive — but only open the app on one machine at a time.</p>

	<?php if ($message === 'created'): ?>
		<div class="msg">Database created. <a href="<?php echo BASE; ?>/">Open SOPlanning &raquo;</a></div>
		<?php if ($adminPw !== ''): ?>
			<div class="pw">Your admin login is <b>admin</b> with password <b><?php echo htmlspecialchars($adminPw); ?></b><br>
			Write this down now — it is shown only once.</div>
		<?php endif; ?>
	<?php elseif ($message === 'opened'): ?>
		<div class="msg">Data location set. <a href="<?php echo BASE; ?>/">Open SOPlanning &raquo;</a></div>
	<?php elseif ($message === 'error'): ?>
		<div class="msg" style="background:#ffebee;border-color:#ef9a9a;"><?php echo htmlspecialchars($_GET['detail'] ?? 'Something went wrong.'); ?></div>
	<?php endif; ?>

	<?php if ($current): ?>
		<p>Current data file: <code><?php echo htmlspecialchars($current); ?></code>
		<?php echo is_file($current) ? '' : '<span class="muted">(file not found — set a new location below)</span>'; ?></p>
	<?php endif; ?>

	<div class="box">
		<h2>Create a new database</h2>
		<form method="POST" action="<?php echo BASE; ?>/process/setup_save">
			<input type="hidden" name="action" value="create">
			<label for="folder1">Folder to store the data file in</label>
			<input type="text" id="folder1" name="folder" value="<?php echo htmlspecialchars($suggest); ?>" placeholder="/path/to/OneDrive/SOPlanning">
			<p class="muted">A file named <code>soplanning.sqlite</code> will be created here.</p>
			<button type="submit">Create database here</button>
		</form>
	</div>

	<div class="box">
		<h2>Use an existing database</h2>
		<form method="POST" action="<?php echo BASE; ?>/process/setup_save">
			<input type="hidden" name="action" value="open">
			<label for="path2">Full path to an existing <code>soplanning.sqlite</code></label>
			<input type="text" id="path2" name="path" placeholder="<?php echo htmlspecialchars($suggest); ?>/SOPlanning/soplanning.sqlite">
			<button type="submit" class="alt">Use this database</button>
		</form>
	</div>
</body>
</html>
