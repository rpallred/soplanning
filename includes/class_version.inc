<?php
class Version
{
	public function __construct() {
	}

	public function getVersion() {
		return trim(file_get_contents(BASE . '/../version.txt'));
	}

	public function checkInstall($checkWritable = false, $checkGD = true) {
		$errors = array();

		if($this->checkDBAccess() !== TRUE) {
			$errors['checkDBAccess'] = $this->checkDBAccess();
		} else {
			if($this->checkDatabaseVersion() !== TRUE) {
				$errors['checkDatabaseVersion'] = $this->checkDatabaseVersion();
				if($errors['checkDatabaseVersion'] == 'database_upgrade_required') {
					$errors['databaseUpgradeResult'] = $this->upgradeVersion();
				}
			}
		}

		if($this->checkPhpVersion() !== TRUE) {
			$errors['checkPhpVersion'] = $this->checkPhpVersion();
		}

		if($checkWritable && $this->checkWritable() !== TRUE) {
			$errors['checkWritable'] = $this->checkWritable();
		}

		if($checkWritable && $this->checkWritableDatabaseInc() !== TRUE) {
			$errors['checkWritableDatabaseInc'] = $this->checkWritableDatabaseInc();
		}

		if($checkGD && $this->checkGD() !== TRUE) {
			$errors['checkGD'] = $this->checkGD();
		}

		// if more than one error/probleme in the checks, redirect to install/upgrade page
		if(count($errors) > 0) {
			return $errors;
		}
		return true;
	}

	// check de la version en ligne
	public function checkAvailableVersion() {
		global $lang;
		$infos = array();
		$context = @stream_context_create(array('http' => array('header'=>'Connection: close', 'timeout' => 3, 'user_agent' => 'Mozilla/5.0')));
		$url = 'https://www.soplanning.org/ws/version.php?version_install=' . $this->getVersion() . '&type=' . encrypt('sop-2025-03-13', php_uname()) . '&lang=' . $lang;
		//echo $url;die;
		$data = @file_get_contents($url, false, $context);
		if(strlen($data) == 0) {
			return false;
		}
		$infos = array(
			'titre' => '',
			'version_install' => $this->getVersion()
		);
		$data = @unserialize(base64_decode($data));
		if(!$data) {
			return false;
		}
		$infos = array_merge($infos, $data);
		return $infos;
	}


	// creation et import initial de la base
	public function importDatabase() {
		global $cfgHostname, $cfgUsername, $cfgPassword, $cfgDatabase, $cfgSqlType, $cfgConnection, $cfgPrefix, $smarty, $cfgDBPort;

		$tempConnect = db_connect($cfgHostname, $cfgUsername, $cfgPassword, $cfgDatabase, $cfgSqlType, $cfgDBPort);

		if((isset($tempConnect->error) && $tempConnect->error != '') || $tempConnect === FALSE) {

			try {
				$cfgConnectionTest = mysqli_connect($cfgHostname, $cfgUsername, $cfgPassword);
				mysqli_set_charset($cfgConnectionTest, "latin1");
			} catch (Exception $e) {
				return 'database_creation_failed';
			}
			
			if(!mysqli_query($cfgConnection, 'CREATE DATABASE `' . $cfgDatabase . '` DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci;')) {
			return 'database_creation_failed';
			}

			$cfgConnection = null;
			$tempConnect = db_connect($cfgHostname, $cfgUsername, $cfgPassword, $cfgDatabase, $cfgSqlType, $cfgDBPort);
			if($tempConnect === FALSE) {
				return 'database_connection_failed';
			}		}
		$sql = file(BASE . '/../sql/planning_mysql.sql');
		$requetes="";
		foreach($sql as $l){ // on lit le fichier sql
			if (substr(trim($l),0,2)!="--"){ // suppression des commentaires
				$requetes .= $l;
			}
		}

		// ecriture du fichier database.inc
		$contenuFichier = '<?php' . CRLF . CRLF . '// Database Parameters' . CRLF . '$cfgHostname = \'' . $cfgHostname . '\';' . CRLF . '$cfgDatabase = \'' . $cfgDatabase . '\';' . CRLF . '$cfgUsername = \'' . $cfgUsername . '\';' . CRLF . '$cfgPassword = \'' . $cfgPassword . '\';' . CRLF . '$cfgSqlType = \'mysql\';' . CRLF . '$cfgPrefix = \'' . $cfgPrefix . '\';' . CRLF . '?>';
		if(!file_put_contents(BASE . '/../database.inc', $contenuFichier)) {
			echo 'ok';die;

			return 'database_config_file_failed';
		}

		$reqs = explode(";",$requetes);// on s�pare les requetes
		foreach($reqs as $req){
			if (trim($req) != "" && !db_query($req)){
				if(strpos(mysqli_error($cfgConnection), "already exists") !== FALSE) {
					// si base de donnes deja existante, on lance pas d'erreur et on passe �  la mise � jour du fichier de DB
					break;
				} else {
					return 'database_init_failed';
				}
			}
		}

		$this->installDemoData();

		return true;
	}


