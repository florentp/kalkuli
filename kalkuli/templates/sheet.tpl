<h1>{$sheet->getName()|escape}</h1>
<div class="ui-main-widget">

	<table cellpadding="0" cellspacing="0" class="dataGrid">
		<colgroup>
			<col />
			<col />
			<col style="width: 60px;" />
		</colgroup>
		{foreach from=$peopleList item="person" name="peopleList"}
			{if $smarty.foreach.peopleList.index is even}
				<tr>
			{else}
				<tr class="alternate">
			{/if}
			<td>
				<a href="{$CONTEXT_PATH}/{$sheet->getAccessKey()}/person/{$person->getPersonId()}">{$person->getPersonName()|escape}</a>
			</td>
			<td class="amount">
				{$person->getBalance()|formatAmount:$sheet->getCurrencyCode()}
			</td>
			<td>
				<div class="bargraph">
					{if $person->getBalance() < 0 }
						<div class="negativeBar" style="margin-left: {round value=$person->getBalance()/$maxAbsoluteBalance*25+25}px; width:{round value=$person->getBalance()/$maxAbsoluteBalance*-25}px;">&nbsp;</div>
					{elseif $person->getBalance() > 0 }
						<div class="positiveBar" style="margin-right: {round value=$person->getBalance()/$maxAbsoluteBalance*-25+25}px; width:{round value=$person->getBalance()/$maxAbsoluteBalance*25}px;">&nbsp;</div>
					{else}
						<div class="emptyBar">&nbsp;</div>
					{/if}
				</div>
			</td>
			</tr>
		{foreachelse}
			<tr><td>Vous devez commencer par ajouter des participants</td></tr>
		{/foreach}
	</table>

</div>
<div class="buttons">
	{if $nPeople > 0}
		<button class="ui-button" id="addOperationButton" type="button">Saisir une opération</button>
	{/if}
	<button class="ui-button" id="addPersonButton" type="button">Ajouter des participants</button>
</div>

{literal}
<script type="text/javascript">
	$(function() {
		$('.bargraph').addClass('ui-helper-clearfix ui-corner-all');
		$('.bargraph > .negativeBar').addClass('ui-corner-left');
		$('.bargraph > .positiveBar').addClass('ui-corner-right');

		$('#addOperationButton').click(function() {
				$.doGet(sprintf('%s/%s/operation/add', CONTEXT_PATH, SHEET_ACCESS_KEY));
				return false;
		});

		$('#addPersonButton').click(function() {
				$.doGet(sprintf('%s/%s/person/add', CONTEXT_PATH, SHEET_ACCESS_KEY));
				return false;
		});
	});
</script>
{/literal}