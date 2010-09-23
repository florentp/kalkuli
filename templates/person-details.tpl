<h1>Détail des participations de {$person->getPersonName()} ({$person->getBalance()|formatMoney})</h1>

<div class="main">
  {if $operationsList->isEmpty()}
    <p>Aucune participation enregistrée.</p>
  {else}
    <table class="dataGrid">
      <tr>
        <th>Description</th>
        <th>&nbsp;</th>
      </tr>
      {foreach from=$operationsList item="operation" name="operation"}
        {if $smarty.foreach.operation.index is even}
	  <tr>
	{else}
	  <tr class="alternate">
	{/if}
          <td>
            <div><a href="operation-details.php?operationId={$operation->getOperationId()}">{$operation->getOperationDescription()}</a></div>
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
  
  <div class="navigation"><a href="index.php">Retour à la page d'accueil</a></div>
  
</div>