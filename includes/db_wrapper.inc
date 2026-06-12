<?php

// default port for mysql
// not in database.inc for compliance with existing installs who won't update database.inc
$cfgDBPort = '3306';

/**
 * Result handle for the SQLite backend.
 *
 * PDO statements are forward-only, but the rest of the app expects mysqli-style
 * random access (db_num_rows / db_result / db_data_seek). We therefore buffer
 * the whole result set into an array and emulate a cursor over it. Result sizes
 * in this app are small, so the memory cost is negligible.
 */
class SqliteResult
{
	public $rows;
	public $cursor = 0;
	public function __construct(array $rows) { $this->rows = $rows; }
}

function db_connect($cfgHostname, $cfgUsername, $cfgPassword, $cfgDatabase, $cfgSqlType, $cfgDBPort)
{
	global $cfgConnection, $cfgSqliteFile;
	switch ($cfgSqlType) {
		case 'sqlite':
			// For SQLite the "database" is a file path: prefer $cfgSqliteFile,
			// otherwise reuse $cfgDatabase as the path.
			$file = (isset($cfgSqliteFile) && $cfgSqliteFile !== '') ? $cfgSqliteFile : $cfgDatabase;
			try {
				$cfgConnection = new PDO('sqlite:' . $file);
				$cfgConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
				$cfgConnection->exec('PRAGMA foreign_keys=ON');
				$cfgConnection->exec('PRAGMA busy_timeout=5000');
				$cfgConnection->exec('PRAGMA journal_mode=WAL');
			} catch (Exception $e) {
				return false;
			}
			return $cfgConnection;
		case 'mysql':
			try {
				$cfgConnection = @mysqli_connect($cfgHostname, $cfgUsername, $cfgPassword, '', $cfgDBPort);
			} catch (Exception $e) {
				return false;
			}
			break;
	}
	if (!$cfgConnection) {
		//die("<br /><font color=\"RED\"><b>Error</b> : Unable to connect to database. Please verify parameters.</font><br /><br />\n");
		return false;
	}
	mysqli_set_charset($cfgConnection, "latin1");
	if(!mysqli_select_db($cfgConnection, $cfgDatabase)){
		return false;
	}
	return $cfgConnection;
}

                                       
function db_close()
{
	global $cfgConnection, $cfgSqlType;
	if (isset($cfgConnection)) {
		switch ($cfgSqlType) {
			case 'mysql':
				mysqli_close($cfgConnection);
				break;
			case 'psql':
				pg_close($cfgConnection);
				break;
			case 'sqlite':
				$cfgConnection = null;
				break;
			default:
				break;
		}
		unset($GLOBALS['cfgConnection']);
	}
}


function db_query($query)
{
	global $cfgDatabase, $cfgConnection, $cfgSqlType, $cfgPrefix;
//	
	if($cfgPrefix != 'planning_') {
		$query = str_replace('planning_', $cfgPrefix, $query);
	}
	if(DEBUG) {
		//file_put_contents(BASE . '/../debug.txt', $query . "\r\n", FILE_APPEND);
	}

	if ($cfgSqlType === 'sqlite') {
		$stmt = $cfgConnection->query($query);
		if ($stmt === false) {
			$err = $cfgConnection->errorInfo();
			@file_put_contents(BASE . '/../debug.txt', date('Y-m-d H:i:s') . ' - ' . ($err[2] ?? '') . ' - ' . $query . "\r\n", FILE_APPEND);
			if (DEBUG) {
				echo "<br /><font color=\"RED\"><b>Error</b> : querying database failed :</font><br />\n<font color=\"GRAY\">\n$query\n</font><br /><br />\n";
				echo '<br>Error : ' . ($err[2] ?? '');
			}
			return false;
		}
		// A statement that produced columns is a result set; otherwise it was a
		// write (INSERT/UPDATE/DELETE/DDL) -> mimic mysqli by returning true.
		if ($stmt->columnCount() > 0) {
			return new SqliteResult($stmt->fetchAll(PDO::FETCH_ASSOC));
		}
		return true;
	}

	try {
		$result = mysqli_query($cfgConnection, $query);
	} catch (Exception $e) {
		@file_put_contents(BASE . '/../debug.txt', date('Y-m-d H:i:s') . ' - ' . $query . "\r\n", FILE_APPEND);
		if(DEBUG) {
			echo '<pre>';
			print_r(debug_backtrace());
			echo '</pre>';
			echo "<br /><font color=\"RED\"><b>Error</b> : querying database failed :</font><br />\n<font color=\"GRAY\">\n$query\n</font><br /><br />\n";
			echo '<br>Error : ' . mysqli_error($cfgConnection);
		}
	}
	if(!$result){
		@file_put_contents(BASE . '/../debug.txt', date('Y-m-d H:i:s') . ' - ' . $query . "\r\n", FILE_APPEND);
		if(DEBUG) {
			echo '<pre>';
			print_r(debug_backtrace());
			echo '</pre>';
			echo "<br /><font color=\"RED\"><b>Error</b> : querying database failed :</font><br />\n<font color=\"GRAY\">\n$query\n</font><br /><br />\n";
			echo '<br>Error : ' . mysqli_error($cfgConnection);
		}
	}

	return $result;
}


function db_num_rows($handle = 0)
{
	global $cfgSqlType;
	switch ($cfgSqlType) {
		case 'sqlite':
			return ($handle instanceof SqliteResult) ? count($handle->rows) : 0;
			break;
		case 'mysql':
			return ($handle) ? mysqli_num_rows($handle) : mysqli_num_rows();
			break;
		default:
			return ($handle);
			break;
	}
}

function db_result($handle, $row, $field)
{
	global $cfgSqlType;
	switch ($cfgSqlType) {
		case 'sqlite':
			if ($handle instanceof SqliteResult && isset($handle->rows[$row])) {
				$r = $handle->rows[$row];
				if (is_int($field)) { $vals = array_values($r); return $vals[$field] ?? null; }
				return $r[$field] ?? null;
			}
			return null;
			break;
		case 'mysql':
			return mysqli_result($handle, $row, $field);
			break;
		case 'psql':
			return pg_fetch_result($handle, $row, $field);
			break;
		default:
			break;
	}
	return true;
}


function db_fetch_array($handle)
{
	global $cfgSqlType, $cfgConnection;
	switch ($cfgSqlType) {
		case 'sqlite':
			if ($handle instanceof SqliteResult && isset($handle->rows[$handle->cursor])) {
				return $handle->rows[$handle->cursor++];
			}
			return false;
			break;
		case 'mysql':
			$value = mysqli_fetch_array($handle, MYSQLI_ASSOC);
			return $value;
			break;
		case 'psql':
			$value =  pg_fetch_array($handle);
			return $value;
			break;
		default:
			return ($handle);
			break;
	}
}


function db_data_seek($handle, $row)
{
	global $cfgSqlType;
	switch ($cfgSqlType) {
		case 'sqlite':
			if ($handle instanceof SqliteResult) { $handle->cursor = $row; }
			return True;
			break;
		case 'mysql':
			return mysqli_data_seek($handle, $row);
			break;
		default:
			return True;
			break;
	}
}


