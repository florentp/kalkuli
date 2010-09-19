<?php
	
	require_once('include/php_header.inc.php');

	$peopleList = PersonQuery::create()
		->orderByPersonname()
		->find();
	
	$smarty->assign('templateName',	'index');
	$smarty->assign('CURRENCY', CURRENCY);
	$smarty->assign('nPeople', count($peopleList));
	$smarty->assign_by_ref('peopleList', $peopleList);
	
	if (Kalkuli::isMobileBrowser())
		$smarty->display('mobile/layout.tpl');
	else
		$smarty->display('layout.tpl');
	
