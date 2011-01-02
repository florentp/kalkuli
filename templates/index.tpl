{include file="menu.tpl"}
<div class="ui-main-widget">
	<div class="ui-main-widget-header">Participants à cette feuille de comptes</div>

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
          <a href="{$CONTEXT_PATH}/person/{$person->getPersonId()}">{$person->getPersonName()|escape}</a>
        </td>
        <td class="amount">
          {$person->getBalance()|formatMoney}
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
      <tr><td>Vous devez commencer par saisir des personnes</td></tr>
    {/foreach}
  </table>

</div>

{literal}
<script type="text/javascript">
	$('.bargraph').addClass('ui-helper-clearfix ui-corner-all');
	$('.bargraph > .negativeBar').addClass('ui-corner-left');
	$('.bargraph > .positiveBar').addClass('ui-corner-right');
</script>
{/literal}