<?php
	
	require_once('include/php_header.inc.php');
	require_once('classes/KeyGenerator.php');
	require_once('Mail.php');

	if (isset($_REQUEST['createSheetButton'])) {
		// name is not empty
		if (!isset($_REQUEST['name'])
				|| strlen($name = trim($_REQUEST['name'])) === 0) {
			// TODO: Handle error
			trigger_error("Invalid name value: " . $_REQUEST['name'], E_USER_ERROR);
		}

		// currency code is not empty
		// TODO: add existance test
		if (!isset($_REQUEST['currencyCode'])
				|| strlen($currencyCode = trim($_REQUEST['currencyCode'])) === 0) {
			// TODO: Handle error
			trigger_error("Invalid currencyCode value: " . $_REQUEST['currencyCode'], E_USER_ERROR);
		}

		// creator email address is not empty
		// TODO: add format validation
		if (!isset($_REQUEST['creatorEmail'])
				|| strlen($creatorEmail = trim($_REQUEST['creatorEmail'])) === 0) {
			// TODO: Handle error
			trigger_error("Invalid creatorEmail value: " . $_REQUEST['creatorEmail'], E_USER_ERROR);
		}

		$dbConnection = Propel::getConnection(OperationPeer::DATABASE_NAME);

		$dbConnection->beginTransaction();

		try {
			$keyGenerator = new KeyGenerator();

			$sheet = new Sheet();
			$sheet->setAccessKey($keyGenerator->generateKey(SHEET_ACCESS_KEY_LENGTH));
			$sheet->setName($name);
			$sheet->setCurrencyCode($currencyCode);
			$sheet->setCreatorEmail($creatorEmail);
			$date = new DateTime();
			$sheet->setCreationTS($date);
			$sheet->setLastModificationTS($date);
			$sheet->save();
			$dbConnection->commit();
		}
		catch (Exception $e) {
			$dbConnection->rollback();
			throw $e;
		}

		$from = "kalkuli@tooff.com";
		$to = "$creatorEmail";
		$subject = "/kal.'ku.li/ Création de votre feuille de compte $name";
		$body = "Bonjour,\n\nVotre feuille de compte $name a été crééeà l'adresse unique suivante:\nhttp://TO_BE_DEFINED\n\nSeules les personnes connaissant cette adresse peuvent y accéder, pensez à la partager avec les autres participants.\n\nA bientôt sur /kal.'ku.li/";

		$host = "ssl://smtp.gmail.com";
		$port = "465";
		$username = "kalkuli@tooff.com";
		$password = "kalkuli";

		$headers = array (
			'From' => $from,
			'To' => $to,
			'Subject' => $subject);
		$smtp = Mail::factory(
			'smtp',
			array (
				'host' => $host,
				'port' => $port,
				'auth' => true,
				'username' => $username,
				'password' => $password));

		$sendResult = $smtp->send($to, $headers, $body);

		if (PEAR::isError($sendResult)) {
			// TODO
		}

	}

	if (isset($_REQUEST['retrieveSheetsButton'])) {

		// creator email address is not empty
		// TODO: add format validation
		if (!isset($_REQUEST['creatorEmail'])
				|| strlen($creatorEmail = trim($_REQUEST['creatorEmail'])) === 0) {
			// TODO: Handle error
			trigger_error("Invalid creatorEmail value: " . $_REQUEST['creatorEmail'], E_USER_ERROR);
		}

		$sheetList = SheetQuery::create()
			->filterByCreatoremail($creatorEmail)
			->find();

		$from = "kalkuli@tooff.com";
		$to = "$creatorEmail";
		$subject = "/kal.'ku.li/ Liste de vos feuilles de compte";
		$body = "Bonjour,\n\nVoici la liste des feuilles de compte rattachées à l'adresse $creatorEmail:\n";
		foreach ($sheetList as $sheet) {
			$body .= sprintf("%s: http://TO_BE_DEFINED?%s\n", $sheet->getName(), $sheet->getAccessKey());
		}
		$body .= "\nA bientôt sur /kal.'ku.li/";

		$host = "ssl://smtp.gmail.com";
		$port = "465";
		$username = "kalkuli@tooff.com";
		$password = "kalkuli";

		$headers = array (
			'From' => $from,
			'To' => $to,
			'Subject' => $subject);
		$smtp = Mail::factory(
			'smtp',
			array (
				'host' => $host,
				'port' => $port,
				'auth' => true,
				'username' => $username,
				'password' => $password));

		$sendResult = $smtp->send($to, $headers, $body);

		if (PEAR::isError($sendResult)) {
			// TODO
		}

	}

	$smarty->assign('templateName',	'index');
	
	if (Kalkuli::isMobileBrowser())
		$smarty->display('mobile/layout.tpl');
	else
		$smarty->display('layout.tpl');
	
