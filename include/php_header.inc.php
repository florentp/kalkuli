<?php

	require_once('include/config.inc.php');

	date_default_timezone_set('Europe/Paris');
	
	if (!file_exists(DATABASE_PATH)) {
		header(sprintf('Location: %s/install', CONTEXT_PATH));
		die();
	}
	require_once('propel/Propel.php');
	require_once('classes/Kalkuli.php');
	
	Propel::init('include/propel-db-config.inc.php');
	
	require_once('smarty/Smarty.class.php');
	
	$smarty = new Smarty();
	
	$smarty->register_modifier('formatMoney', array('Kalkuli', 'formatMoney'));
	$smarty->unregister_modifier('money');
	$smarty->register_modifier('formatDate', array('Kalkuli', 'formatDate'));

	$smarty->register_function('round', 'smarty_round');
	
	$smarty->assign('CURRENCY', CURRENCY);
	$smarty->assign('CONTEXT_PATH', CONTEXT_PATH);

	function smarty_round($params, &$smarty) {
		return round($params['value']);
	}