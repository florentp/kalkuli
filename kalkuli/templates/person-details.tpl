{*
 * Copyright 2006-2011 Florent Paillard
 * 
 * This file is part of /kal.ku.'li/.
 * 
 * /kal.ku.'li/ is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * /kal.ku.'li/ is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with /kal.ku.'li/.  If not, see <http://www.gnu.org/licenses/>.
 * 
 *}
<h1><a href="{$CONTEXT_PATH}/{$sheet->getAccessKey()}">{$sheet->getName()|escape}</a> > <span class="alternate">{$person->getPersonName()|escape}</span></h1>
<div class="ui-main-widget">
	{if $operationsList->isEmpty()}
		<div style="font-style: italic; padding-bottom: 1em; padding-top: 1em; text-align: center;">Aucune participation enregistrée pour le moment. Vous devez ajouter ce participant à une opération.</div>
	{else}
		<table class="dataGrid" cellspacing="0" cellpadding="0">
			{foreach from=$operationsList item="operation" name="operation"}
				{if $smarty.foreach.operation.index is even}
					<tr>
				{else}
					<tr class="alternate">
				{/if}
						<td>
							<div><a href="{$CONTEXT_PATH}/{$sheet->getAccessKey()}/operation/{$operation->getOperationId()}">{$operation->getOperationDescription()|escape}</a></div>
							<div>{$operation->getOperationTS()|formatDate}</div>
						</td>
						<td class="amount">
							{assign var="personTotalInAmount" value=$operation->getPersontotalinamount()}
							{if isset($personTotalInAmount)}
								<div>{$personTotalInAmount|formatAmount:$sheet->getCurrencyCode()}</div>
							{/if}
							
							{assign var="personTotalOutAmount" value=$operation->getPersontotaloutamount()}
							{if isset($personTotalOutAmount)}
								<div>{$personTotalOutAmount|formatAmount:$sheet->getCurrencyCode()}</div>
							{/if}
						</td>
				</tr>
			{/foreach}
		</table>
	{/if}
	
</div>
<div class="buttons">
	<button class="ui-button" id="addOperationButton" type="button">Saisir une opération</button>
	<button class="ui-button" id="addPersonButton" type="button">Ajouter des participants</button>
</div>

{literal}
<script type="text/javascript">
	$(function() {
		$('#addOperationButton').click(function() {
				$.doGet(sprintf('%s/%s/operation/add', CONTEXT_PATH, SHEET_ACCESS_KEY));
				return false;
		});

		$('#addPersonButton').click(function() {
				$.doGet(sprintf('%s/%s/person/add', CONTEXT_PATH, SHEET_ACCESS_KEY));
				return false;
		});
	});
</script>
{/literal}
