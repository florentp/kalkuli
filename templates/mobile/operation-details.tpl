{$addInForm.javascript}
{$addOutForm.javascript}

<table cellspacing="0" cellpadding="0" class="summary">
	<tbody>
		<tr>
			<th colspan="3">{$operation->getOperationDescription()}</th>
		</tr>
		<tr>
			<td colspan="3" class="spacer">&nbsp;</td>
		</tr>
		<tr>
			<th colspan="3">Contributions</th>
		</tr>
		{if $incomingsList->isEmpty()}
			<tr>
				<td colspan="3">Aucune contribution</td>
			</tr>
		{else}
			{foreach from=$incomingsList item="incoming"}
				<tr>
					<td>
					<a href="person-details.php?personId={$incoming->getPersonId()}">{$incoming->getPersonName()}</a>
					</td>
					<td>
						{$incoming->getInAmount()|formatMoney}
					</td>
					<td>
						<a href="{$PHP_SELF}?operationId={$operation->getOperationId()}&action=deleteIn&toDeleteId={$incoming->getInId()}" onclick="return confirm('Etes-vous sûr de vouloir effacer {$incoming->getPersonName()} de la liste.');"><img src="icons/cross.png" alt="Supprimer" height="16" width="16" /></a>
					</td>
				</tr>
			{/foreach}
			<form {$addInForm.attributes}>
				{$addInForm.hidden}
				<tr>
					<td>{$addInForm.personId.html}</td>
					<td>{$addInForm.amount.html|formatMoney}</td>
					<td>{$addInForm.submit.html}</td>
				</tr>
			</form>
		{/if}
		<tr>
			<td colspan="3" class="spacer">&nbsp;</td>
		</tr>
		<tr>
			<th colspan="3">Participations</th>
		</tr>
		{if $outgoingsList->isEmpty()}
			<tr>
				<td colspan="3">Aucune participation</td>
			</tr>
		{else}
			{foreach from=$outgoingsList item="outgoing"}
				<tr>
					<td>
					<a href="person-details.php?personId={$outgoing->getPersonId()}">{$outgoing->getPersonName()}</a>
					</td>
					<td>
						<div>{$outgoing->computeWeightedPart()|formatMoney}</div>
						<div style="font-size: 0.8em;">{$outgoing->getOutWeight()} part(s) sur {$outgoing->getOperationWeightTotal()}</div>
					</td>
					<td>
						<a href="{$PHP_SELF}?operationId={$operation->getOperationId()}&action=deleteOut&toDeleteId={$outgoing->getOutId()}" onclick="return confirm('Etes-vous sûr de vouloir effacer {$outgoing->getPersonName()} de la liste.');"><img src="icons/cross.png" alt="Supprimer" height="16" width="16" /></a>
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
		{/if}
		<tr>
			<td colspan="3" class="spacer">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3">
				<a href="index.php">Retour à l'accueil</a>
			</td>
		</tr>
	</tbody>
</table>
