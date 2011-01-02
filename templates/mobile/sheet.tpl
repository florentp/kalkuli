<div class="ui-mobile-widget">
	<div class="ui-mobile-widget-header">Participants</div>
	{foreach from=$peopleList item="person"}
		<div class="ui-mobile-widget-item">
			<div class="ui-helper-clearfix">
				<div class="ui-mobile-widget-item-field">
					{$person->getBalance()|formatAmount:$sheet->getCurrencyCode()}
				</div>
				<div class="ui-mobile-widget-item-label">
					<a href="person-details.php?personId={$person->getPersonId()}">{$person->getPersonName()}</a>
				</div>
			</div>
		</div>
	{foreachelse}
		<div class="ui-mobile-widget-item">
			<div class="ui-helper-clearfix">
				<div class="ui-mobile-widget-item-label">
					Vous devez commencer par saisir des personnes
				</div>
			</div>
		</div>
	{/foreach}
</div>

{include file="mobile/menu-people-add.tpl"}
{include file="mobile/menu-operation-add.tpl"}