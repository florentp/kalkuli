<?php

	require_once('include/config.inc.php');

	if (file_exists(DATABASE_PATH))
		header('Location: index.php');
		
	$installationOk = true;
	
	list($phpMajor, $phpMinor, $phpEdit) = explode('.', phpversion());
	if ($phpMajor > 5 || $phpMajor == 5 && ($phpMinor > 0 || $phpEdit >=3))
		$phpVersion = true;
	else {
		$phpVersion = false;
		$installationOk = false;
	}
		
	if (extension_loaded('PDO') && in_array('sqlite', PDO::getAvailableDrivers()))
		$sqliteLoaded = true;
	else {
		$sqliteLoaded = false;
		$installationOk = false;
	}
	
	if (file_exists_incpath('PEAR.php')) {
		$pearInstalled = true;
		if (file_exists_incpath('Log.php'))
			$pearLogInstalled = true;
		else {
			$pearLogInstalled = false;
			$installationOk = false;
		}
	}
	else {
		$pearInstalled = false;
		$pearLogInstalled = false;
		$installationOk = false;
	}
	
	if (file_exists_incpath('smarty/Smarty.class.php'))
		$smartyInstalled = true;
	else {
		$smartyInstalled = false;
		$installationOk = false;
	}

	$templatesCacheDirectory = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'templates_c';
	if (is_writable($templatesCacheDirectory))
		$isTemplatesCacheWritable = true;
	else {
		$isTemplatesCacheWritable = false;
		$installationOk = false;
	}
	
	if (file_exists_incpath('propel/Propel.php'))
		$propelInstalled = true;
	else {
		$propelInstalled = false;
		$installationOk = false;
	}

	$databaseDirectory = dirname(DATABASE_PATH);
	if (is_writable($databaseDirectory))
		$isDatabaseDirectoryWritable = true;
	else {
		$isDatabaseDirectoryWritable = false;
		$installationOk = false;
	}
?>

<?php

	$okConstant = '<font color="green">OK</font>';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
	<head>
		<title>Installation de /kal.'ku.li/</title>
		<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-15" />
	</head>

	<body>
		<h1>Installation de /kal.'ku.li/</h1>

		<p>Vérification de l'installation de PHP</p>
		<p>Version de la version de PHP ... <?php echo $phpVersion ? $okConstant : '<font color="red">You must get <a href="http://www.php.net/">PHP 5.0.3</a> or higher to run /kal.\'ku.li/</font>' ?></p>
		<p>Vérification de SQLite ... <?php echo $sqliteLoaded ? $okConstant : '<font color="red">You must install <a href="http://www.sqlite.org/">SQLite</a></font>' ?></p>
		<p>Vérification de PEAR ... <?php echo $pearInstalled ? $okConstant : '<font color="red">You must install <a href="http://pear.php.net/">PEAR</a> library</font>' ?></p><p>Vérification de Smarty ... <?php echo $smartyInstalled ? $okConstant : '<font color="red">You must install <a href="http://www.smarty.net/">Smarty</a></font>' ?></p>
		<p>Vérification de templates_c ... <?php echo $isTemplatesCacheWritable ? $okConstant : '<font color="red">&quot;' . $templatesCacheDirectory . '&quot; directory must be writable</font>' ?></p>
		<p>Vérification de Propel ... <?php echo $propelInstalled ? $okConstant : '<font color="red">You must install <a href="http://www.propelorm.org/">Propel</a></font>' ?></p>
		<p>Vérification du dossier SQLite ... <?php echo $isDatabaseDirectoryWritable ? $okConstant : '<font color="red">&quot;' . $databaseDirectory . '&quot; directory must be writable</font>' ?></p>

		<?php
			if ($installationOk) {
				$dbh = new PDO('sqlite:' . DATABASE_PATH);
				if ($dbh) {
					$dbh->query("DROP TABLE IF EXISTS [person];");
					$dbh->query("CREATE TABLE [person]([personId] INTEGER  NOT NULL PRIMARY KEY,[personName] VARCHAR(255)  NOT NULL);");
					$dbh->query("DROP TABLE IF EXISTS [outgoing];");;
					$dbh->query("CREATE TABLE [outgoing]([outId] INTEGER  NOT NULL PRIMARY KEY,[outWeight] FLOAT,[operationIdFK] INTEGER  NOT NULL,[personIdFK] INTEGER  NOT NULL);");
					$dbh->query("DROP TABLE IF EXISTS [incoming];");
					$dbh->query("CREATE TABLE [incoming]([inId] INTEGER  NOT NULL PRIMARY KEY,[inAmount] FLOAT,[operationIdFK] INTEGER  NOT NULL,[personIdFK] INTEGER  NOT NULL);");
					$dbh->query("DROP TABLE IF EXISTS [operation];");
					$dbh->query("CREATE TABLE [operation]([operationId] INTEGER  NOT NULL PRIMARY KEY,[operationTS] TIMESTAMP  NOT NULL,[operationDescription] MEDIUMTEXT  NOT NULL, [totalInAmount] FLOAT NOT NULL DEFAULT '0.0', [totalOutWeight] FLOAT NOT NULL DEFAULT '0.0');");
					$dbh->query("CREATE TRIGGER 'incomingInsert' AFTER INSERT ON 'incoming' BEGIN UPDATE operation SET totalInAmount = ( SELECT COALESCE (SUM (inAmount), 0) FROM incoming WHERE operationIdFK = NEW.operationIdFK) WHERE operationId = NEW.operationIdFK; END;");
					$dbh->query("CREATE TRIGGER 'incomingUpdate' AFTER UPDATE OF inAmount ON 'incoming' BEGIN UPDATE operation SET totalInAmount = ( SELECT COALESCE (SUM (inAmount), 0) FROM incoming WHERE operationIdFK = NEW.operationIdFK) WHERE operationId = NEW.operationIdFK; END;");
					$dbh->query("CREATE TRIGGER 'incomingDelete' AFTER DELETE ON 'incoming' BEGIN UPDATE operation SET totalInAmount = ( SELECT COALESCE (SUM (inAmount), 0) FROM incoming WHERE operationIdFK = OLD.operationIdFK) WHERE operationId = OLD.operationIdFK; END;");
					$dbh->query("CREATE TRIGGER 'outgoingInsert' AFTER INSERT ON 'outgoing' BEGIN UPDATE operation SET totalOutWeight = ( SELECT COALESCE (SUM (outWeight), 0) FROM outgoing WHERE operationIdFK = NEW.operationIdFK) WHERE operationId = NEW.operationIdFK ; END;");
					$dbh->query("CREATE TRIGGER 'outgoingUpdate' AFTER UPDATE OF outWeight ON 'outgoing' BEGIN UPDATE operation SET totalOutWeight = ( SELECT COALESCE (SUM (outWeight), 0) FROM outgoing WHERE operationIdFK = NEW.operationIdFK) WHERE operationId = NEW.operationIdFK; END;");
					$dbh->query("CREATE TRIGGER 'outgoingDelete' AFTER DELETE ON 'outgoing' BEGIN UPDATE operation SET totalOutWeight = ( SELECT COALESCE (SUM (outWeight), 0) FROM outgoing WHERE operationIdFK = OLD.operationIdFK) WHERE operationId = OLD.operationIdFK; END;");
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
	</body>
</html>

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
