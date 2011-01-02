<?php
	
	require_once('include/php_header.inc.php');

	// accessKey is valid
	if (!isset($_REQUEST['accessKey'])
			|| ($sheet = SheetQuery::create()->filterByAccessKey($_REQUEST['accessKey'])->findOne()) === null) {
		// TODO: Handle error
		trigger_error("Invalid accessKey value: " . $_REQUEST['accessKey'], E_USER_ERROR);
	}

	if (isset($_REQUEST['addPeopleButton'])) {
		
		// name is not empty
		if (!isset($_REQUEST['namesList'])
				|| !is_array($_REQUEST['namesList'])) {
			// TODO: Handle error
			trigger_error("namesList must be an array", E_USER_ERROR);
		}
		else {
			$namesList = array();
			foreach($_REQUEST['namesList'] as $name) {
				if (strlen($name = trim($name)) !== 0)
					$namesList[] = $name;
			}
			if (count($namesList) === 0) {
				// TODO: Handle error
				trigger_error("namesList is empty", E_USER_ERROR);
			}
		}

		$dbConnection = Propel::getConnection(OperationPeer::DATABASE_NAME);

		$dbConnection->beginTransaction();
		try {
			foreach($namesList as $name) {
				$person = new Person();
				$person->setPersonName($name);
				$person->setSheet($sheet);
				$person->save();
			}

			$sheet->setLastModificationTS(new DateTime());
			$sheet->save();

			$dbConnection->commit();
		}
		catch (Exception $e) {
			$dbConnection->rollback();
			throw $e;
		}
		
		header(sprintf('Location: %s/%s', CONTEXT_PATH, $sheet->getAccessKey()));
	}
	
	$smarty->assign('templateName',	'people-add');
	$smarty->assign_by_ref('sheet', $sheet);

	if (Kalkuli::isMobileBrowser())
		$smarty->display('mobile/layout.tpl');
	else
		$smarty->display('layout.tpl');
	