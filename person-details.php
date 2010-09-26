<?php
	
	require_once('include/php_header.inc.php');
	
	$personId = isset($_REQUEST['personId']) ? $_REQUEST['personId'] : null;
	if (!isset($personId))
		die("'personId' must be set");

	$person = PersonQuery::create()
		->findPK($personId);

	$operationsList = OperationQuery::create()
		->getPersonOperationList($person->getPersonId());
	
	$smarty->assign('templateName',	'person-details');
	$smarty->assign_by_ref('person',	$person);
	$smarty->assign_by_ref('operationsList', $operationsList);

	if (Kalkuli::isMobileBrowser())
		$smarty->display('mobile/layout.tpl');
	else
		$smarty->display('layout.tpl');
	