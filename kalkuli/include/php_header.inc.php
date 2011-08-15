<?php

	/*
	 * Copyright 2006-2011 Florent Paillard
	 * 
	 * This file is part of /kal.'ku.li/.
	 * 
	 * /kal.'ku.li/ is free software: you can redistribute it and/or modify
	 * it under the terms of the GNU General Public License as published by
	 * the Free Software Foundation, either version 3 of the License, or
	 * (at your option) any later version.
	 * 
	 * /kal.'ku.li/ is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 * GNU General Public License for more details.
	 * 
	 * You should have received a copy of the GNU General Public License
	 * along with /kal.'ku.li/.  If not, see <http://www.gnu.org/licenses/>.
	 * 
	 */

	date_default_timezone_set('Europe/Paris');
	
	require_once('include/config.inc.php');

	session_start();

	require_once(PEAR_INCLUDE_PREFIX . 'propel/Propel.php');
	require_once('classes/Kalkuli.php');
	
	Propel::init('include/propel-db-config.inc.php');

	if (!isset($_SESSION['browserType'])) {
		if (Kalkuli::isMobileBrowser())
			$_SESSION['browserType'] = 'MOBILE';
		else
			$_SESSION['browserType'] = 'STANDARD';
	}

	if (isset($_REQUEST['forceBrowserType'])) {
		if ($_REQUEST['forceBrowserType'] == 'STANDARD')
			$_SESSION['browserType'] = 'STANDARD';
		else if ($_REQUEST['forceBrowserType'] == 'MOBILE')
			$_SESSION['browserType'] = 'MOBILE';
	}
	
	require_once(SMARTY_INCLUDE_PREFIX . 'smarty/Smarty.class.php');
	
	$smarty = new Smarty();
	
	$smarty->register_modifier('formatAmount', array('Kalkuli', 'formatAmount'));
	$smarty->register_modifier('formatSymbol', array('CurrencyType', 'getSymbol'));
	$smarty->unregister_modifier('money');
	$smarty->register_modifier('formatDate', array('Kalkuli', 'formatDate'));

	$smarty->register_function('round', 'smarty_round');
	
	$smarty->assign('CONTEXT_PATH', CONTEXT_PATH);
	$smarty->assign('TESTS_SITE', TESTS_SITE);
	$smarty->assign('GOOGLE_ANALYTICS_ID', GOOGLE_ANALYTICS_ID);

	function smarty_round($params, &$smarty) {
		return round($params['value']);
	}
