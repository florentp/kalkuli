<?php

	//set_include_path("d:/www/money/classes" . PATH_SEPARATOR . get_include_path());

	require_once('include/config.inc.php');

	date_default_timezone_set('Europe/Paris');
	
	if (!file_exists(DATABASE_PATH)) {
		header('Location: install.php');
		die();
	}
	require_once('propel/Propel.php');
	require_once('classes/Money.php');
	
	Propel::init('include/propel-db-config.inc.php');
	
	require_once('smarty/Smarty.class.php');
	
	$smarty = new Smarty();
	
	$smarty->register_modifier('formatMoney', array('Money', 'formatMoney'));
	$smarty->unregister_modifier('money');
	
	$smarty->assign('CURRENCY', CURRENCY);
	$smarty->assign('PHP_SELF', $_SERVER['PHP_SELF']);
