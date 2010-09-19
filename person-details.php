<?php
	
	require_once('include/php_header.inc.php');
	
	$personId = isset($_REQUEST['personId']) ? $_REQUEST['personId'] : null;
	if (!isset($personId))
		die("'personId' must be set");

	$person = PersonQuery::create()
		->findPK($personId);
	
	$incomingsList = IncomingQuery::create()
		->filterByPerson($person)
		->useOperationQuery()
			->orderByOperationts('desc')
		->endUse()
		->find();

	$outgoingsList = OutgoingQuery::create()
		->filterByPerson($person)
		->useOperationQuery()
			->orderByOperationts('desc')
		->endUse()
		->find();
	
	$smarty->assign('templateName',	'person-details');
	$smarty->assign('CURRENCY', CURRENCY);
	$smarty->assign_by_ref('person',	$person);
	$smarty->assign_by_ref('incomingsList',	$incomingsList);
	$smarty->assign_by_ref('outgoingsList',	$outgoingsList);

	if (Kalkuli::isMobileBrowser())
		$smarty->display('mobile/layout.tpl');
	else
		$smarty->display('layout.tpl');
	