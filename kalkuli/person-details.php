<?php
	
	require_once('include/php_header.inc.php');
	
	// accessKey is valid
	if (!isset($_REQUEST['accessKey'])
			|| ($sheet = SheetQuery::create()->filterByAccessKey($_REQUEST['accessKey'])->findOne()) === null) {
		// TODO: Handle error
		trigger_error("Invalid accessKey value: " . $_REQUEST['accessKey'], E_USER_ERROR);
	}

	// person exists
	if (!isset($_REQUEST['personId'])
			|| !ctype_digit($_REQUEST['personId'])
			|| ($personId = intval($_REQUEST['personId'])) === 0
			|| ($person = PersonQuery::create()->filterBySheet($sheet)->findPK($personId)) === null) {
		// TODO: Handle error
		trigger_error("Invalid personId value: " . $_REQUEST['personId'], E_USER_ERROR);
	}

	$operationsList = OperationQuery::create()
		->getPersonOperationList($person->getPersonId());
	
	$smarty->assign('templateName',	'person-details');
	$smarty->assign_by_ref('sheet', $sheet);
	$smarty->assign_by_ref('person',	$person);
	$smarty->assign_by_ref('operationsList', $operationsList);

	if ($_SESSION['browserType'] == 'STANDARD')
		$smarty->display('layout.tpl');
	else
		$smarty->display('mobile/layout.tpl');
