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
<h1><a href="{$CONTEXT_PATH}/{$sheet->getAccessKey()}">{$sheet->getName()|escape}</a> > Nouveaux participants</h1>
<div class="ui-main-widget">

	<form action="{$CONTEXT_PATH}/{$sheet->getAccessKey()}/person/add" id="addPeopleForm" name="addPeopleForm" method="post">
		<table id="addPeopleTable" class="tableForm">
			<tr id="moreParticipantsRow">
				<td colspan="2">
					<a href="#">Plus de participants</a>
				</td>
			</tr>
			<tr class="buttonRow">
				<td colspan="2">
					<button class="ui-button" name="addPeopleButton" type="submit">Enregistrer</button>
					<button class="ui-button" id="cancelButton" type="button">Annuler</button>
				</td>
			</tr>
		</table>
	</form>
</div>

<script src="{$CONTEXT_PATH}/js/people-add.js" type="text/javascript"></script>
{literal}
<script type="text/javascript">
	var nParticipant = 0;
	$(function() {

		$('#cancelButton').click(function() {
			$.doGet(sprintf('%s/%s', CONTEXT_PATH, SHEET_ACCESS_KEY));
		});

		$('#addPeopleForm').validate({
			errorPlacement : function (label, element) {
				label.appendTo($('#' + element[0].id + 'FormValidationMessage'));
			}
		});

		$('#moreParticipantsRow').click(function () {
			for (var i = 1; i <= 3; i++) {
				addParticipantRow();
			}
			return false;
		});

		for (var i = 1; i <= 3; i++) {
			addParticipantRow();
		}
		
		loadValidationRules();
	});

	function addParticipantRow() {
		nParticipant++;
		var item = $('<tr><th><label></label></th><td><input class="name" maxlength="255" type="text" /><div class="formValidationMessage"></div></td></tr>');
		item.find('label').attr('for', sprintf('namesList%s', nParticipant)).html(sprintf('Participant %s&nbsp;:', nParticipant));
		item.find('input').attr('id', sprintf('namesList%s', nParticipant)).attr('name', sprintf('namesList[%s]', nParticipant));
		item.find('div').attr('id', sprintf('namesList%sFormValidationMessage', nParticipant));
		item.insertBefore('#moreParticipantsRow');
	}
</script>
{/literal}
