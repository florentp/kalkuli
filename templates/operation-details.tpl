{$addInForm.javascript}
{$addOutForm.javascript}

<h1>Détail des participations à l'opération {$operation->getOperationDescription()}</h1>

<div class="main">

  <h2>Contributions</h2>
  {if $incomingsList->isEmpty()}
    <p>Aucune contribution enregistrée.</p>
  {else}
    <table class="dataGrid">
      <tr>
        <th>Nom</th>
        <th>Montant</th>
        <th>&nbsp;</th>
      </tr>
      {foreach from=$incomingsList item="incoming"}
        <tr>
          <td>
            <a href="person-details.php?personId={$incoming->getPersonId()}">{$incoming->getPersonName()}</a>
          </td>
          <td class="amount">{$incoming->getInAmount()|formatMoney}</td>
          <td>
            <a href="{$PHP_SELF}?operationId={$operation->getOperationId()}&action=deleteIn&toDeleteId={$incoming->getInId()}" onclick="return confirm('Etes-vous sûr de vouloir effacer {$incoming->getPersonName()} de la liste.');">Supprimer</a>
          </td>
        </tr>
      {/foreach}
      <form {$addInForm.attributes}>
	    <tr>
		  <td>{$addInForm.personId.html}</td>
		  <td>{$addInForm.amount.html|formatMoney}</td>
		  <td>{$addInForm.submit.html}</td>
		</tr>
	  </form>
    </table>
  {/if}
  
  <h2>Consommations</h2>
  {if $outgoingsList->isEmpty()}
    <p>Aucune consommation enregistrée.</p>
  {else}
    <table class="dataGrid">
      <tr>
        <th>Nom</th>
        <th>Montant</th>
        <th>&nbsp;</th>
      </tr>
      {foreach from=$outgoingsList item="outgoing"}
        <tr>
          <td>
            <a href="person-details.php?personId={$outgoing->getPersonId()}">{$outgoing->getPersonName()}</a>
          </td>
          <td class="amount">
		    <div>{$outgoing->computeWeightedPart()|formatMoney}</div>
			<div style="font-size: 0.8em;">{$outgoing->getOutWeight()} part(s) sur {$outgoing->getOperationTotalOutWeight()}</div>
		  </td>
          <td>
            <a href="{$PHP_SELF}?operationId={$operation->getOperationId()}&action=deleteOut&toDeleteId={$outgoing->getOutId()}" onclick="return confirm('Etes-vous sûr de vouloir effacer {$outgoing->getPersonName()} de la liste.');">Supprimer</a>
          </td>
        </tr>
      {/foreach}
	  <form {$addOutForm.attributes}>
	    {$addOutForm.hidden}
	    <tr>
	      <td>{$addOutForm.personId.html}</td>
	      <td>{$addOutForm.weight.html} part(s)</td>
	      <td>{$addOutForm.submit.html}</td>
	    </tr>
	  </form>
    </table>
  {/if}
  
  <div class="navigation"><a href="index.php">Retour à la page d'accueil</a></div>
  
</div>