	public function upgradeVersion() {
		// smarty compiled dir clean
		$files = @glob(COMPIL_DIR . '*');
		if(is_array($files)){
			foreach ($files as $file){
				@unlink($file);
			}
		}

		global $cfgConnection, $cfgSqlType, $cfgDatabase, $smarty;

		if($cfgSqlType != 'mysql') {
			return false;
		}

		// detection de la version de la base. Si derniere version install?e, on ne met pas ? jour avec tous les upgrades
		$infoVersion = $this->getVersion();
		$config = new Config();
		$result = db_query("show tables from `$cfgDatabase` like 'planning_config'");
		if(db_num_rows($result) == 0) {
			$result = db_query("show tables from `$cfgDatabase` like 'planning_periode'");
			if(db_num_rows($result) == 0) {
				die('<br>Your database seems empty or the user "$cfgUsername" do not have enough rights in mysql. Please import soplanning/sql/planning_mysql.sql in your database');
			}
			$versionDemarrage = 11800;
		} elseif ($config->db_load(array('cle', '=', 'CURRENT_VERSION')) && $infoVersion == $config->valeur) {
			return true;
		} elseif(!is_null($config->valeur)) {
			$versionDemarrage = (int)str_replace('.', '', $config->valeur);
			$tmp = explode('.', $config->valeur);
			if(count($tmp) == 2){
				$versionDemarrage .= '00';
			}
		} else {
			$versionDemarrage = 11900;
		}
		$versionDemarrage+= 1;

		$output = '';
		$upgradeSqlTrouve = false;

		for ($tmpVersion = $versionDemarrage; $tmpVersion <= str_replace('.', '', $infoVersion); $tmpVersion = $tmpVersion+1) {
			$tmpVersionFinal = $this->versionFormatee($tmpVersion);

			if($tmpVersion == 14500){
				$fichierSQL = BASE . '/../sql/update/update-1-45-00.txt';
			} elseif($tmpVersion < 14500){
				$versionFin = substr($tmpVersion, 3,2);
				if($versionFin != 0){
					continue;
				}
				$versionDebut = substr($tmpVersion, 0,3);

				$fichierSQL = BASE . '/../sql/update/update-' . str_replace('.', '-', $this->versionFormatee($versionDebut)) . '.txt';			
			} else{
				$fichierSQL = BASE . '/../sql/update/update-' . str_replace('.', '-', $tmpVersionFinal) . '.txt';
			}

			if (is_file($fichierSQL)) {
				$output .= '<br>Upgrading to version ' . $tmpVersionFinal;
				$upgradeSqlTrouve = true;
				$sql = file($fichierSQL);
				$requetes="";
				foreach($sql as $l){ // on lit le fichier sql
					if (substr(trim($l),0,2)!="--"){ // suppression des commentaires
						$requetes .= $l;
					}
				}
				$reqs = explode(";",$requetes);// on s�pare les requetes
				foreach($reqs as $req){	// et on les execute
					//echo '<br>' . $req . '<br>';

					if (trim($req)!= "" && !db_query($req)){
						$output .= "<br>Failed to upgrade database, please contact <a href='mailto:support@soplanning.org'>support@soplanning.org</a> with full details."; // stop si erreur
						$output .= '<br/>upgrade failed :<br/> ' . $tmpVersionFinal;
						$output .= '<br/>request failed :<br/> ' . $req;
						return $output;
					}
				}
				$output .= '<br>Database upgrade ok for version ' . $tmpVersionFinal;

				$config = new Config();
				$config->db_load(array('cle', '=', 'CURRENT_VERSION'));
				$config->cle = 'CURRENT_VERSION';
				$config->valeur = $tmpVersionFinal;
				$config->db_save();
			}
		}

		if (!$upgradeSqlTrouve) {
			// si aucune MAJ trouvee, on met juste � jour l'info de la version courante
			$config = new Config();
			$config->db_load(array('cle', '=', 'CURRENT_VERSION'));
			$config->cle = 'CURRENT_VERSION';
			$config->valeur = $infoVersion;
			$config->db_save();
			return 'Database upgrade ok';
		}

		return $output;
	}

