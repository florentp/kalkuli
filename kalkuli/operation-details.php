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

	// operation exists
	if (!isset($_REQUEST['operationId'])
			|| !ctype_digit($_REQUEST['operationId'])
			|| ($operationId = intval($_REQUEST['operationId'])) === 0
			|| ($operation = OperationQuery::create()->filterBySheet($sheet)->findPk($operationId)) === null) {
		// TODO: Handle error
		trigger_error("Invalid operationId value: " . $_REQUEST['operationId'], E_USER_ERROR);
	}
	
	if (isset($_REQUEST['action'])
			&& ($action = $_REQUEST['action']) !== 'addIncoming'
			&& $action !== 'addOutgoing'
			&& $action !== 'deleteIncoming'
			&& $action !== 'deleteOutgoing') {
		// TODO: Handle error
		trigger_error("Invalid action value: " . $_REQUEST['action'], E_USER_ERROR);
	}
	
	if (isset($action)) {
		switch ($action) {
			case 'addIncoming':

				// amount is numeric and not equal to 0
				if (!isset ($_REQUEST['amount'])
						|| !is_numeric($_REQUEST['amount'])
						|| ($amount = floatval($_REQUEST['amount'])) === 0.0) {
					// TODO: Handle error
					trigger_error("Invalid amount value: " . $_REQUEST['amount'], E_USER_ERROR);
				}

				// contributor exists
				if (!isset($_REQUEST['contributorId'])
						|| !ctype_digit($_REQUEST['contributorId'])
						|| ($contributorId = intval($_REQUEST['contributorId'])) === 0
						|| ($contributor = PersonQuery::create()->filterBySheet($sheet)->findPk($contributorId)) === null) {
					// TODO: Handle error
					trigger_error("Invalid contributorId value: " . $_REQUEST['contributorId'], E_USER_ERROR);
				}

				$dbConnection = Propel::getConnection(OperationPeer::DATABASE_NAME);

				$dbConnection->beginTransaction();
				try {
					$incoming = new Incoming();
					$incoming->setInAmount($amount);
					$incoming->setOperationIdFk($operationId);
					$incoming->setPersonIdFk($contributorId);
					$incoming->save();

					$sheet->setLastModificationTS(new DateTime());
					$sheet->save();

					$dbConnection->commit();

					header(sprintf("Location: %s/%s/operation/%s", CONTEXT_PATH, $sheet->getAccessKey(), $operationId));
				}
				catch (Exception $e) {
					$dbConnection->rollback();
					throw $e;
				}
				break;

			case 'addOutgoing':
				// weight is numeric and not equal to 0
				if (!isset ($_REQUEST['weight'])
						|| !is_numeric($_REQUEST['weight'])
						|| ($weight = floatval($_REQUEST['weight'])) === 0.0) {
					// TODO: Handle error
					trigger_error("Invalid weight value: " . $_REQUEST['weight'], E_USER_ERROR);
				}

				// participant exists
				if (!isset($_REQUEST['participantId'])
						|| !ctype_digit($_REQUEST['participantId'])
						|| ($participantId = intval($_REQUEST['participantId'])) === 0
						|| ($participant = PersonQuery::create()->filterBySheet($sheet)->findPk($participantId)) === null) {
					// TODO: Handle error
					trigger_error("Invalid contributorId value: " . $_REQUEST['contributorId'], E_USER_ERROR);
				}

				$dbConnection = Propel::getConnection(OperationPeer::DATABASE_NAME);

				$dbConnection->beginTransaction();
				try {
					$outgoing = new Outgoing();
					$outgoing->setOutWeight($weight);
					$outgoing->setOperationIdFk($operationId);
					$outgoing->setPersonIdFk($participantId);
					$outgoing->save();

					$sheet->setLastModificationTS(new DateTime());
					$sheet->save();
					
					$dbConnection->commit();

					header(sprintf("Location: %s/%s/operation/%s", CONTEXT_PATH, $sheet->getAccessKey(), $operationId));
				}
				catch (Exception $e) {
					$dbConnection->rollback();
					throw $e;
				}
				break;

			case 'deleteIncoming':
				// incoming exists in this operation
				if (!isset($_REQUEST['incomingId'])
						|| !ctype_digit($_REQUEST['incomingId'])
						|| ($incomingId = intval($_REQUEST['incomingId'])) === 0
						|| ($incoming = IncomingQuery::create()->findPk($incomingId)) === null
						|| $incoming->getOperationIdFk() !== $operationId) {
					// TODO: Handle error
					trigger_error("Invalid incomingId value: " . $_REQUEST['incomingId'], E_USER_ERROR);
				}

				$dbConnection = Propel::getConnection(OperationPeer::DATABASE_NAME);

				$dbConnection->beginTransaction();
				try {
					$incoming->delete();

					$sheet->setLastModificationTS(new DateTime());
					$sheet->save();
					
					$dbConnection->commit();

					header(sprintf("Location: %s/%s/operation/%s", CONTEXT_PATH, $sheet->getAccessKey(), $operationId));
				}
				catch (Exception $e) {
					$dbConnection->rollback();
					throw $e;
				}
				break;

			case 'deleteOutgoing':
				// outgoing exists in this operation
				if (!isset($_REQUEST['outgoingId'])
						|| !ctype_digit($_REQUEST['outgoingId'])
						|| ($outgoingId = intval($_REQUEST['outgoingId'])) === 0
						|| ($outgoing = OutgoingQuery::create()->findPk($outgoingId)) === null
						|| $outgoing->getOperationIdFk() !== $operationId) {
					// TODO: Handle error
					trigger_error("Invalid outgoingId value: " . $_REQUEST['outgoingId'], E_USER_ERROR);
				}

				$dbConnection = Propel::getConnection(OperationPeer::DATABASE_NAME);

				$dbConnection->beginTransaction();
				try {
					$outgoing->delete();

					$sheet->setLastModificationTS(new DateTime());
					$sheet->save();
					
					$dbConnection->commit();

					header(sprintf("Location: %s/%s/operation/%s", CONTEXT_PATH, $sheet->getAccessKey(), $operationId));
				}
				catch (Exception $e) {
					$dbConnection->rollback();
					throw $e;
				}
				break;
		}
	}
	
	$incomingsList = IncomingQuery::create()
		->filterByOperation($operation)
		->usePersonQuery()
			->orderByPersonname()
		->endUse()
		->find();

	$outgoingsList = OutgoingQuery::create()
		->filterByOperation($operation)
		->usePersonQuery()
			->orderByPersonname()
		->endUse()
		->find();
	
	$peopleList = PersonQuery::create()
		->filterBySheet($sheet)
		->orderByPersonname()
		->find();
	
	$smarty->assign('templateName', 'operation-details');
	$smarty->assign_by_ref('sheet', $sheet);
	$smarty->assign_by_ref('operation',	$operation);
	$smarty->assign_by_ref('incomingsList',	$incomingsList);
	$smarty->assign_by_ref('outgoingsList',	$outgoingsList);
	$smarty->assign_by_ref('peopleList',	$peopleList);
	
	if ($_SESSION['browserType'] == 'STANDARD')
		$smarty->display('layout.tpl');
	else
		$smarty->display('mobile/layout.tpl');
