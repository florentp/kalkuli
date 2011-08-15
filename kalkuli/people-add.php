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

	require_once('include/php_header.inc.php');

	// accessKey is valid
	if (!isset($_REQUEST['accessKey'])
			|| ($sheet = SheetQuery::create()->filterByAccessKey($_REQUEST['accessKey'])->findOne()) === null) {
		// TODO: Handle error
		trigger_error("Invalid accessKey value: " . $_REQUEST['accessKey'], E_USER_ERROR);
	}

	if (isset($_REQUEST['addPeopleButton'])) {
		
		// name is not empty
		if (!isset($_REQUEST['namesList'])
				|| !is_array($_REQUEST['namesList'])) {
			// TODO: Handle error
			trigger_error("namesList must be an array", E_USER_ERROR);
		}
		else {
			$namesList = array();
			foreach($_REQUEST['namesList'] as $name) {
				if (strlen($name = trim($name)) !== 0)
					$namesList[] = $name;
			}
			if (count($namesList) === 0) {
				// TODO: Handle error
				trigger_error("namesList is empty", E_USER_ERROR);
			}
		}

		$dbConnection = Propel::getConnection(OperationPeer::DATABASE_NAME);

		$dbConnection->beginTransaction();
		try {
			foreach($namesList as $name) {
				$person = new Person();
				$person->setPersonName($name);
				$person->setSheet($sheet);
				$person->save();
			}

			$sheet->setLastModificationTS(new DateTime());
			$sheet->save();

			$dbConnection->commit();
		}
		catch (Exception $e) {
			$dbConnection->rollback();
			throw $e;
		}
		
		header(sprintf('Location: %s/%s', CONTEXT_PATH, $sheet->getAccessKey()));
	}
	
	$smarty->assign('templateName',	'people-add');
	$smarty->assign_by_ref('sheet', $sheet);

	if ($_SESSION['browserType'] == 'STANDARD')
		$smarty->display('layout.tpl');
	else
		$smarty->display('mobile/layout.tpl');
