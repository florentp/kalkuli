<?php
	
	require_once('include/php_header.inc.php');

	// accessKey is valid
	if (!isset($_REQUEST['accessKey'])
			|| ($sheet = SheetQuery::create()->filterByAccessKey($_REQUEST['accessKey'])->findOne()) === null) {
		// TODO: Handle error
		trigger_error("Invalid accessKey value: " . $_REQUEST['accessKey'], E_USER_ERROR);
	}

	$peopleList = PersonQuery::create()
		->filterBySheet($sheet)
		->orderByPersonname()
		->find();
	
	$maxAbsoluteBalance = 0;
	foreach($peopleList as $people)
		if (abs($people->getBalance()) > $maxAbsoluteBalance)
			$maxAbsoluteBalance = abs($people->getBalance());
	
	$smarty->assign('templateName',	'sheet');
	$smarty->assign('nPeople', count($peopleList));
	$smarty->assign('maxAbsoluteBalance', $maxAbsoluteBalance);
	$smarty->assign_by_ref('sheet', $sheet);
	$smarty->assign_by_ref('peopleList', $peopleList);
	
	if ($_SESSION['browserType'] == 'STANDARD')
		$smarty->display('layout.tpl');
	else
		$smarty->display('mobile/layout.tpl');
