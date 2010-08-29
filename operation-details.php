<?php
	
	require_once('include/php_header.inc.php');
	require_once('HTML/QuickForm.php');
	require_once 'HTML/QuickForm/Renderer/ArraySmarty.php';
	
	$operationId = isset($_REQUEST['operationId']) ? $_REQUEST['operationId'] : null;
	if (!isset($operationId))
		die("'operationId' must be set");
	
	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;
	if (isset($action)) {
		switch ($action) {
			case 'addIn':
			case 'addOut':
				// Treated by validate() function of QuickForm
				break;
			case 'deleteIn':
				$c = new Criteria();
				$c->add(IncomingPeer::INID, $_REQUEST['toDeleteId']);
				IncomingPeer::doDelete($c);
				break;
			case 'deleteOut':
				$c = new Criteria();
				$c->add(OutgoingPeer::OUTID, $_REQUEST['toDeleteId']);
				OutgoingPeer::doDelete($c);
				break;
			default;
				die("'action' value is incorrect");
		}
	}

	$operation = OperationPeer::retrieveByPk($operationId);
	
	$incomingsList = $operation->getIncomingsJoinPerson();
	$outgoingsList = $operation->getOutgoingsJoinPerson();
	
	$addInForm = new HTML_QuickForm('addInForm', 'POST');
	$addInForm->addElement('hidden'		, 'action'			, 'addIn');
	$addInForm->addElement('hidden'		, 'operationId'		, $operation->getOperationId());
	$addInForm->addElement('select'		, 'personId'		, 'Nom&nbsp;:'			, PersonPeer::formOptionsArray());
	$addInForm->addElement('text'		, 'amount'			, 'Montant&nbsp;:'		, array('class' => 'amount', 'maxlength' => 10));
	$addInForm->addElement('submit'		, 'submit'			, 'Ajouter');
	
	$addInForm->addRule('amount'	, 'Vous devez saisir un montant'	, 'required'	, null	, 'client');
	$addInForm->addRule('amount'	, 'Le montant doit être un nombre'	, 'numeric'		, null	, 'client');
	
	if ($addInForm->validate()) {
		$incoming = new Incoming();
		$incoming->setInAmount($_REQUEST['amount']);
		$incoming->setOperationIdFk($_REQUEST['operationId']);
		$incoming->setPersonIdFk($_REQUEST['personId']);
		$incoming->save();
		header("Location: $_SERVER[PHP_SELF]?operationId=" . $operation->getOperationId());
	}
	
	$addInRenderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty, true);
	
	$addInRenderer->setRequiredTemplate(
		'{if $error}
			<font color="red">{$label}</font>
		{else}
			{$label}
		{/if}'
	);
	
	$addInRenderer->setErrorTemplate(
		'{if $error}
			<font color="red">{$label}</font>
		{else}
			{$label}
		{/if}'
	);
	
	$addInForm->accept($addInRenderer);
	
	$addOutForm = new HTML_QuickForm('addOutForm', 'POST');
	$addOutForm->addElement('hidden'		, 'action'			, 'addOut');
	$addOutForm->addElement('hidden'		, 'operationId'		, $operation->getOperationId());
	$addOutForm->addElement('select'		, 'personId'		, 'Nom&nbsp;:'		, PersonPeer::formOptionsArray());
	$addOutForm->addElement('text'			, 'weight'			, 'Part&nbsp;:'		, array('class' => 'weight', 'maxlength' => 10));
	$addOutForm->addElement('submit'		, 'submit'			, 'Ajouter');

	$addOutForm->addRule('weight'	, 'Vous devez saisir une part'	, 'required'	, null	, 'client');
	$addOutForm->addRule('weight'	, 'La part doit être un nombre'	, 'numeric'		, null	, 'client');

	$addOutFormDefaultValues = array (
			'weight' => 1
		);

	$addOutForm->setDefaults($addOutFormDefaultValues);

	if ($addOutForm->validate()) {
		$incoming = new Outgoing();
		$incoming->setOutWeight($_REQUEST['weight']);
		$incoming->setOperationIdFk($_REQUEST['operationId']);
		$incoming->setPersonIdFk($_REQUEST['personId']);
		$incoming->save();
		header("Location: $_SERVER[PHP_SELF]?operationId=" . $operation->getOperationId());
	}
	
	$addOutRenderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty, true);

	$addOutRenderer->setRequiredTemplate(
		'{if $error}
			<font color="red">{$label}</font>
		{else}
			{$label}
		{/if}'
	);
	
	$addOutRenderer->setErrorTemplate(
		'{if $error}
			<font color="red">{$label}</font>
		{else}
			{$label}
		{/if}'
	);
	
	$addOutForm->accept($addOutRenderer);
	
	$smarty->assign('templateName',	'operation-details');
	$smarty->assign_by_ref('operation',	$operation);
	$smarty->assign_by_ref('incomingsList',	$incomingsList);
	$smarty->assign('nIncomings', count($incomingsList));
	$smarty->assign_by_ref('outgoingsList',	$outgoingsList);
	$smarty->assign('nOutgoings', count($outgoingsList));
	$smarty->assign_by_ref('addInForm', $addInRenderer->toArray());
	$smarty->assign_by_ref('addOutForm', $addOutRenderer->toArray());
	
	if (Money::isMobileBrowser())
		$smarty->display('mobile/layout.tpl');
	else
		$smarty->display('layout.tpl');
