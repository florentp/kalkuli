<?php
	
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

				$incoming = new Incoming();
				$incoming->setInAmount($amount);
				$incoming->setOperationIdFk($operationId);
				$incoming->setPersonIdFk($contributorId);
				$incoming->save();
				header(sprintf("Location: %s/%s/operation/%s", CONTEXT_PATH, $sheet->getAccessKey(), $operationId));
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

				$outgoing = new Outgoing();
				$outgoing->setOutWeight($weight);
				$outgoing->setOperationIdFk($operationId);
				$outgoing->setPersonIdFk($participantId);
				$outgoing->save();
				header(sprintf("Location: %s/%s/operation/%s", CONTEXT_PATH, $sheet->getAccessKey(), $operationId));
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

				$incoming->delete();
				header(sprintf("Location: %s/%s/operation/%s", CONTEXT_PATH, $sheet->getAccessKey(), $operationId));
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

				$outgoing->delete();
				header(sprintf("Location: %s/%s/operation/%s", CONTEXT_PATH, $sheet->getAccessKey(), $operationId));
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
	
	if (Kalkuli::isMobileBrowser())
		$smarty->display('mobile/layout.tpl');
	else
		$smarty->display('layout.tpl');
