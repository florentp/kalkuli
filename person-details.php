<?php
	
	require_once('include/php_header.inc.php');
	
	$personId = isset($_REQUEST['personId']) ? $_REQUEST['personId'] : null;
	if (!isset($personId))
		die("'personId' must be set");

	$person = PersonQuery::create()
		->findPK($personId);
	
//	$i = IncomingQuery::create()
//		->setFormatter('PropelSimpleArrayFormatter')
//		->filterByPerson($person)
//		->withColumn('SUM(InAmount)', 'totalInAmount')
//		->groupBy('Operationidfk')
//		->select('Operationidfk', 'totalInAmount')
//		->find();
	
//	$o = OutgoingQuery::create()
//		->setFormatter('PropelSimpleArrayFormatter')
//		->filterByPerson($person)
//		->withColumn('SUM(OutWeight)', 'totalOutWeight')
//		->groupBy('Operationidfk')
//		->select('Operationidfk', 'totalOutWeight')
//		->find();
	
//	$operationsList = OperationQuery::create()
//		->setFormatter('PropelArrayFormatter')
//		->useIncomingQuery('i', 'LEFT JOIN')
//			->filterByPerson($person)
//			->withColumn('SUM(i.InAmount)', 'i.totalIn')
//			->withColumn('i.InAmount', 'totalIn')
//			->groupBy('i.Operationidfk')
//			->select('i.Operationidfk', 'i.totalIn')
//		->endUse()
//		->with('i')
//		->withColumn('i.totalInAmount', 'i.Operationidfk')
//		->find();
	
//	$incomingsList = IncomingQuery::create()
//		->filterByPerson($person)
//		->useOperationQuery()
//			->orderByOperationts('desc')
//		->endUse()
//		->joinWith('Incoming.Operation')
//		->find();

//	$outgoingsList = OutgoingQuery::create()
//		->filterByPerson($person)
//		->useOperationQuery()
//			->orderByOperationts('desc')
//		->endUse()
//		->joinWith('Outgoing.Operation')
//		->find();

	$operationsList = OperationQuery::create()
		->getPersonOperationList($person->getPersonId());
	
	$smarty->assign('templateName',	'person-details');
	$smarty->assign('CURRENCY', CURRENCY);
	$smarty->assign_by_ref('person',	$person);
//	$smarty->assign_by_ref('incomingsList',	$incomingsList);
//	$smarty->assign_by_ref('outgoingsList',	$outgoingsList);
	$smarty->assign_by_ref('operationsList', $operationsList);

	if (Kalkuli::isMobileBrowser())
		$smarty->display('mobile/layout.tpl');
	else
		$smarty->display('layout.tpl');
	