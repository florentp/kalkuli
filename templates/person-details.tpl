<h1>Détail des participations de {$person->getPersonName()} ({$person->getBalance()|formatMoney})</h1>

<div class="main">

  <h2>Contributions de {$person->getPersonName()}</h2>
  {if $incomingsList->isEmpty()}
    <p>Aucune contribution enregistrée.</p>
  {else}
    <table>
      <tr>
        <td class="headertd">Date</td>
        <td class="headertd">Description</td>
        <td class="headertd">Contribution</td>
      </tr>
      {foreach from=$incomingsList item="incoming"}
        <tr>
          <td class="summarytd">{$incoming->getOperationTS()}</td>
          <td class="summarytd">
            <a href="operation-details.php?operationId={$incoming->getOperationIdFk()}">{$incoming->getOperationDescription()} ({$incoming->getOperationAmountTotal()|formatMoney})</a>
          </td>
          <td class="summarytd">{$incoming->getInAmount()|formatMoney}</td>
        </tr>
      {/foreach}
    </table>
  {/if}
  
  <h2>Consommations de {$person->getPersonName()}</h2>
  {if $outgoingsList->isEmpty()}
    <p>Aucune consommation enregistrée.</p>
  {else}
    <table>
      <tr>
        <td class="headertd">Date</td>
        <td class="headertd">Description</td>
        <td class="headertd">Part</td>
        <td class="headertd">Consommation</td>
      </tr>
      {foreach from=$outgoingsList item="outgoing"}
        <tr>
          <td class="summarytd">{$outgoing->getOperationTS()}</td>
          <td class="summarytd">
            <a href="operation-details.php?operationId={$outgoing->getOperationIdFk()}">{$outgoing->getOperationDescription()} ({$outgoing->getOperationAmountTotal()|formatMoney})</a>
          </td>
          <td class="summarytd">{$outgoing->getOutWeight()} / {$outgoing->getOperationWeightTotal()}</td>
          <td class="summarytd">{$outgoing->computeWeightedPart()|formatMoney}</td>
        </tr>
      {/foreach}
    </table>
  {/if}
  
  <p><a href="index.php">Retour à la page d'accueil</a></p>
  
</div>