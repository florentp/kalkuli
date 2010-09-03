<?php
	
	require_once('include/php_header.inc.php');
	require_once('HTML/QuickForm.php');
	require_once('HTML/QuickForm/Renderer/ArraySmarty.php');
	
	$form = new HTML_QuickForm('form', 'POST');

	for ($i = date('Y') - 2; $i <= date('Y') + 2;$i++)
		$years[$i] = $i;
	for ($i = 1; $i <= 12;$i++)
		$months[$i] = $i;
	for ($i = 1; $i <= 31;$i++)
		$days[$i] = $i;
	$form->addElement('select'		, 'dateYear'	, null		, $years);
	$form->addElement('select'		, 'dateMonth'	, null		, $months);
	$form->addElement('select'		, 'dateDay'		, null		, $days);
	$form->addElement('text'		, 'description'	, 'Description&nbsp;:'		, array('class' => 'description', 'maxlength' => 255));
	$form->addElement('text'		, 'amount'		, "Montant&nbsp;:"		, array('class' => 'amount', 'maxlength' => 10));
	$form->addElement('select'		, 'contributor'	, 'Celui qui a contribué à cette opération&nbsp;:'		, PersonQuery::formOptionsArray(), array('class' => 'contributor'));
	
	$peopleList = PersonQuery::create()
		->orderByPersonname()
		->find();
	if (count($peopleList) == 0)
		header('Location: index.php');
	foreach ($peopleList as $person) {
		$form->addElement('checkbox'	, 'consumersList[' . $person->getPersonId() . ']' , null, $person->getPersonName());
		$form->addElement('text'		, 'consumersWeightsList[' . $person->getPersonId() . ']'	, null	, array('class' => 'weight', 'maxlength' => 10));
		$form->addRule('consumersWeightsList[' . $person->getPersonId() . ']', 'Le coefficient saisi pour ' . $person->getPersonName() . ' doit être un nombre', 'numeric', null, 'client');
	}
	
	$form->addElement('submit'		, 'submit'			, 'Ajouter');
	
	$form->addRule('description', 'Vous devez saisir une description', 'required', null, 'client');
	$form->addRule('amount', 'Vous devez saisir un montant', 'required', null, 'client');
	$form->addRule('amount', 'Le montant saisi doit être un nombre', 'numeric', null, 'client');
	
	$formDefaultValues = array (
			'dateYear' => date('Y'),
			'dateMonth' => date('n'),
			'dateDay' => date('j')
		);

	foreach ($peopleList as $person) {
		$formDefaultValues['consumersWeightsList[' . $person->getPersonId() . ']'] = 1;
	}
		
	$form->setDefaults($formDefaultValues);
	
	if ($form->validate()) {
		$operation = new Operation();
		$operation->setOperationTS("$_REQUEST[dateYear]-$_REQUEST[dateMonth]-$_REQUEST[dateDay]");
		$operation->setOperationDescription($_REQUEST['description']);
		$operation->save();
		
		$incoming = new Incoming();
		$incoming->setInAmount($_REQUEST['amount']);
		$incoming->setOperationIdFk($operation->getOperationId());
		$incoming->setPersonIdFk($_REQUEST['contributor']);
		$incoming->save();
		
		foreach ($_REQUEST['consumersList'] as $contributorId => $value) {
			$outgoing = new Outgoing();
			$outgoing->setOutWeight($_REQUEST['consumersWeightsList'][$contributorId]);
			$outgoing->setOperationIdFk($operation->getOperationId());
			$outgoing->setPersonIdFk($contributorId);
			$outgoing->save();
		}
		
		header('Location: operation-details.php?operationId=' . $operation->getOperationId());
	}
	
	$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty, true);
	
	$renderer->setRequiredTemplate(
		'{if $error}
			<font color="red">{$label}</font>
		{else}
			{$label}
		{/if}'
	);
	
	$renderer->setErrorTemplate(
		'{if $error}
			<font color="red">{$label}</font>
		{else}
			{$label}
		{/if}'
	);
	
	$form->accept($renderer);
	
	$smarty->assign('templateName',	'operation-add');
	$smarty->assign('nPeople', count($peopleList));
	$smarty->assign_by_ref('form', $renderer->toArray());

	if (Money::isMobileBrowser())
		$smarty->display('mobile/layout.tpl');
	else
		$smarty->display('layout.tpl');
