{*
 * Copyright 2006-2011 Florent Paillard
 * 
 * This file is part of /kal.'ku.li/.
 * 
 * /kal.'ku.li/ is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * /kal.'ku.li/ is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with /kal.'ku.li/.  If not, see <http://www.gnu.org/licenses/>.
 * 
 *}
<div data-role="page" data-theme="b" id="operationDetails">
	<div data-role="header">
		<a href="{$CONTEXT_PATH}/{$sheet->getAccessKey()}" data-icon="back" rel="external">Back</a>
		<h1>/kal.'ku.li/</h1>
	</div>
	<div data-role="content">
		<h2><a href="{$CONTEXT_PATH}/{$sheet->getAccessKey()}" rel="external">{$sheet->getName()|escape}</a> > <span class="alternate">{$operation->getOperationDescription()|escape}</span></h2>
		<ul data-role="listview" data-inset="true">
			<li data-role="list-divider">Contributions</li>
			{foreach from=$incomingsList item="incoming" name="incomingsList"}
				<li>
					<a href="{$CONTEXT_PATH}/{$sheet->getAccessKey()}/person/{$incoming->getPersonId()}" rel="external">{$incoming->getPersonName()|escape}</a>
					<a href="#" onclick="confirmIncomingDelete('{$incoming->getPersonName()|escape:'javascript'|escape}', '{$incoming->getInId()}'); return false;" data-role="button" data-icon="delete" data-iconpos="notext">Supprimer ce contributeur</a>
					<span class="ui-li-aside">
						{$incoming->getInAmount()|formatAmount:$sheet->getCurrencyCode()}
					</span>
				</li>
			{foreachelse}
				<li>Aucune contribution enregistrée.</li>
			{/foreach}
			<li>
				<a href="#addIncoming">Ajouter un contributeur</a>
			</li>
		</ul>
		
		<ul data-role="listview" data-inset="true">
			<li data-role="list-divider">Participations</li>
			{foreach from=$outgoingsList item="outgoing" name="outgoingsList"}
				<li>
					<a href="{$CONTEXT_PATH}/{$sheet->getAccessKey()}/person/{$outgoing->getPersonId()}" rel="external">{$outgoing->getPersonName()|escape}</a>
					<a href="#" onclick="confirmOutgoingDelete('{$outgoing->getPersonName()|escape:'javascript'|escape}', '{$outgoing->getOutId()}'); return false;" data-role="button" data-icon="delete" data-iconpos="notext">Supprimer ce participant</a>
					<div class="ui-li-aside">
						<div>{$outgoing->computeWeightedPart()|formatAmount:$sheet->getCurrencyCode()}</div>
						<div style="font-size: 0.8em;">{$outgoing->getOutWeight()} part(s) sur {$outgoing->getOperationTotalOutWeight()}</div>
					</div>
				</li>
			{foreachelse}
				<li>Aucune participation enregistrée.</li>
			{/foreach}
			<li>
				<a href="#addOutgoing">Ajouter un participant</a>
			</li>
		</ul>
	</div>
</div>

<div data-role="page" data-theme="c" id="addIncoming">
	<div data-role="header">
		<a href="#" data-icon="back" data-rel="back">Back</a>
		<h1>Ajouter un contributeur</h1>
	</div>
	<div data-role="content">
		<form action="{$CONTEXT_PATH}/{$sheet->getAccessKey()}/operation/{$operation->getOperationId()}" id="addIncomingForm" method="post">
			<input name="action" type="hidden" value="addIncoming" />
			<div data-role="fieldcontain">
				<label for="contributorId">Contributeur&nbsp;:</label>
				<select id="contributorId" name="contributorId">
					{foreach from=$peopleList item="person"}
						<option value="{$person->getPersonId()}">{$person->getPersonName()|escape}</option>
					{/foreach}
				</select>
			</div>
			<div data-role="fieldcontain">
				<label for="amount">Montant ({$sheet->getCurrencyCode()|formatSymbol})&nbsp;:</label>
				<input class="amount" id="amount" maxlength="10" name="amount" type="text" />
				<div class="formValidationMessage" id="amountFormValidationMessage"></div>
			</div>
			<div data-role="fieldcontain">
				<button data-theme="b">Ajouter</button>
			</div>
		</form>
	</div>
</div>

