<div data-role="page" data-theme="b" id="operationDetails">
	<div data-role="header">
		<h1>/kal.'ku.li/</h1>
	</div>
	<div data-role="content">
		<h2><a href="{$CONTEXT_PATH}/{$sheet->getAccessKey()}" rel="external">{$sheet->getName()|escape}</a> > Nouvelle opération</h2>
		<form action="{$CONTEXT_PATH}/{$sheet->getAccessKey()}/operation/add" id="addOperationForm" name="addOperationForm" method="post">
			<input id="addOperationButton" name="addOperationButton" type="hidden" value="addOperationButton" />
			<div data-role="fieldcontain">
				<label for="contributorId">Contributeur&nbsp;:</label>
				<select id="contributorId" name="contributorId">
					{foreach from=$peopleList item="person"}
						<option value="{$person->getPersonId()}">{$person->getPersonName()|escape}</option>
					{/foreach}
				</select>
			</div>
			<div data-role="fieldcontain">
				<label for="amount">Montant ({$sheet->getCurrencyCode()|formatSymbol})&nbsp;:</label>
				<input class="amount" id="amount" maxlength="10" name="amount" type="text" />
				<div class="formValidationMessage" id="amountFormValidationMessage"></div>
			</div>
			<div data-role="fieldcontain">
				<label for="description">Description&nbsp;:</label>
				<input id="description" maxlength="255" name="description" type="text" />
				<div class="formValidationMessage" id="descriptionFormValidationMessage"></div>
			</div>
			<div data-role="fieldcontain">
				<label for="date">Date&nbsp;:</label>
				<input id="date" name="date" style="display: none;" type="date" />
			</div>
			{foreach from=$peopleList key="consumerId" item="consumer" name="peopleList"}
				<div data-role="fieldcontain">
					<table style="width: 100%;">
						<colgroup>
							<col />
							<col style="width: 8em;" />
						</colgroup>
						<tr>
							<td>
								<input checked="checked" class="consumerCheckbox" id ="consumersIdList{$consumer->getPersonId()}" name="consumersIdList[{$consumer->getPersonId()}]" type="checkbox" />
								<label for="consumersIdList{$consumer->getPersonId()}">{$consumer->getPersonName()|escape}</label>
							</td>
							<td style="text-align: right;">
								<label class="ui-input-text-inline" for="consumersWeightsList{$consumer->getPersonId()}" style="display: inline-block; vertical-align:inherit; width: auto;">Part&nbsp;:</label>
								<input class="weight ui-input-text-inline" id="consumersWeightsList{$consumer->getPersonId()}" name="consumersWeightsList[{$consumer->getPersonId()}]" maxlength="10" type="text" value="1" />
							</td>
						</tr>
					</table>
					<div id="consumersWeightsList{$consumer->getPersonId()}FormValidationMessage" class="formValidationMessage"></div>
				</div>
			{/foreach}
			<div data-role="fieldcontain">
				<button type="submit" data-theme="b">Enregistrer</button>
			</div>
		</form>
	</div>
</div>
	
<script src="{$CONTEXT_PATH}/js/operation-add.js" type="text/javascript"></script>
{literal}
<script type="text/javascript">
	$(function() {

		$('.consumerCheckbox').click(function() {
			if ($('.consumerCheckbox:checked').length < 1)
				return false;
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