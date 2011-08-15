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
