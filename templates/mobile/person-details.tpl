<div data-role="page" data-theme="b" id="personDetails">
	<div data-role="header">
		<a href="{$CONTEXT_PATH}/{$sheet->getAccessKey()}" data-icon="back" rel="external">Back</a>
		<h1>/kal.'ku.li/</h1>
	</div>
	<div data-role="content">
		<h2><a href="{$CONTEXT_PATH}/{$sheet->getAccessKey()}" rel="external">{$sheet->getName()|escape}</a> > <span class="alternate">{$person->getPersonName()|escape}</span></h2>
		<ul data-role="listview" data-inset="true">
			{foreach from=$operationsList item="operation" name="operation"}
				<li>
					<a href="{$CONTEXT_PATH}/{$sheet->getAccessKey()}/operation/{$operation->getOperationId()}" rel="external">{$operation->getOperationDescription()|escape}</a>
					<div>{$operation->getOperationTS()|formatDate}</div>
					<span class="ui-li-aside">
						{assign var="personTotalInAmount" value=$operation->getPersontotalinamount()}
						{if isset($personTotalInAmount)}
							<div>{$personTotalInAmount|formatAmount:$sheet->getCurrencyCode()}</div>
						{/if}
						
						{assign var="personTotalOutAmount" value=$operation->getPersontotaloutamount()}
						{if isset($personTotalOutAmount)}
							<div>{$personTotalOutAmount|formatAmount:$sheet->getCurrencyCode()}</div>
						{/if}
					</span>
				</li>
			{foreachelse}
				<li>Aucune participation enregistrée pour le moment. Vous devez ajouter ce participant à une opération.</li>
			{/foreach}
		</ul>
	</div>
</div>