<?php
	
	require_once('include/php_header.inc.php');

	$peopleList = PersonQuery::create()
		->orderByPersonname()
		->find();
	
	$maxAbsoluteBalance = 0;
	foreach($peopleList as $people)
		if (abs($people->getBalance()) > $maxAbsoluteBalance)
			$maxAbsoluteBalance = abs($people->getBalance());
	
	$smarty->assign('templateName',	'index');
	$smarty->assign('nPeople', count($peopleList));
	$smarty->assign('maxAbsoluteBalance', $maxAbsoluteBalance);
	$smarty->assign_by_ref('peopleList', $peopleList);
	
	if (Kalkuli::isMobileBrowser())
		$smarty->display('mobile/layout.tpl');
	else
		$smarty->display('layout.tpl');
	
