{include file="menu.tpl"}
<div class="ui-main-widget">
	<div class="ui-main-widget-header">Ajouter des participants</div>

	<form action="{$CONTEXT_PATH}/{$sheet->getAccessKey()}/person/add" id="addPeopleForm" name="addPeopleForm" method="post">
		<table class="tableForm">
			{section start=0 loop=5 name="peopleList"}
				<tr>
					<th>Participant {$smarty.section.peopleList.iteration}&nbsp;:</th>
					<td>
						<input class="name" id="namesList{$smarty.section.peopleList.iteration}" name="namesList[{$smarty.section.peopleList.iteration}]" maxlength="255" type="text" />
						<div id="namesList{$smarty.section.peopleList.iteration}FormValidationMessage" class="formValidationMessage"></div>
					</td>
				</tr>
			{/section}
			<tr class="buttonRow">
				<td colspan="2">
					<button class="ui-button" name="addPeopleButton" type="submit">Enregistrer</button>
					<button class="ui-button" id="cancelButton">Annuler</button>
				</td>
			</tr>
		</table>
	</form>
</div>

<script src="{$CONTEXT_PATH}/js/people-add.js" type="text/javascript"></script>
{literal}
<script type="text/javascript">
	$(function() {

		$('#cancelButton').click(function() {
			$.doGet(sprintf('%s/%s', CONTEXT_PATH, SHEET_ACCESS_KEY));
		});

		$('#addPeopleForm').validate({
			errorPlacement : function (label, element) {
				label.appendTo($('#' + element[0].id + 'FormValidationMessage'));
			}
		});
		
		loadValidationRules();
	});
</script>
{/literal}