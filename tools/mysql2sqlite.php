<?php
/**
 * One-shot migration / schema-generation tool: live MySQL -> SQLite.
 *
 * Introspects the MySQL database (information_schema), creates an equivalent
 * SQLite schema, and copies every row. Runs entirely in PHP using PDO so that
 * raw byte strings (the app stores ISO-8859-1) survive untouched: neither the
 * MySQL driver (connection charset latin1) nor PDO_sqlite transcodes them.
 *
 * Usage:
 *   php tools/mysql2sqlite.php <sqlite-output-path> [--inject-charset-test]
 *
 * The MySQL connection parameters are read from ../database.inc-style values
 * passed via environment, or default to the local dev database.
 */

error_reporting(E_ALL);
ini_set('display_errors', '1');

$out = $argv[1] ?? null;
if (!$out) {
    fwrite(STDERR, "usage: php tools/mysql2sqlite.php <sqlite-output-path> [--inject-charset-test]\n");
    exit(2);
}
$injectTest = in_array('--inject-charset-test', $argv, true);

// ---- MySQL source connection (local dev defaults) ----
$myHost = getenv('SPL_MY_HOST') ?: '127.0.0.1';
$myDb   = getenv('SPL_MY_DB')   ?: 'soplanning';
$myUser = getenv('SPL_MY_USER') ?: 'soplanning';
$myPass = getenv('SPL_MY_PASS');
if ($myPass === false) {
    // fall back to reading database.inc next to the app
    $inc = __DIR__ . '/../database.inc';
    if (is_file($inc)) {
        $cfgPassword = '';
        include $inc;
        $myPass = $cfgPassword;
        $myDb   = getenv('SPL_MY_DB') ?: ($cfgDatabase ?? $myDb);
        $myUser = getenv('SPL_MY_USER') ?: ($cfgUsername ?? $myUser);
        $myHost = getenv('SPL_MY_HOST') ?: ($cfgHostname ?? $myHost);
    }
}