	public function checkDatabaseVersion() {
		global $cfgDatabase, $cfgSqlType, $cfgPrefix;
		$infoVersion = $this->getVersion();
		if ($cfgSqlType === 'sqlite') {
			$configTable = $cfgPrefix . 'config';
			$result = db_query("SELECT name FROM sqlite_master WHERE type='table' AND name='" . $configTable . "'");
		} else {
			$result = db_query("show tables from `$cfgDatabase` like 'planning_config'");
		}
		if(db_num_rows($result) == 0) {
			// base probablement vide
			return 'database_empty';
		}
		$config = new Config();
		$res = $config->db_load(array('cle', '=', 'CURRENT_VERSION'));
		if ($infoVersion == $config->valeur) {
			return true;
		} else {
			return 'database_upgrade_required';
		}
	}

	public function checkDBAccess() {
		
		global $cfgHostname, $cfgUsername, $cfgPassword, $cfgDatabase, $cfgSqlType, $cfgDBPort;
		if(@db_connect($cfgHostname, $cfgUsername, $cfgPassword, $cfgDatabase, $cfgSqlType, $cfgDBPort) === FALSE) {
			return 'database_connection_error';
		}
		return true;
	}

	public function checkPhpVersion() {
		$version = phpversion();
		if($version < '7.2') {
			return 'php_too_old';
		}
		if (function_exists('apache_get_modules') && !in_array('mod_rewrite', apache_get_modules())) {
			return 'please activate mod_rewrite on apache';
		}
	return true;
	}


	public function checkWritable() {
		if(!is__writable(COMPIL_DIR)) {
			die('<br/><br/><center><b>Error : please add read/write rights on "' . COMPIL_DIR . '" directory</b></center>');
		}
		if(!is__writable(UPLOAD_DIR)) {
			die('<br/><br/><center><b>Error : please add read/write rights on "' . UPLOAD_DIR . '" directory</b></center>');
		}
		return true;
	}

	public function checkWritableDatabaseInc() {
		$test = @file_get_contents(BASE . '/../database.inc');
		if($test === FALSE) {
			return 'rights_database_inc';
		}
		$result = @file_put_contents(BASE . '/../database.inc', $test);
		if($result === FALSE) {
			return 'rights_database_inc';
		}
		return true;
	}

	private function versionFormatee($version) {
		if(strlen($version) == 5){
			$tmpVersionFinal = substr($version, 0,1) . '.' . substr($version, 1, 2) . '.' . substr($version, 3, 2);
		} else{
			$tmpVersionFinal = substr($version, 0,1) . '.' . substr($version, 1, 2);	
		}
		return $tmpVersionFinal;
	}

	private function checkGD() {
		if (extension_loaded('gd') && function_exists('gd_info')) {
			return true;
		}
		return 'gd_missing';
	}

	private function installDemoData(){
		$file = BASE . "/../includes/demo_data.inc";
		include_once($file);
		return true;
	}

