<?php
	/*
	 * Copyright 2006-2011 Florent Paillard
	 * 
	 * This file is part of /kal.ku.'li/.
	 * 
	 * /kal.ku.'li/ is free software: you can redistribute it and/or modify
	 * it under the terms of the GNU General Public License as published by
	 * the Free Software Foundation, either version 3 of the License, or
	 * (at your option) any later version.
	 * 
	 * /kal.ku.'li/ is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 * GNU General Public License for more details.
	 * 
	 * You should have received a copy of the GNU General Public License
	 * along with /kal.ku.'li/.  If not, see <http://www.gnu.org/licenses/>.
	 * 
	 */

	require_once('include/php_header.inc.php');
	
	// accessKey is valid
	if (!isset($_REQUEST['accessKey'])
			|| ($sheet = SheetQuery::create()->filterByAccessKey($_REQUEST['accessKey'])->findOne()) === null) {
		// TODO: Handle error
		trigger_error("Invalid accessKey value: " . $_REQUEST['accessKey'], E_USER_ERROR);
	}

	// person exists
	if (!isset($_REQUEST['personId'])
			|| !ctype_digit($_REQUEST['personId'])
			|| ($personId = intval($_REQUEST['personId'])) === 0
			|| ($person = PersonQuery::create()->filterBySheet($sheet)->findPK($personId)) === null) {
		// TODO: Handle error
		trigger_error("Invalid personId value: " . $_REQUEST['personId'], E_USER_ERROR);
	}

	$operationsList = OperationQuery::create()
		->getPersonOperationList($person->getPersonId());
	
	$smarty->assign('templateName',	'person-details');
	$smarty->assign_by_ref('sheet', $sheet);
	$smarty->assign_by_ref('person',	$person);
	$smarty->assign_by_ref('operationsList', $operationsList);

	if ($_SESSION['browserType'] == 'STANDARD')
		$smarty->display('layout.tpl');
	else
		$smarty->display('mobile/layout.tpl');
