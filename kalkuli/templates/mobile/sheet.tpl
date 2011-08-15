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
<div data-role="page" data-theme="b" id="sheet">
	<div data-role="header">
		<h1>/kal.'ku.li/</h1>
	</div>
	<div data-role="content">
		<h2>{$sheet->getName()|escape}</h2>
		<ul data-role="listview" data-inset="true">
			{foreach from=$peopleList item="person" name="peopleList"}
				<li>
					<a href="{$CONTEXT_PATH}/{$sheet->getAccessKey()}/person/{$person->getPersonId()}" rel="external">{$person->getPersonName()|escape}</a>
					<span class="ui-li-aside">{$person->getBalance()|formatAmount:$sheet->getCurrencyCode()}</span>
				</li>
			{foreachelse}
				<li>Vous devez commencer par ajouter des participants</li>
			{/foreach}
		</ul>
		{if $nPeople > 0}
			<a href="{$CONTEXT_PATH}/{$sheet->getAccessKey()}/operation/add" data-role="button" rel="external">Saisir une opération</a>
		{/if}
		<a href="{$CONTEXT_PATH}/{$sheet->getAccessKey()}/person/add" data-role="button" rel="external">Ajouter des participants</a>
	</div>
</div>
