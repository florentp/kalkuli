<h1>Bienvenue dans /kal.'ku.li/</h1>

<div class="main">

  <table class="dataGrid">
    {foreach from=$peopleList item="person"}
      <tr>
        <td>
          <a href="person-details.php?personId={$person->getPersonId()}">{$person->getPersonName()}</a>
        </td>
        <td class="amount">
          {$person->getBalance()|formatMoney}
        </td>
      </tr>
    {foreachelse}
      <tr><td>Vous devez commencer par saisir des personnes</td></tr>
    {/foreach}
  </table>
	
  {if $nPeople != 0}
    <div class="navigation"><a href="operation-add.php">Saisir une nouvelle opération</a></div>
  {/if}
  <div class="navigation"><a href="person-add.php">Saisir une nouvelle personne</a></div>
  
</div>