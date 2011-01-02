<?php
	
	require_once('include/php_header.inc.php');

	// accessKey is valid
	if (!isset($_REQUEST['accessKey'])
			|| ($sheet = SheetQuery::create()->filterByAccessKey($_REQUEST['accessKey'])->findOne()) === null) {
		// TODO: Handle error
		trigger_error("Invalid accessKey value: " . $_REQUEST['accessKey'], E_USER_ERROR);
	}
	
	$peopleList = PersonQuery::create()
		->filterBySheet($sheet)
		->orderByPersonname()
		->find();
	if (count($peopleList) == 0)
		header(sprintf('Location: %s/%s', CONTEXT_PATH, $sheet->getAccessKey()));

	if (isset($_REQUEST['addOperationButton'])) {

		// contributor exists
		if (!isset($_REQUEST['contributorId'])
				|| !ctype_digit($_REQUEST['contributorId'])
				|| ($contributorId = intval($_REQUEST['contributorId'])) === 0
				|| ($contributor = PersonQuery::create()->filterBySheet($sheet)->findPk($contributorId)) === null) {
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
						|| ($consumer = PersonQuery::create()->filterBySheet($sheet)->findPk($consumerId)) === null) {
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
			$operation->setTotalInAmount(0);
			$operation->setTotalOutWeight(0);
			$operation->setSheet($sheet);
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

			$sheet->setLastModificationTS(new DateTime());
			$sheet->save();

			$dbConnection->commit();

		}
		catch (Exception $e) {
			$dbConnection->rollback();
			throw $e;
		}
		
		header(sprintf('Location: %s/%s/operation/%s', CONTEXT_PATH, $sheet->getAccessKey(), $operation->getOperationId()));
	}
	
	$smarty->assign('templateName',	'operation-add');
	$smarty->assign_by_ref('sheet', $sheet);
	$smarty->assign('peopleList', $peopleList);
	$smarty->assign('nPeople', count($peopleList));

	if (Kalkuli::isMobileBrowser())
		$smarty->display('mobile/layout.tpl');
	else
		$smarty->display('layout.tpl');