<div data-role="page" data-theme="c" id="addOutgoing">
	<div data-role="header">
		<a href="#" data-icon="back" data-rel="back">Back</a>
		<h1>Ajouter un participant</h1>
	</div>
	<div data-role="content">
		<form action="{$CONTEXT_PATH}/{$sheet->getAccessKey()}/operation/{$operation->getOperationId()}" id="addOutgoingForm" method="post">
			<input name="action" type="hidden" value="addOutgoing" />
			<div data-role="fieldcontain">
				<label for="participantId">Participant&nbsp;:</label>
				<select id="participantId" name="participantId">
					{foreach from=$peopleList item="person"}
						<option value="{$person->getPersonId()}">{$person->getPersonName()|escape}</option>
					{/foreach}
				</select>
			</div>
			<div data-role="fieldcontain">
				<label for="weight">Part&nbsp;:</label>
				<input class="weight" id="weight" maxlength="10" name="weight" type="text" value="1" />
				<div class="formValidationMessage" id="weightFormValidationMessage"></div>
			</div>
			<div data-role="fieldcontain">
				<button data-theme="b">Ajouter</button>
			</div>
		</form>
	</div>
</div>

<div data-role="dialog" data-theme="b" id="confirmIncomingDelete">
	<div data-role="header">
		<h1>Confirmation de la suppression</h1>
	</div>
	<div data-role="content">
		<div>Etes-vous sûr de vouloir effacer <span class="alternate" id="deleteIncomingPersonName"></span> de la liste&nbsp;?</div>
		<div class="buttonsPanel">
			<a href="#" id="confirmDeleteIncomingButton" data-theme="b" data-role="button" data-inline="true">Oui</a>
			<a href="#" data-role="button" data-rel="back" data-inline="true">Non</a>
		</div>
		<div id="deleteIncomingOperationId" style="display: none;">{$operation->getOperationId()}</div>
		<div id="deleteIncomingId" style="display: none;"></div>
	</div>
</div>

<div data-role="dialog" data-theme="b" id="confirmOutgoingDelete">
	<div data-role="header">
		<h1>Confirmation de la suppression</h1>
	</div>
	<div data-role="content">
		<div>Etes-vous sûr de vouloir effacer <span class="alternate" id="deleteOutgoingPersonName"></span> de la liste&nbsp;?</div>
		<div class="buttonsPanel">
			<a href="#" id="confirmDeleteOutgoingButton" data-theme="b" data-role="button" data-inline="true">Oui</a>
			<a href="#" data-role="button" data-rel="back" data-inline="true">Non</a>
		</div>
		<div id="deleteOutgoingOperationId" style="display: none;">{$operation->getOperationId()}</div>
		<div id="deleteOutgoingId" style="display: none;"></div>
	</div>
</div>

<script src="{$CONTEXT_PATH}/js/operation-details.js" type="text/javascript"></script>
{literal}
<script type="text/javascript">
	$(function() {

		$('#addIncomingForm').validate({
			errorPlacement : function (label, element) {
				label.appendTo($('#' + element[0].id + 'FormValidationMessage'));
			}
		});

		$('#addOutgoingForm').validate({
			errorPlacement : function (label, element) {
				label.appendTo($('#' + element[0].id + 'FormValidationMessage'));
			}
		});

		loadValidationRules();

		$('#confirmDeleteIncomingButton').click(function() {
			$.doPost(
				sprintf('%s/%s/operation/%s', CONTEXT_PATH, SHEET_ACCESS_KEY, $('#deleteIncomingOperationId').text()),
				{
					action: 'deleteIncoming',
					incomingId: $('#deleteIncomingId').text()
				}
			);
			return false;
		});

		$('#confirmDeleteOutgoingButton').click(function() {
			$.doPost(
				sprintf('%s/%s/operation/%s', CONTEXT_PATH, SHEET_ACCESS_KEY, $('#deleteOutgoingOperationId').text()),
				{
					action: 'deleteOutgoing',
					outgoingId: $('#deleteOutgoingId').text()
				}
			);
			return false;
		});

		$('#cancelDeleteIncomingButton').click(function() {
			$.mobile.changePage('#');
			return false;
		});

		$('#cancelDeleteOutgoingButton').click(function() {
			$.mobile.changePage('#');
			return false;
		});
	});

	function confirmIncomingDelete(contributorName, incomingId) {
		$('#deleteIncomingPersonName').text(contributorName);
		$('#deleteIncomingId').text(incomingId);
		$.mobile.changePage('#confirmIncomingDelete');
		return false;
	}

	function confirmOutgoingDelete(participantName, outgoingId) {
		$('#deleteOutgoingPersonName').text(participantName);
		$('#deleteOutgoingId').text(outgoingId);
		$.mobile.changePage('#confirmOutgoingDelete');
		return false;
	}
</script>
{/literal}
