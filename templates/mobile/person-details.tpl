<div class="ui-mobile-widget">
	<div class="ui-mobile-widget-header">Participations de <span class="alternate">{$person->getPersonName()|escape}</div>
	{if $operationsList->isEmpty()}
		<div class="ui-mobile-widget-item">
			<div style="font-style: italic; padding-bottom: 1em; padding-top: 1em; text-align: center;">Aucune participation enregistrée pour le moment. Vous devez ajouter ce participant à une opération.</div>
		</div>
	{else}
		{foreach from=$operationsList item="operation" name="operation"}
			<div class="ui-mobile-widget-item">
				<div class="ui-helper-clearfix">
					<div class="ui-mobile-widget-item-field">
						{assign var="personTotalInAmount" value=$operation->getPersontotalinamount()}
						{if isset($personTotalInAmount)}
							<div>{$personTotalInAmount|formatMoney}</div>
						{/if}
						
						{assign var="personTotalOutAmount" value=$operation->getPersontotaloutamount()}
						{if isset($personTotalOutAmount)}
							<div>{$personTotalOutAmount|formatMoney}</div>
						{/if}
					</div>
					<div class="ui-mobile-widget-item-label">
						<div><a href="{$CONTEXT_PATH}/operation/{$operation->getOperationId()}">{$operation->getOperationDescription()|escape}</a></div>
						<div style="font-size: 80%; font-weight:normal;">{$operation->getOperationTS()|formatDate}</div>
					</div>
				</div>
			</div>
		{/foreach}
	{/if}
</div>
{include file="mobile/menu-people-list.tpl"}
{include file="mobile/menu-people-add.tpl"}
{include file="mobile/menu-operation-add.tpl"}