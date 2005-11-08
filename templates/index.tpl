<h1>Bienvenue dans Money</h1>

<div class="main">

  <table>
    {foreach from=$peopleList item="person"}
      <tr>
        <td class="summarytd">
          <a href="person-details.php?personId={$person->getPersonId()}">{$person->getPersonName()}</a>
        </td>
        <td class="summarytd">
          {$person->getBalance()|formatMoney}
        </td>
      </tr>
    {foreachelse}
      <tr><td>Vous devez commencer par saisir des personnes</td></tr>
    {/foreach}
  </table>
	
  {if $nPeople != 0}
    <p><a href="operation-add.php">Saisir une nouvelle opération</a></p>
  {/if}
  <p><a href="person-add.php">Saisir une nouvelle personne</a></p>
  
</div>