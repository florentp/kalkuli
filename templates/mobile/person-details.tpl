<table cellspacing="0" cellpadding="0" class="mobile">
	<tbody>
		<tr>
			<th>{$person->getPersonName()}</th>
			<th class="amount">{$person->getBalance()|formatMoney}</th>
		</tr>
		<tr>
			<td colspan="2" class="spacer">&nbsp;</td>
		</tr>
		{if $operationsList->isEmpty()}
			<tr>
				<td colspan="2">Aucune participation</td>
			</tr>
		{else}
			{foreach from=$operationsList item="operation"}
				<tr>
					<td>
						<div><a href="operation-details.php?operationId={$operation->getOperationId()}">{$operation->getOperationDescription()}</a></div>
						<div style="font-size: 0.8em;">{$operation->getOperationTS()|formatDate}</div>
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
		{/if}
		<tr>
			<td colspan="2" class="spacer">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">
				<a href="index.php">Retour à l'accueil</a>
			</td>
		</tr>
	</tbody>
</table>