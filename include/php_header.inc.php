<?php

	require_once('include/config.inc.php');
	
	if (!file_exists(DATABASE_PATH)) {
		header('Location: install.php');
		die();
	}
	require_once('propel/Propel.php');
	require_once('classes/Incoming.php');
	require_once('classes/Outgoing.php');
	require_once('classes/Person.php');
	require_once('classes/Operation.php');
	require_once('classes/Money.php');
	
	Propel::init('include/propel-db-config.inc.php');
	
	require_once('smarty/Smarty.class.php');
	
	$smarty = new Smarty();
	
	$smarty->register_modifier('formatMoney', array('Money', 'formatMoney'));
	$smarty->unregister_modifier('money');
	
	$smarty->assign('CURRENCY', CURRENCY);
	$smarty->assign('PHP_SELF', $_SERVER['PHP_SELF']);
