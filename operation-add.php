<?php
	
	require_once('include/php_header.inc.php');
	
	$peopleList = PersonQuery::create()
		->orderByPersonname()
		->find();
	if (count($peopleList) == 0)
		header('Location: index.php');

	if (isset($_REQUEST['addOperationButton'])) {

		// contributor exists
		if (!isset($_REQUEST['contributorId'])
				|| !ctype_digit($_REQUEST['contributorId'])
				|| ($contributorId = intval($_REQUEST['contributorId'])) === 0
				|| ($contributor = PersonQuery::create()->findPk($contributorId)) === null) {
			// TODO: Handle error
			trigger_error("Invalid contributorId value: " . $_REQUEST['contributorId'], E_USER_ERROR);
		}

		// amount is numeric and not equal to 0
		if (!isset ($_REQUEST['amount'])
				|| !is_numeric($_REQUEST['amount'])
				|| ($amount = floatval($_REQUEST['amount'])) === 0.0) {
			// TODO: Handle error
			trigger_error("Invalid amount value: " . $_REQUEST['amount'], E_USER_ERROR);
		}

		// description is not empty
		if (!isset($_REQUEST['description'])
				|| strlen($description = trim($_REQUEST['description'])) === 0) {
			// TODO: Handle error
			trigger_error("Invalid description value: " . $_REQUEST['description'], E_USER_ERROR);
		}
		
		// date format is valid
		if (!($date = DateTime::createFromFormat('d/m/Y H:i:s', $_REQUEST['date'] . ' 00:00:00'))) {
			// TODO: Handle error
			trigger_error("Invalid date value: " . $_REQUEST['date'], E_USER_ERROR);
		}

		// consumers exist
		if (!isset($_REQUEST['consumersIdList'])
				|| !is_array($_REQUEST['consumersIdList'])
				|| !isset ($_REQUEST['consumersWeightsList'])
				|| !is_array($_REQUEST['consumersWeightsList'])) {
			// TODO: Handle error
			trigger_error("consumersIdList and consumersWeightsList must be arrays", E_USER_ERROR);
		}
		else {
			$consumersIdList = array();
			$consumersWeightList = array();
			foreach($_REQUEST['consumersIdList'] as $consumerId => $value) {
				if (!is_int($consumerId) && !ctype_digit($consumerId)
						|| ($consumerId = intval($consumerId)) === 0
						|| ($consumer = PersonQuery::create()->findPk($consumerId)) === null) {
					// TODO: Handle error
					trigger_error("Invalid consumerId value: " . $consumerId, E_USER_ERROR);
				}

				if (!isset ($_REQUEST['consumersWeightsList'][$consumerId])
						|| !is_numeric($_REQUEST['consumersWeightsList'][$consumerId])
						|| ($weight = floatval($_REQUEST['consumersWeightsList'][$consumerId])) === 0.0) {
					// TODO: Handle error
					trigger_error("Invalid consumersWeight value for consumerId $consumerId: " . $_REQUEST['consumersWeightsList'][$consumerId], E_USER_ERROR);
				}

				$consumersIdList[] = $consumerId;
				$consumersWeightList[$consumerId] = $weight;
			}
		}

		$dbConnection = Propel::getConnection(OperationPeer::DATABASE_NAME);

		$dbConnection->beginTransaction();

		try {
			$operation = new Operation();
			$operation->setOperationTS($date->format('Y-m-d'));
			$operation->setOperationDescription($description);
			$operation->save();
			
			$incoming = new Incoming();
			$incoming->setInAmount($amount);
			$incoming->setOperation($operation);
			$incoming->setPersonIdFk($contributorId);
			$incoming->save();
			
			foreach ($consumersIdList as $consumerId) {
				$outgoing = new Outgoing();
				$outgoing->setOutWeight($consumersWeightList[$consumerId]);
				$outgoing->setOperation($operation);
				$outgoing->setPersonIdFk($consumerId);
				$outgoing->save();
			}
			$dbConnection->commit();

		}
		catch (Exception $e) {
			$dbConnection->rollback();
			throw $e;
		}
		
		header('Location: operation-details.php?operationId=' . $operation->getOperationId());
	}
	
	$smarty->assign('templateName',	'operation-add');
	$smarty->assign('peopleList', $peopleList);
	$smarty->assign('nPeople', count($peopleList));
	$smarty->assign('CURRENCY', CURRENCY);

	if (Kalkuli::isMobileBrowser())
		$smarty->display('mobile/layout.tpl');
	else
		$smarty->display('layout.tpl');