	/**
	 * Create a fresh SQLite database for a portable/desktop install.
	 *
	 * Self-contained (uses raw PDO so it does not depend on the web bootstrap):
	 * builds the schema from sql/planning_sqlite.sql, generates the security
	 * secrets with a CSPRNG, and seeds an admin account plus the default task
	 * statuses. No demo people/projects are created.
	 *
	 * @param  string $filePath  absolute path of the SQLite file to create
	 * @return array  ['ok'=>bool, 'admin_password'=>string, 'error'=>string]
	 */
	public function installSqlite($filePath)
	{
		$schemaFile = BASE . '/../sql/planning_sqlite.sql';
		if (!is_file($schemaFile)) {
			return array('ok' => false, 'error' => 'schema file missing');
		}
		if (file_exists($filePath)) {
			return array('ok' => false, 'error' => 'database file already exists');
		}

		try {
			$pdo = new PDO('sqlite:' . $filePath, null, null, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			$pdo->exec('PRAGMA foreign_keys=ON');
			$pdo->exec($this->readSchema($schemaFile));

			// security secrets (CSPRNG) — replace the empty seed values
			$secureKey = bin2hex(random_bytes(32));
			$apiKey = bin2hex(random_bytes(16));
			$upd = $pdo->prepare('UPDATE planning_config SET valeur = ? WHERE cle = ?');
			$upd->execute(array($secureKey, 'SECURE_KEY'));
			$upd->execute(array($apiKey, 'SOPLANNING_API_KEY_VALUE'));
			$upd->execute(array($this->getVersion(), 'CURRENT_VERSION'));

			// admin account with a random password
			$adminPassword = bin2hex(random_bytes(8));
			$droits = '["users_manage_all", "projects_manage_all", "projectgroups_manage_all", "tasks_modify_all", "tasks_view_all_projects", "lieux_all", "ressources_all", "parameters_all", "stats_users", "stats_projects", "audit_restore", "stats_roi_projects"]';
			$pdo->prepare('INSERT INTO planning_user (user_id, nom, login, password, droits, cle, visible_planning, notifications, login_actif, couleur, date_creation) VALUES (?,?,?,?,?,?,?,?,?,?,?)')
				->execute(array('ADM', 'admin', 'admin', password_hash($adminPassword, PASSWORD_BCRYPT), $droits, bin2hex(random_bytes(16)), 'non', 'oui', 'oui', '000000', date('Y-m-d H:i:s')));

			// the public/guest pseudo-user the app expects
			$pdo->prepare('INSERT INTO planning_user (user_id, nom, visible_planning, notifications, login_actif, cle, couleur, date_creation) VALUES (?,?,?,?,?,?,?,?)')
				->execute(array('publicspl', 'Guest', 'non', 'non', 'oui', bin2hex(random_bytes(16)), '000000', date('Y-m-d H:i:s')));

			// default task statuses
			$statuses = array(
				array('todo', 'To do', 'tp', 0, 1, 1, '4dabf5'),
				array('progress', 'In progress', 'tp', 50, 2, 0, 'ffc107'),
				array('done', 'Done', 'tp', 100, 3, 0, '4caf50'),
				array('abort', 'Aborted', 'tp', 0, 4, 0, 'f44336'),
				array('archive', 'Archived', 'tp', 100, 5, 0, '9e9e9e'),
			);
			$st = $pdo->prepare('INSERT INTO planning_status (status_id, nom, affichage, pourcentage, priorite, defaut, couleur, inclure_dans_calcul) VALUES (?,?,?,?,?,?,?,?)');
			foreach ($statuses as $s) {
				$st->execute(array($s[0], $s[1], $s[2], $s[3], $s[4], $s[5], $s[6], 'oui'));
			}

			$pdo = null;
			return array('ok' => true, 'admin_password' => $adminPassword, 'error' => '');
		} catch (Exception $e) {
			return array('ok' => false, 'error' => $e->getMessage());
		}
	}

	// Read a .sql file, stripping leading "-- " comment lines.
	private function readSchema($file)
	{
		$lines = file($file);
		$out = array();
		foreach ($lines as $l) {
			if (preg_match('/^\s*--/', $l)) { continue; }
			$out[] = $l;
		}
		return implode('', $out);
	}
}
?>
