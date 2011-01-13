<?php

	date_default_timezone_set('Europe/Paris');
	
	if (file_exists('include/config.inc.php'))
		require_once('include/config.inc.php');
	else {
		header(sprintf('Location: install'));
		die();
	}

	require_once(PEAR_INCLUDE_PREFIX . 'propel/Propel.php');
	require_once('classes/Kalkuli.php');
	
	Propel::init('include/propel-db-config.inc.php');
	
	require_once(SMARTY_INCLUDE_PREFIX . 'smarty/Smarty.class.php');
	
	$smarty = new Smarty();
	
	$smarty->register_modifier('formatAmount', array('Kalkuli', 'formatAmount'));
	$smarty->register_modifier('formatSymbol', array('CurrencyType', 'getSymbol'));
	$smarty->unregister_modifier('money');
	$smarty->register_modifier('formatDate', array('Kalkuli', 'formatDate'));

	$smarty->register_function('round', 'smarty_round');
	
	$smarty->assign('CONTEXT_PATH', CONTEXT_PATH);

	function smarty_round($params, &$smarty) {
		return round($params['value']);
	}