{include file="menu.tpl"}
<div class="ui-main-widget">
	<div class="ui-main-widget-header">Participants à cette feuille de comptes</div>

	<table cellpadding="0" cellspacing="0" class="dataGrid">
    {foreach from=$peopleList item="person" name="peopleList"}
	  {if $smarty.foreach.peopleList.index is even}
			<tr>
		{else}
			<tr class="alternate">
		{/if}
        <td>
          <a href="person-details.php?personId={$person->getPersonId()}">{$person->getPersonName()|escape}</a>
        </td>
        <td class="amount">
          {$person->getBalance()|formatMoney}
        </td>
      </tr>
    {foreachelse}
      <tr><td>Vous devez commencer par saisir des personnes</td></tr>
    {/foreach}
  </table>

</div>