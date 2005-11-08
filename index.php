<?php
	
	require_once('include/php_header.inc.php');
	
	$peopleList = PersonPeer::doSelect(new Criteria());
	
	$smarty->assign('templateName',	'index');
	$smarty->assign('CURRENCY', CURRENCY);
	$smarty->assign('nPeople', count($peopleList));
	$smarty->assign_by_ref('peopleList',	$peopleList);
	$smarty->display('layout.tpl');
	
