<?php
	
	require_once('include/php_header.inc.php');
	
	$personId = isset($_REQUEST['personId']) ? $_REQUEST['personId'] : null;
	if (!isset($personId))
		die("'personId' must be set");

	$person = PersonPeer::retrieveByPk($personId);
	
	$incomingsList = $person->getIncomingsJoinOperation();
	$outgoingsList = $person->getOutgoingsJoinOperation();
	
	$smarty->assign('templateName',	'person-details');
	$smarty->assign('CURRENCY', CURRENCY);
	$smarty->assign_by_ref('person',	$person);
	$smarty->assign_by_ref('incomingsList',	$incomingsList);
	$smarty->assign('nIncomings', count($incomingsList));
	$smarty->assign_by_ref('outgoingsList',	$outgoingsList);
	$smarty->assign('nOutgoings', count($outgoingsList));
	$smarty->display('layout.tpl');
	