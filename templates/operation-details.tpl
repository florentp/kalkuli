{include file="menu.tpl"}
<div class="ui-main-widget">
	<div class="ui-main-widget-header">Opération <span class="alternate">{$operation->getOperationDescription()|escape}</span></div>
	<div class="ui-main-widget-separator">Contributions</div>
	<div class="ui-main-widget-content">
		<form action="{$PHP_SELF}" id="addIncomingForm" method="post">
			<input name="operationId" type="hidden" value="{$operation->getOperationId()}" />
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
								<a href="person-details.php?personId={$incoming->getPersonId()}">{$incoming->getPersonName()|escape}</a>
							</td>
							<td class="amount">{$incoming->getInAmount()|formatMoney}</td>
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
							<input class="amount" id="amount" maxlength="10" name="amount" type="text" />&nbsp;{$CURRENCY}
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
	<div class="ui-main-widget-content">
		<form action="{$PHP_SELF}" id="addOutgoingForm" method="post">
			<input name="operationId" type="hidden" value="{$operation->getOperationId()}" />
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
								<a href="person-details.php?personId={$outgoing->getPersonId()}">{$outgoing->getPersonName()|escape}</a>
							</td>
							<td class="weight">
								
								<div>{$outgoing->computeWeightedPart()|formatMoney}</div>
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

{literal}
<script src="js/operation-details.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function() {

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
			window.location.href =  unescape(sprintf('operation-details.php?operationId=%s%%26action=deleteIncoming%%26incomingId=%s', $('#deleteIncomingOperationId').text(), $('#deleteIncomingId').text()));
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
			window.location.href =  unescape(sprintf('operation-details.php?operationId=%s%%26action=deleteOutgoing%%26outgoingId=%s', $('#deleteOutgoingOperationId').text(), $('#deleteOutgoingId').text()));
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