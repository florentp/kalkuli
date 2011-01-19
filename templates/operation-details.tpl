<h1><a href="{$CONTEXT_PATH}/{$sheet->getAccessKey()}">{$sheet->getName()|escape}</a> > <span class="alternate">{$operation->getOperationDescription()|escape}</span></h1>
<div class="ui-main-widget">
	<div class="ui-main-widget-separator">Contributions</div>
	<div class="ui-main-widget-section">
		<form action="{$CONTEXT_PATH}/{$sheet->getAccessKey()}/operation/{$operation->getOperationId()}" id="addIncomingForm" method="post">
			<input name="action" type="hidden" value="addIncoming" />
			<table cellpadding="0"cellspacing="0" class="dataGrid">
				<colgroup>
					<col />
					<col />
					<col style="width: 3em;" />
				</colgroup>
				{foreach from=$incomingsList item="incoming" name="incomingsList"}
					{if $smarty.foreach.incomingsList.index is even}
						<tr>
					{else}
						<tr class="alternate">
					{/if}
							<td>
								<a href="{$CONTEXT_PATH}/{$sheet->getAccessKey()}/person/{$incoming->getPersonId()}">{$incoming->getPersonName()|escape}</a>
							</td>
							<td class="amount">{$incoming->getInAmount()|formatAmount:$sheet->getCurrencyCode()}</td>
							<td>
								<button class="ui-button" onclick="confirmIncomingDelete('{$incoming->getPersonName()|escape:'javascript'|escape}', '{$incoming->getInId()}')" type="button"><span class="ui-icon ui-icon-close"></span></button>
							</td>
					</tr>
				{foreachelse}
					<tr>
						<td colspan="3" style="font-style: italic; text-align: center;">Aucune contribution enregistrée.</td>
					</tr>
				{/foreach}
				<tr>
					<td colspan="2" style="text-align: right;">
						<div>
							<select id="contributorId" name="contributorId">
								{foreach from=$peopleList item="person"}
									<option value="{$person->getPersonId()}">{$person->getPersonName()|escape}</option>
								{/foreach}
							</select>
							<input class="amount" id="amount" maxlength="10" name="amount" type="text" />&nbsp;{$sheet->getCurrencyCode()|formatSymbol}
						</div>
						<div class="formValidationMessage" id="amountFormValidationMessage" style="float: right;"></div>
					</td>
					<td>
						<button class="ui-button" id="addIncomingButton" name="addIncomingButton" type="submit"><span class="ui-icon ui-icon-plus"></span></button>
					</td>
				</tr>
			</table>
		</form>
	</div>

	<div class="ui-main-widget-separator">Participations</div>
	<div class="ui-main-widget-section">
		<form action="{$CONTEXT_PATH}/{$sheet->getAccessKey()}/operation/{$operation->getOperationId()}" id="addOutgoingForm" method="post">
			<input name="action" type="hidden" value="addOutgoing" />
			<table cellpadding="0"cellspacing="0" class="dataGrid">
				<colgroup>
					<col />
					<col />
					<col style="width: 3em;" />
				</colgroup>
				{foreach from=$outgoingsList item="outgoing" name="outgoingsList"}
					{if $smarty.foreach.outgoingsList.index is even}
						<tr>
					{else}
						<tr class="alternate">
					{/if}
							<td>
								<a href="{$CONTEXT_PATH}/{$sheet->getAccessKey()}/person/{$outgoing->getPersonId()}">{$outgoing->getPersonName()|escape}</a>
							</td>
							<td class="weight">
								
								<div>{$outgoing->computeWeightedPart()|formatAmount:$sheet->getCurrencyCode()}</div>
								<div style="font-size: 0.8em;">{$outgoing->getOutWeight()} part(s) sur {$outgoing->getOperationTotalOutWeight()}</div>
							</td>
							<td>
								<button class="ui-button" onclick="confirmOutgoingDelete('{$outgoing->getPersonName()|escape:'javascript'|escape}', '{$outgoing->getOutId()}')" type="button"><span class="ui-icon ui-icon-close"></span></button>
							</td>
					</tr>
				{foreachelse}
					<tr>
						<td colspan="3" style="font-style: italic; text-align: center;">Aucune participation enregistrée.</td>
					</tr>
				{/foreach}
				<tr>
					<td colspan="2" style="text-align: right;">
						<div>
							<select id="participantId" name="participantId">
								{foreach from=$peopleList item="person"}
									<option value="{$person->getPersonId()}">{$person->getPersonName()|escape}</option>
								{/foreach}
							</select>
							<input class="weight" id="weight" maxlength="10" name="weight" type="text" value="1" />
						</div>
						<div class="formValidationMessage" id="weightFormValidationMessage" style="float: right;"></div>
					</td>
					<td>
						<button class="ui-button" id="addOutgoingButton" name="addOutgoingButton" type="submit"><span class="ui-icon ui-icon-plus"></span></button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
