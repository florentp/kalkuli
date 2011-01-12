<?php

	$installationOk = true;

	if (file_exists('include/config.inc.php')) {
		require_once('include/config.inc.php');
		$configFile = true;
	}
	else {
		$configFile = false;
		$installationOk = false;
	}
	
	list($phpMajor, $phpMinor, $phpEdit) = explode('.', phpversion());
	if ($phpMajor > 5 || $phpMajor == 5 && ($phpMinor > 0 || $phpEdit >=3))
		$phpVersion = true;
	else {
		$phpVersion = false;
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
	
	if (file_exists_incpath('propel/Propel.php'))
		$propelInstalled = true;
	else {
		$propelInstalled = false;
		$installationOk = false;
	}

	$templatesCacheDirectory = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'templates_c';
	if (is_writable($templatesCacheDirectory))
		$isTemplatesCacheWritable = true;
	else {
		$isTemplatesCacheWritable = false;
		$installationOk = false;
	}
		
	if (extension_loaded('PDO') && in_array('mysql', PDO::getAvailableDrivers()))
		$mysqlLoaded = true;
	else {
		$mysqlLoaded = false;
		$installationOk = false;
	}

	try {
		$dbh = new PDO('mysql:host=' . DATABASE_HOST . ';dbname=' . DATABASE_NAME, DATABASE_USERNAME, DATABASE_PASSWORD);
		$dbConnection = true;
	}
	catch (PDOException $e) {
		$dbConnection = false;
		$installationOk = false;
	}

?>

<?php

	$okConstant = '<span style="color: green;">OK</span>';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
	<head>
		<title>Installation de /kal.'ku.li/</title>
		<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-15" />
	</head>

	<body>
		<h1>Installation de /kal.'ku.li/</h1>

		<ul><li>Présence du fichier de configuration ... <?php echo $configFile ? $okConstant : '<span style="color: red;">You must copy or rename file include/config.inc.php-sample to include/config.inc.php and change the settings to match your configuration.</span>' ?></ul></li>
		
		<ul><li>Version de PHP (> 5.0.3) ... <?php echo $phpVersion ? $okConstant : '<span style="color: red;">You must get <a href="http://www.php.net/">PHP 5.0.3</a> or higher to run /kal.\'ku.li/</span>' ?></ul></li>
		
		<ul><li>Installation de PEAR ... <?php echo $pearInstalled ? $okConstant : '<span style="color: red;">You must install <a href="http://pear.php.net/">PEAR</a> library</span>' ?></ul></li>

		<ul><li>Installation de Smarty ... <?php echo $smartyInstalled ? $okConstant : '<span style="color: red;">You must install <a href="http://www.smarty.net/">Smarty</a></span>' ?></ul></li>

		<ul><li>Installation de Propel ... <?php echo $propelInstalled ? $okConstant : '<span style="color: red;">You must install <a href="http://www.propelorm.org/">Propel</a></span>' ?></ul></li>

		<ul><li>Droits d'écriture sur le dossier templates_c ... <?php echo $isTemplatesCacheWritable ? $okConstant : '<span style="color: red;">&quot;' . $templatesCacheDirectory . '&quot; directory must be writable</span>' ?></ul></li>
		
		<ul><li>Présence du module PDO et du driver MySQL ... <?php echo $mysqlLoaded ? $okConstant : '<span style="color: red;">You must enable the PHP <a href="http://fr.php.net/manual/en/pdo.installation.php">PDO module and its MySQL driver</a></span>' ?></ul></li>
		
		<ul><li>Connexion à la base de données ... <?php echo $dbConnection ? $okConstant : '<span style="color: red;">Cannot connect to database. Check settings in include/config.inc.php</span>' ?></ul></li>

		<?php if ($installationOk && !isset($_REQUEST['confirmDBInitialization'])) { ?>
			<p><strong>Merci de vérifier les paramètres de configuration et de les modifier dans le fichier include/config.ing.php si nécessaire&nbsp;:</strong></p>
			<table>
				<tr>
					<th>SERVER_URL</th>
					<td><?php echo SERVER_URL ?></td>
				</tr>
				<tr>
					<th>CONTEXT_PATH</th>
					<td><?php echo CONTEXT_PATH ?></td>
				</tr>
				<tr>
					<th>DATABASE_HOST</th>
					<td><?php echo DATABASE_HOST ?></td>
				</tr>
				<tr>
					<th>DATABASE_NAME</th>
					<td><?php echo DATABASE_NAME ?></td>
				</tr>
				<tr>
					<th>DATABASE_USERNAME</th>
					<td><?php echo DATABASE_USERNAME ?></td>
				</tr>
				<tr>
					<th>DATABASE_PASSWORD</th>
					<td><?php echo str_repeat('*', strlen(DATABASE_PASSWORD)) ?></td>
				</tr>
			</table>

			<p>Vous pouvez initialiser la base de données. <strong>Attention, cette opération peut supprimer des données en base de manière irréversible.</strong></p>
			<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
				<input name="confirmDBInitialization" type="submit" value="Initialiser la base de données" />
			</form>
		<?php } ?>

		<?php
			if ($installationOk && isset($_REQUEST['confirmDBInitialization'])) {
				$dbh->beginTransaction();
				try {
					if (!$dbh->query("SET FOREIGN_KEY_CHECKS = 0;")) throw new Exception(dbhErrorMessage($dbh->errorInfo()));
					if (!$dbh->query("DROP TABLE IF EXISTS `sheet`;")) throw new Exception(dbhErrorMessage($dbh->errorInfo()));
					if (!$dbh->query("CREATE TABLE `sheet` ( `sheetId` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'Sheet ID', `accessKey` VARCHAR(255) NOT NULL COMMENT 'Access key', `name` VARCHAR(255) NOT NULL COMMENT 'Sheet name', `currencyCode` VARCHAR(255) NOT NULL COMMENT 'Currency code (EUR, USD...)', `creatorEmail` VARCHAR(255) NOT NULL COMMENT 'Email of the creator of this sheet', `creationTS` DATETIME NOT NULL COMMENT 'Sheet creation date', `lastModificationTS` DATETIME NOT NULL COMMENT 'Last modification date (adding/updating/deleting person, operation or any object in the sheet)', PRIMARY KEY (`sheetId`) ) ENGINE=InnoDB COMMENT='List of sheets';")) throw new Exception(dbhErrorMessage($dbh->errorInfo()));
					if (!$dbh->query("DROP TABLE IF EXISTS `person`;")) throw new Exception(dbhErrorMessage($dbh->errorInfo()));
					if (!$dbh->query("CREATE TABLE `person` ( `personId` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'Person ID', `personName` VARCHAR(255) NOT NULL COMMENT 'Person name', `sheetIdFK` INTEGER NOT NULL COMMENT 'Sheet foreign key', PRIMARY KEY (`personId`), INDEX `person_FI_1` (`sheetIdFK`), CONSTRAINT `person_FK_1` FOREIGN KEY (`sheetIdFK`) REFERENCES `sheet` (`sheetId`) ON DELETE CASCADE ) ENGINE=InnoDB COMMENT='List of person in the community';")) throw new Exception(dbhErrorMessage($dbh->errorInfo()));
					if (!$dbh->query("DROP TABLE IF EXISTS `outgoing`;")) throw new Exception(dbhErrorMessage($dbh->errorInfo()));
					if (!$dbh->query("CREATE TABLE `outgoing` ( `outId` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'Outgoing ID', `outWeight` FLOAT COMMENT 'Weight applied to the person', `operationIdFK` INTEGER NOT NULL COMMENT 'Operation foreign key', `personIdFK` INTEGER NOT NULL COMMENT 'Person foreign key', PRIMARY KEY (`outId`), INDEX `outgoing_FI_1` (`operationIdFK`), CONSTRAINT `outgoing_FK_1` FOREIGN KEY (`operationIdFK`) REFERENCES `operation` (`operationId`) ON DELETE CASCADE, INDEX `outgoing_FI_2` (`personIdFK`), CONSTRAINT `outgoing_FK_2` FOREIGN KEY (`personIdFK`) REFERENCES `person` (`personId`) ON DELETE CASCADE ) ENGINE=InnoDB COMMENT='What is consumed by the community';")) throw new Exception(dbhErrorMessage($dbh->errorInfo()));
					if (!$dbh->query("DROP TABLE IF EXISTS `incoming`;")) throw new Exception(dbhErrorMessage($dbh->errorInfo()));
					if (!$dbh->query("CREATE TABLE `incoming` ( `inId` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'Incoming ID', `inAmount` FLOAT COMMENT 'Amount of the incoming', `operationIdFK` INTEGER NOT NULL COMMENT 'Operation foreign key', `personIdFK` INTEGER NOT NULL COMMENT 'Person foreign key', PRIMARY KEY (`inId`), INDEX `incoming_FI_1` (`operationIdFK`), CONSTRAINT `incoming_FK_1` FOREIGN KEY (`operationIdFK`) REFERENCES `operation` (`operationId`) ON DELETE CASCADE, INDEX `incoming_FI_2` (`personIdFK`), CONSTRAINT `incoming_FK_2` FOREIGN KEY (`personIdFK`) REFERENCES `person` (`personId`) ON DELETE CASCADE ) ENGINE=InnoDB COMMENT='What is shared by the community';")) throw new Exception(dbhErrorMessage($dbh->errorInfo()));
					if (!$dbh->query("DROP TABLE IF EXISTS `operation`;")) throw new Exception(dbhErrorMessage($dbh->errorInfo()));
					if (!$dbh->query("CREATE TABLE `operation` ( `operationId` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'Operation ID', `operationTS` DATETIME NOT NULL COMMENT 'Operation date', `operationDescription` TEXT NOT NULL COMMENT 'Operation description', `sheetIdFK` INTEGER NOT NULL COMMENT 'Sheet foreign key', `totalInAmount` FLOAT NOT NULL COMMENT 'Total amount of all incomings for this operation', `totalOutWeight` FLOAT NOT NULL COMMENT 'Total weight of all outgoings for this operation', PRIMARY KEY (`operationId`), INDEX `operation_FI_1` (`sheetIdFK`), CONSTRAINT `operation_FK_1` FOREIGN KEY (`sheetIdFK`) REFERENCES `sheet` (`sheetId`) ON DELETE CASCADE ) ENGINE=InnoDB COMMENT='List of operations (made of incomings and outgoings)';")) throw new Exception(dbhErrorMessage($dbh->errorInfo()));
					if (!$dbh->query("SET FOREIGN_KEY_CHECKS = 1;")) throw new Exception(dbhErrorMessage($dbh->errorInfo()));
					if (!$dbh->query("CREATE TRIGGER `incomingInsert` AFTER INSERT ON `incoming` FOR EACH ROW BEGIN UPDATE operation SET totalInAmount = ( SELECT COALESCE (SUM (inAmount), 0) FROM incoming WHERE operationIdFK = NEW.operationIdFK) WHERE operationId = NEW.operationIdFK; END;")) throw new Exception(dbhErrorMessage($dbh->errorInfo()));
					if (!$dbh->query("CREATE TRIGGER `incomingUpdate` AFTER UPDATE ON `incoming` FOR EACH ROW BEGIN UPDATE operation SET totalInAmount = ( SELECT COALESCE (SUM (inAmount), 0) FROM incoming WHERE operationIdFK = NEW.operationIdFK) WHERE operationId = NEW.operationIdFK; END;")) throw new Exception(dbhErrorMessage($dbh->errorInfo()));
					if (!$dbh->query("CREATE TRIGGER `incomingDelete` AFTER DELETE ON `incoming` FOR EACH ROW BEGIN UPDATE operation SET totalInAmount = ( SELECT COALESCE (SUM (inAmount), 0) FROM incoming WHERE operationIdFK = OLD.operationIdFK) WHERE operationId = OLD.operationIdFK; END;")) throw new Exception(dbhErrorMessage($dbh->errorInfo()));
					if (!$dbh->query("CREATE TRIGGER `outgoingInsert` AFTER INSERT ON `outgoing` FOR EACH ROW BEGIN UPDATE operation SET totalOutWeight = ( SELECT COALESCE (SUM (outWeight), 0) FROM outgoing WHERE operationIdFK = NEW.operationIdFK) WHERE operationId = NEW.operationIdFK ; END;")) throw new Exception(dbhErrorMessage($dbh->errorInfo()));
					if (!$dbh->query("CREATE TRIGGER `outgoingUpdate` AFTER UPDATE ON `outgoing` FOR EACH ROW BEGIN UPDATE operation SET totalOutWeight = ( SELECT COALESCE (SUM (outWeight), 0) FROM outgoing WHERE operationIdFK = NEW.operationIdFK) WHERE operationId = NEW.operationIdFK; END;")) throw new Exception(dbhErrorMessage($dbh->errorInfo()));
					if (!$dbh->query("CREATE TRIGGER `outgoingDelete` AFTER DELETE ON `outgoing` FOR EACH ROW BEGIN UPDATE operation SET totalOutWeight = ( SELECT COALESCE (SUM (outWeight), 0) FROM outgoing WHERE operationIdFK = OLD.operationIdFK) WHERE operationId = OLD.operationIdFK; END;")) throw new Exception(dbhErrorMessage($dbh->errorInfo()));
					$dbh->commit();
					echo '<span style="color: green; font-weight: bold;">Base de données initialisée avec succès</span>';
				}
				catch (Exception $e) {
					$dbh->rollback();
					echo '<span style="color: red; font-weight: bold;">Impossible d\'initialiser la base de données: ' . $e->getMessage() . '</span>';
				}
			}
			
		?>
	</body>
</html>

<?php
	
	function file_exists_incpath ($file) {
		$paths = explode(PATH_SEPARATOR, get_include_path());
		
		foreach ($paths as $path) {
			$fullpath = $path . DIRECTORY_SEPARATOR . $file;
			
			if (file_exists($fullpath))
				return true;
		}
		return false;
	}

	function dbhErrorMessage($errorInfo) {
		return $errorInfo[2];
	}
	
?>
