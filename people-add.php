<?php
	
	require_once('include/php_header.inc.php');

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
				$person->save();
			}
			$dbConnection->commit();
		}
		catch (Exception $e) {
			$dbConnection->rollback();
		}
		
		header('Location: index.php');
	}
	
	$smarty->assign('templateName',	'people-add');

	if (Kalkuli::isMobileBrowser())
		$smarty->display('mobile/layout.tpl');
	else
		$smarty->display('layout.tpl');
	