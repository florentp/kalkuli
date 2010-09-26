{include file="menu.tpl"}
<div class="ui-main-widget">
	<div class="ui-main-widget-header">Participations de <span class="alternate">{$person->getPersonName()|escape}</span></div>

	{if $operationsList->isEmpty()}
		<div style="font-style: italic; padding-bottom: 1em; padding-top: 1em; text-align: center;">Aucune participation enregistrée pour le moment. Vous devez ajouter ce participant à une opération.</div>
	{else}
		<table class="dataGrid" cellspacing="0" cellpadding="0">
			{foreach from=$operationsList item="operation" name="operation"}
				{if $smarty.foreach.operation.index is even}
					<tr>
				{else}
					<tr class="alternate">
				{/if}
						<td>
							<div><a href="operation-details.php?operationId={$operation->getOperationId()}">{$operation->getOperationDescription()|escape}</a></div>
							<div>{$operation->getOperationTS()|formatDate}</div>
						</td>
						<td class="amount">
							{assign var="personTotalInAmount" value=$operation->getPersontotalinamount()}
							{if isset($personTotalInAmount)}
								<div>{$personTotalInAmount|formatMoney}</div>
							{/if}
							
							{assign var="personTotalOutAmount" value=$operation->getPersontotaloutamount()}
							{if isset($personTotalOutAmount)}
								<div>{$personTotalOutAmount|formatMoney}</div>
							{/if}
						</td>
				</tr>
			{/foreach}
		</table>
	{/if}
	
</div>