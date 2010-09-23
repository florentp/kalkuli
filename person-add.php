<?php
	
	require_once('include/php_header.inc.php');
	require_once('HTML/QuickForm.php');
	require_once('HTML/QuickForm/Renderer/ArraySmarty.php');
	
	$form = new HTML_QuickForm('form', 'POST');
	$form->addElement('text'		, 'name'	, null	, array('class' => 'participantName', 'maxlength' => 255));	
	$form->addElement('submit'		, 'submit'			, 'Ajouter');
	
	$form->addRule('name', 'Vous devez saisir un nom', 'required', null, 'client');
	
	if ($form->validate()) {
		$person = new Person();
		$person->setPersonName($_REQUEST['name']);
		$person->save();
		
		header('Location: person-details.php?personId=' . $person->getPersonId());
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
	
	$smarty->assign('templateName',	'person-add');
	$smarty->assign_by_ref('form', $renderer->toArray());

	if (Kalkuli::isMobileBrowser())
		$smarty->display('mobile/layout.tpl');
	else
		$smarty->display('layout.tpl');
	