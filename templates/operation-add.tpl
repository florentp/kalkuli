{include file="menu.tpl"}
<div class="ui-main-widget">
	<div class="ui-main-widget-header">Nouvelle opération</div>
	<form action="{$CONTEXT_PATH}/operation/add" id="addOperationForm" name="addOperationForm" method="post">
		<table class="tableForm">
			<colgroup>
				<col />
				<col style="width: 8em;" />
				<col style="width: 8em;" />
			</colgroup>
			<tr>
				<th><label for="contributorId">Contributeur&nbsp;:</label></th>
				<td colspan="2">
					<select id="contributorId" name="contributorId">
						{foreach from=$peopleList item="person"}
							<option value="{$person->getPersonId()}">{$person->getPersonName()|escape}</option>
						{/foreach}
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="amount">Montant&nbsp;:</label></th>
				<td colspan="2">
					<input class="amount" id="amount" maxlength="10" name="amount" type="text" />&nbsp;{$CURRENCY}
					<div class="formValidationMessage" id="amountFormValidationMessage"></div>
				</td>
			</tr>
			<tr>
				<th><label for="description">Description&nbsp;:</label></th>
				<td colspan="2">
					<input class="description" id="description" maxlength="255" name="description" style="" type="text" />
					<div class="formValidationMessage" id="descriptionFormValidationMessage"></div>
				</td>
			</tr>
			<tr>
				<th><label for="date">Date&nbsp;:</label></th>
				<td colspan="2">
					<img src="{$CONTEXT_PATH}/icons/calendar_day.png" align="absmiddle" alt="Modifier la date" />&nbsp;<a class="datepicker" id="dateLink" href="#"><span id="dateLinkSpan"></span></a>
					<input type="hidden" id="date" name="date" />
				</td>
			</tr>
			<tr>
				<td colspan="3"></td>
			</tr>
			{foreach from=$peopleList key="consumerId" item="consumer" name="peopleList"}
				<tr>
					{if $smarty.foreach.peopleList.first}
						<th rowspan="{$nPeople*2}">Participants&nbsp;:</th>
					{/if}
					<td style="padding: .2em .6em 0 .6em;">
						<input checked="checked" class="consumerCheckbox" id ="consumersIdList{$consumer->getPersonId()}" name="consumersIdList[{$consumer->getPersonId()}]" type="checkbox" />
						<label for="consumersIdList{$consumer->getPersonId()}">{$consumer->getPersonName()|escape}</label>
					</td>
					<td style="padding: .2em .6em 0 .6em; text-align: right;">
						<label for="consumersWeightsList{$consumer->getPersonId()}">Part&nbsp;:</label>
						<input class="weight" id="consumersWeightsList{$consumer->getPersonId()}" name="consumersWeightsList[{$consumer->getPersonId()}]" maxlength="10" type="text" value="1" />
					</td>
				</tr>
				<tr>
					<td colspan="2" style="padding: 0 .6em .2em .6em;">
						<div id="consumersWeightsList{$consumer->getPersonId()}FormValidationMessage" class="formValidationMessage"></div>
					</td>
				</tr>
			{/foreach}
			<tr class="buttonRow">
				<td colspan="3">
					<button class="ui-button" id="addOperationButton" name="addOperationButton" type="submit">Enregistrer</button>
					<button class="ui-button" id="cancelButton">Annuler</button>
				</td>
			</tr>
		</table>
		
	</form>
</div>

<script src="{$CONTEXT_PATH}/js/operation-add.js" type="text/javascript"></script>
{literal}
<script type="text/javascript">
	$(function() {

		$('.consumerCheckbox').click(function() {
			if ($('.consumerCheckbox:checked').length < 1)
				return false;
		});
		
		$('#date').val($.datepicker.formatDate('dd/mm/yy', new Date()));
		$('#dateLinkSpan').text('Le ' + $('#date').val());

		$('#dateLink').click(function (event) {
			$(this).datepicker(
				'dialog',
				$('#date').val(),
				function(dateText, datepicker) {
					$('#date').val(dateText);
					$('#dateLinkSpan').text('Le ' + dateText);
				},
				{
					dateFormat: 'dd/mm/yy',
					duration: 0
				}
			);
			$('#ui-datepicker-div').css('z-index', '1000');
			return false;
		});

		$('#cancelButton').click(function() {
			$.doGet(CONTEXT_PATH);
		});

		$('#addOperationForm').validate({
			errorPlacement : function (label, element) {
				label.appendTo($('#' + element[0].id + 'FormValidationMessage'));
			}
		});

		loadValidationRules();
	});
</script>
{/literal}