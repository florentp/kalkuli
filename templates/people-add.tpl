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
</script>
{/literal}