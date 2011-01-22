<?php
	
	require_once('include/php_header.inc.php');

	$smarty->assign('templateName',	'how-it-works');
	
	if ($_SESSION['browserType'] == 'STANDARD')
		$smarty->display('layout.tpl');
	else
		$smarty->display('mobile/layout.tpl');