$my = new PDO(
    "mysql:host=$myHost;dbname=$myDb;charset=latin1",
    $myUser,
    $myPass,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

// ---- SQLite target ----
if (file_exists($out)) {
    unlink($out);
}
$lite = new PDO("sqlite:$out", null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$lite->exec('PRAGMA journal_mode=WAL');
$lite->exec('PRAGMA foreign_keys=OFF'); // app manages relations; off avoids load ordering issues

function mapType(string $dataType): string {
    $dataType = strtolower($dataType);
    if (in_array($dataType, ['int','tinyint','smallint','mediumint','bigint','year'], true)) {
        return 'INTEGER';
    }
    if (in_array($dataType, ['decimal','float','double','numeric','real'], true)) {
        return 'REAL';
    }
    return 'TEXT'; // varchar, char, text, date, datetime, time, timestamp, enum, ...
}

// ---- enumerate tables ----
$tables = $my->query(
    "SELECT table_name FROM information_schema.tables
     WHERE table_schema = " . $my->quote($myDb) . " AND table_type='BASE TABLE'
     ORDER BY table_name"
)->fetchAll(PDO::FETCH_COLUMN);

$summary = [];
foreach ($tables as $t) {
    // columns
    $cols = $my->query(
        "SELECT column_name, data_type, column_key, extra, is_nullable, column_default
         FROM information_schema.columns
         WHERE table_schema = " . $my->quote($myDb) . " AND table_name = " . $my->quote($t) . "
         ORDER BY ordinal_position"
    )->fetchAll(PDO::FETCH_ASSOC);
    $cols = array_map(fn($c) => array_change_key_case($c, CASE_LOWER), $cols);

    // primary key columns (in order)
    $pk = $my->query(
        "SELECT column_name FROM information_schema.key_column_usage
         WHERE table_schema = " . $my->quote($myDb) . " AND table_name = " . $my->quote($t) . "
           AND constraint_name = 'PRIMARY' ORDER BY ordinal_position"
    )->fetchAll(PDO::FETCH_COLUMN);

    $singleAutoPk = (count($pk) === 1);
    $defs = [];
    $colNames = [];
    foreach ($cols as $c) {
        $name = $c['column_name'];
        $colNames[] = $name;
        $type = mapType($c['data_type']);
        $isAutoPk = $singleAutoPk
            && $c['column_name'] === $pk[0]
            && stripos($c['extra'], 'auto_increment') !== false;
        if ($isAutoPk) {
            $defs[] = "`$name` INTEGER PRIMARY KEY AUTOINCREMENT";
        } else {
            $defs[] = "`$name` $type";
        }
    }
    // composite or non-auto single PK -> table-level PRIMARY KEY
    $hasInlinePk = false;
    foreach ($defs as $d) { if (stripos($d, 'PRIMARY KEY') !== false) { $hasInlinePk = true; break; } }
    if (!$hasInlinePk && count($pk) > 0) {
        $defs[] = 'PRIMARY KEY (`' . implode('`,`', $pk) . '`)';
    }

    $lite->exec("CREATE TABLE `$t` (\n  " . implode(",\n  ", $defs) . "\n)");

    // copy rows
    $rows = $my->query("SELECT * FROM `$t`");
    $colList = '`' . implode('`,`', $colNames) . '`';
    $place   = implode(',', array_fill(0, count($colNames), '?'));
    $ins = $lite->prepare("INSERT INTO `$t` ($colList) VALUES ($place)");
    $lite->beginTransaction();
    $n = 0;
    while ($r = $rows->fetch(PDO::FETCH_NUM)) {
        $ins->execute($r);
        $n++;
    }
    $lite->commit();
    $summary[$t] = $n;
}

// ---- indexes (non-unique + unique, skip primary) ----
foreach ($tables as $t) {
    $idx = $my->query(
        "SELECT index_name, non_unique, GROUP_CONCAT(column_name ORDER BY seq_in_index) AS cols
         FROM information_schema.statistics
         WHERE table_schema = " . $my->quote($myDb) . " AND table_name = " . $my->quote($t) . "
           AND index_name <> 'PRIMARY'
         GROUP BY index_name, non_unique"
    )->fetchAll(PDO::FETCH_ASSOC);
    $idx = array_map(fn($r) => array_change_key_case($r, CASE_LOWER), $idx);
    foreach ($idx as $ix) {
        $uniq = $ix['non_unique'] == 0 ? 'UNIQUE' : '';
        $cols = '`' . str_replace(',', '`,`', $ix['cols']) . '`';
        $iname = $t . '_' . $ix['index_name'];
        try {
            $lite->exec("CREATE $uniq INDEX `$iname` ON `$t` ($cols)");
        } catch (PDOException $e) {
            fwrite(STDERR, "  (skipped index $iname: " . $e->getMessage() . ")\n");
        }
    }
}

// ---- optional charset round-trip probe ----
if ($injectTest) {
    // raw ISO-8859-1 bytes: "Café Tëst — Gómez ñ" exactly as the app would store them
    $accented = "Caf\xE9 T\xEBst \x96 G\xF3mez \xF1";
    $stmt = $lite->prepare(
        "INSERT INTO planning_user
         (user_id, nom, couleur, cle, visible_planning, notifications, login_actif, date_creation)
         VALUES ('chartest', ?, '000000', 'x', 'oui', 'non', 'non', datetime('now'))"
    );
    $stmt->execute([$accented]);
    // read back and report the byte sequence
    $back = $lite->query("SELECT nom FROM planning_user WHERE user_id='chartest'")->fetchColumn();
    fwrite(STDERR, "charset probe stored bytes: " . bin2hex($accented) . "\n");
    fwrite(STDERR, "charset probe read   bytes: " . bin2hex($back) . "\n");
    fwrite(STDERR, "charset probe round-trips:  " . ($back === $accented ? "YES" : "NO") . "\n");
}

echo "Migrated to: $out\n";
foreach ($summary as $t => $n) {
    printf("  %-30s %d rows\n", $t, $n);
}
echo "Tables: " . count($summary) . "\n";
