<?php

	require_once('include/config.inc.php');

	if (file_exists(DATABASE_PATH))
		header('Location: index.php');
		
	$installationOk = true;
	
	list($phpMajor, $phpMinor, $phpEdit) = split('[/.-]', phpversion());
	if ($phpMajor > 5 || $phpMajor == 5 && ($phpMinor > 0 || $phpEdit >=3))
		$phpVersion = true;
	else {
		$phpVersion = false;
		$installationOk = false;
	}
		
	if (extension_loaded('SQLite'))
		$sqliteLoaded = true;
	else {
		$sqliteLoaded = false;
		$installationOk = false;
	}
	
	if (file_exists_incpath('PEAR.php')) {
		$pearInstalled = true;
		if (file_exists_incpath('HTML/QuickForm.php'))
			$pearQuickFormInstalled = true;
		else {
			$pearQuickFormInstalled = false;
			$installationOk = false;
		}
	}
	else {
		$pearInstalled = false;
		$pearQuickFormInstalled = false;
		$installationOk = false;
	}
	
	if (file_exists_incpath('smarty/Smarty.class.php'))
		$smartyInstalled = true;
	else {
		$smartyInstalled = false;
		$installationOk = false;
	}
	
	if (file_exists_incpath('propel/Propel.php'))
		$propelInstalled = true;
	else {
		$propelInstalled = false;
		$installationOk = false;
	}
		
?>

<?php

	$okConstant = '<font color="green">OK</font>';

?>

<h1>Installation de Money</h1>

<p>Vérification de l'installation de PHP</p>
<p>Version de la version de PHP ... <?php echo $phpVersion ? $okConstant : '<font color="red">You must get <a href="http://www.php.net/">PHP 5.0.3</a> or higher to run Money</font>' ?></p>
<p>Vérification de SQLite ... <?php echo $sqliteLoaded ? $okConstant : '<font color="red">You must install <a href="http://www.sqlite.org/">SQLite</a></font>' ?></p>
<p>Vérification de PEAR ... <?php echo $pearInstalled ? $okConstant : '<font color="red">You must install <a href="http://pear.php.net/">PEAR</a> library</font>' ?></p>
<p>Vérification de HTML_QuickForm ... <?php echo $pearQuickFormInstalled ? $okConstant : '<font color="red">You must install PEAR library <a href="http://pear.php.net/package/HTML_QuickForm">HTML_QuickForm</a></font>' ?></p>
<p>Vérification de Smarty ... <?php echo $smartyInstalled ? $okConstant : '<font color="red">You must install <a href="http://smarty.php.net/">Smarty</a></font>' ?></p>
<p>Vérification de Propel ... <?php echo $propelInstalled ? $okConstant : '<font color="red">You must install <a href="http://propel.phpdb.org/trac/">Propel</a></font>' ?></p>

<?php
	if ($installationOk) {
		$sqliteHandler = sqlite_open(DATABASE_PATH);
		if ($sqliteHandler) {
			sqlite_query($sqliteHandler, file_get_contents('include/schema.sql'));
			$dbCreation = true;
		}
		else {
			$dbCreation = false;
			$installationOk = false;
		}
	
?>

<p>Création de la base de données ... <?php echo $dbCreation ? $okConstant . ' (' . DATABASE_PATH . ')' : '<font color="red">Impossible de créer la base de données (' . DATABASE_PATH . ')</font>' ?></p>

<?php

	}
	
	if ($installationOk) {
	
?>

<p>Installation terminée avec succès. <a href="index.php">Aller à l'index</a>

<?php

	}
	
	function file_exists_incpath ($file) {
		$paths = explode(PATH_SEPARATOR, get_include_path());
		
		foreach ($paths as $path) {
			$fullpath = $path . DIRECTORY_SEPARATOR . $file;
			
			if (file_exists($fullpath))
				return true;
		}
		return false;
	}
	
?>
