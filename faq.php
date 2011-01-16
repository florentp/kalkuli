<?php
	
	require_once('include/php_header.inc.php');

	$smarty->assign('templateName',	'faq');
	
	if (Kalkuli::isMobileBrowser())
		$smarty->display('mobile/layout.tpl');
	else
		$smarty->display('layout.tpl');
	
