<table cellspacing="0" cellpadding="0" class="summary">
	<tbody>
		<tr>
			<th>{$person->getPersonName()}</th>
			<th style="text-align:right;">{$person->getBalance()|formatMoney}</th>
		</tr>
		<tr>
			<td colspan="3" class="spacer">&nbsp;</td>
		</tr>
		<tr>
			<th colspan="2">Contributions</th>
		</tr>
		{if $nIncomings <= 0}
			<tr>
				<td colspan="2">Aucune contribution</td>
			</tr>
		{else}
			{foreach from=$incomingsList item="incoming"}
				<tr>
					<td>
						<div><a href="operation-details.php?operationId={$incoming->getOperationIdFk()}">{$incoming->getOperationDescription()}</a></div>
						<div style="font-size: 0.8em;">{$incoming->getOperationTS()|formatDate}</div>
					</td>
					<td style="text-align:right;">{$incoming->getInAmount()|formatMoney}</td>
				</tr>
			{/foreach}
		{/if}
		<tr>
			<td colspan="3" class="spacer">&nbsp;</td>
		</tr>
		<tr>
			<th colspan="2">Participations</th>
		</tr>
		{if $nOutgoings <= 0}
			<tr>
				<td colspan="2">Aucune participation</td>
			</tr>
		{else}
			{foreach from=$outgoingsList item="outgoing"}
				<tr>
					<td>
						<div><a href="operation-details.php?operationId={$outgoing->getOperationIdFk()}">{$outgoing->getOperationDescription()}</a></div>
						<div style="font-size: 0.8em;">{$outgoing->getOperationTS()|formatDate}</div>
					</td>
					<td style="text-align:right;">{$outgoing->computeWeightedPart()|formatMoney}</td>
				</tr>
			{/foreach}
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