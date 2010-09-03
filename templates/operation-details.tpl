{$addInForm.javascript}
{$addOutForm.javascript}

<h1>Détail des participations à l'opération {$operation->getOperationDescription()}</h1>

<div class="main">

  <h2>Contributions</h2>
  {if $incomingsList->isEmpty()}
    <p>Aucune contribution enregistrée.</p>
  {else}
    <table>
      <tr>
        <td class="headertd">Nom</td>
        <td class="headertd">Montant</td>
        <td class="headertd">&nbsp;</td>
      </tr>
      {foreach from=$incomingsList item="incoming"}
        <tr>
          <td class="summarytd">
            <a href="person-details.php?personId={$incoming->getPersonId()}">{$incoming->getPersonName()}</a>
          </td>
          <td class="summarytd">{$incoming->getInAmount()|formatMoney}</td>
          <td class="summarytd">
            <a href="{$PHP_SELF}?operationId={$operation->getOperationId()}&action=deleteIn&toDeleteId={$incoming->getInId()}" onclick="return confirm('Etes-vous sûr de vouloir effacer {$incoming->getPersonName()} de la liste.');">Supprimer</a>
          </td>
        </tr>
      {/foreach}
    </table>
  {/if}
  
  
  <form {$addInForm.attributes}>
    {$addInForm.hidden}
    <p>Ajouter un contributeur&nbsp;:</p>
    <p>{$addInForm.personId.label} {$addInForm.personId.html} {$addInForm.amount.label} {$addInForm.amount.html|formatMoney} {$addInForm.submit.html}</p>
  </form>
  
  <h2>Consommations</h2>
  {if $outgoingsList->isEmpty()}
    <p>Aucune consommation enregistrée.</p>
  {else}
    <table>
      <tr>
        <td class="headertd">Nom</td>
        <td class="headertd">Part</td>
        <td class="headertd">Montant</td>
        <td class="headertd">&nbsp;</td>
      </tr>
      {foreach from=$outgoingsList item="outgoing"}
        <tr>
          <td class="summarytd">
            <a href="person-details.php?personId={$outgoing->getPersonId()}">{$outgoing->getPersonName()}</a>
          </td>
          <td class="summarytd">{$outgoing->getOutWeight()}</td>
          <td class="summarytd">{$outgoing->computeWeightedPart()|formatMoney}</td>
          <td class="summarytd">
            <a href="{$PHP_SELF}?operationId={$operation->getOperationId()}&action=deleteOut&toDeleteId={$outgoing->getOutId()}" onclick="return confirm('Etes-vous sûr de vouloir effacer {$outgoing->getPersonName()} de la liste.');">Supprimer</a>
          </td>
        </tr>
      {/foreach}
    </table>
  {/if}
  
  <form {$addOutForm.attributes}>
    {$addOutForm.hidden}
    <p>Ajouter un consomateur&nbsp;:</p>
    <p>{$addOutForm.personId.label} {$addOutForm.personId.html} {$addOutForm.weight.label} {$addOutForm.weight.html} {$addOutForm.submit.html}</p>
  </form>
  
  <p><a href="index.php">Retour à la page d'accueil</a></p>
  
</div>