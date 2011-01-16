<?php
	
	require_once('include/php_header.inc.php');
	require_once('classes/KeyGenerator.php');
	require_once('classes/CurrencyType.php');
	require_once('classes/MailerFactory.php');

	if (isset($_REQUEST['createSheetButton'])) {
		// sheetName is not empty
		if (!isset($_REQUEST['sheetName'])
				|| strlen($sheetName = trim($_REQUEST['sheetName'])) === 0) {
			// TODO: Handle error
			trigger_error("Invalid sheetName value: " . $_REQUEST['sheetName'], E_USER_ERROR);
		}

		// currency code exists
		if (!isset($_REQUEST['currencyCode'])
				|| strlen($currencyCode = trim($_REQUEST['currencyCode'])) === 0
				|| !CurrencyType::exists($currencyCode)) {
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
			$sheet->setName($sheetName);
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

		$subject = "/kal.'ku.li/ Cr�ation de votre feuille de compte $sheetName";
		$body = "Bonjour,\n\nVotre feuille de compte $sheetName a �t� cr��e � l'adresse unique suivante:\n";
		$body .= sprintf("%s%s/%s\n\n", SERVER_URL, CONTEXT_PATH, $sheet->getAccessKey());
		$body .= "Seules les personnes connaissant cette adresse peuvent y acc�der, pensez � la partager avec les autres participants.\n\nA bient�t sur /kal.'ku.li/";

		$headers = array (
			'From' => sprintf('"%s" <%s>', MAILER_NAME, MAILER_ADDRESS),
			'To' => $creatorEmail,
			'Subject' => $subject);
		
		$mailer = MailerFactory::createNewInstance();

		$sendResult = $mailer->send($creatorEmail, $headers, $body);

		if (PEAR::isError($sendResult)) {
			error_log($sendResult->toString());
		}

		header(sprintf('Location: %s/%s', CONTEXT_PATH, $sheet->getAccessKey()));

	}

	if (isset($_REQUEST['retrieveSheetsButton'])) {

		// creator email address is not empty
		// TODO: add format validation
		if (!isset($_REQUEST['retrieveEmail'])
				|| strlen($retrieveEmail = trim($_REQUEST['retrieveEmail'])) === 0) {
			// TODO: Handle error
			trigger_error("Invalid retrieveEmail value: " . $_REQUEST['retrieveEmail'], E_USER_ERROR);
		}

		$sheetList = SheetQuery::create()
			->filterByCreatoremail($retrieveEmail)
			->find();

		$subject = "/kal.'ku.li/ Liste de vos feuilles de compte";
		$body = "Bonjour,\n\nVoici la liste des feuilles de compte rattach�es � l'adresse $retrieveEmail:\n";
		foreach ($sheetList as $sheet) {
			$body .= sprintf("%s: %s%s/%s\n", $sheet->getName(), SERVER_URL, CONTEXT_PATH, $sheet->getAccessKey());
		}
		$body .= "\nA bient�t sur /kal.'ku.li/";

		$headers = array (
			'From' => sprintf('"%s" <%s>', MAILER_NAME, MAILER_ADDRESS),
			'To' => $retrieveEmail,
			'Subject' => $subject);
		
		$mailer = MailerFactory::createNewInstance();

		$sendResult = $mailer->send($retrieveEmail, $headers, $body);

		if (PEAR::isError($sendResult)) {
			error_log($sendResult->toString());
		}

		header(sprintf('Location: %s', CONTEXT_PATH));

	}

	$currencyOptionList = array();
	foreach (CurrencyType::getCurrencyCodeList() as $currencyCode)
		$currencyOptionList[$currencyCode] = sprintf('%s - %s', CurrencyType::getName($currencyCode), CurrencyType::getSymbol($currencyCode));

	$smarty->assign('templateName',	'index');
	$smarty->assign('currencyOptionList', $currencyOptionList);
	
	if (Kalkuli::isMobileBrowser())
		$smarty->display('mobile/layout.tpl');
	else
		$smarty->display('layout.tpl');
	