<div class="buttons">
	<button class="ui-button" id="addOperationButton" type="button">Saisir une opération</button>
	<button class="ui-button" id="addPersonButton" type="button">Ajouter des participants</button>
</div>

<div id="deleteIncomingConfirmationDialog">
	<div>Etes-vous sûr de vouloir effacer <span class="alternate" id="deleteIncomingPersonName"></span> de la liste?</div>
	<div class="ui-dialog-button-row">
		<button class="ui-button" id="confirmDeleteIncomingButton">Oui</button>
		<button class="ui-button" id="cancelDeleteIncomingButton">Non</button>
	</div>
	<div id="deleteIncomingOperationId" style="display: none;">{$operation->getOperationId()}</div>
	<div id="deleteIncomingId" style="display: none;"></div>
</div>

<div id="deleteOutgoingConfirmationDialog">
	<div>Etes-vous sûr de vouloir effacer <span class="alternate" id="deleteOutgoingPersonName"></span> de la liste?</div>
	<div class="ui-dialog-button-row">
		<button class="ui-button" id="confirmDeleteOutgoingButton">Oui</button>
		<button class="ui-button" id="cancelDeleteOutgoingButton">Non</button>
	</div>
	<div id="deleteOutgoingOperationId" style="display: none;">{$operation->getOperationId()}</div>
	<div id="deleteOutgoingId" style="display: none;"></div>
</div>

<script src="{$CONTEXT_PATH}/js/operation-details.js" type="text/javascript"></script>
{literal}
<script type="text/javascript">
	$(function() {
		$('#addOperationButton').click(function() {
				$.doGet(sprintf('%s/%s/operation/add', CONTEXT_PATH, SHEET_ACCESS_KEY));
				return false;
		});

		$('#addPersonButton').click(function() {
				$.doGet(sprintf('%s/%s/person/add', CONTEXT_PATH, SHEET_ACCESS_KEY));
				return false;
		});

		$('#addIncomingForm').validate({
			errorPlacement : function (label, element) {
				label.appendTo($('#' + element[0].id + 'FormValidationMessage'));
			}
		});

		$('#addOutgoingForm').validate({
			errorPlacement : function (label, element) {
				label.appendTo($('#' + element[0].id + 'FormValidationMessage'));
			}
		});

		loadValidationRules();

		$('#deleteIncomingConfirmationDialog').dialog({
			autoOpen: false,
			bgiframe: true,
			modal : true,
			open:function() {
			  $(this).parent().find(".ui-dialog-titlebar-close").remove();
			},
			resizable : false,
			title : 'Confirmation de la suppression'
		});

		$('#confirmDeleteIncomingButton').click(function() {
			$.doPost(
				sprintf('%s/%s/operation/%s', CONTEXT_PATH, SHEET_ACCESS_KEY, $('#deleteIncomingOperationId').text()),
				{
					action: 'deleteIncoming',
					incomingId: $('#deleteIncomingId').text()
				}
			);
		});

		$('#cancelDeleteIncomingButton').click(function() {
			$('#deleteIncomingConfirmationDialog').dialog('close');
		});

		$('#deleteOutgoingConfirmationDialog').dialog({
			autoOpen: false,
			bgiframe: true,
			modal : true,
			open:function() {
			  $(this).parent().find(".ui-dialog-titlebar-close").remove();
			},
			resizable : false,
			title : 'Confirmation de la suppression'
		});

		$('#confirmDeleteOutgoingButton').click(function() {
			$.doPost(
				sprintf('%s/%s/operation/%s', CONTEXT_PATH, SHEET_ACCESS_KEY, $('#deleteOutgoingOperationId').text()),
				{
					action: 'deleteOutgoing',
					outgoingId: $('#deleteOutgoingId').text()
				}
			);
		});

		$('#cancelDeleteOutgoingButton').click(function() {
			$('#deleteOutgoingConfirmationDialog').dialog('close');
		});
	});

	function confirmIncomingDelete(contributorName, incomingId) {
		$('#deleteIncomingPersonName').text(contributorName);
		$('#deleteIncomingId').text(incomingId);
		$('#deleteIncomingConfirmationDialog').dialog('open');
		return false;
	}

	function confirmOutgoingDelete(participantName, outgoingId) {
		$('#deleteOutgoingPersonName').text(participantName);
		$('#deleteOutgoingId').text(outgoingId);
		$('#deleteOutgoingConfirmationDialog').dialog('open');
		return false;
	}

</script>
{/literal}