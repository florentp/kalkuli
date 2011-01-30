<div data-role="page" data-theme="b" id="peopleAdd">
	<div data-role="header">
		<h1>/kal.'ku.li/</h1>
	</div>
	<div data-role="content">
		<h2><a href="{$CONTEXT_PATH}/{$sheet->getAccessKey()}" rel="external">{$sheet->getName()|escape}</a> > Nouveaux participants</h2>
		<form action="{$CONTEXT_PATH}/{$sheet->getAccessKey()}/person/add" id="addPeopleForm" name="addPeopleForm" method="post">
			<input type="hidden" id="addPeopleButton" name="addPeopleButton" value="addPeopleButton" />
			
			<div data-role="fieldcontain">
				<a href="#" data-role="button" data-theme="c" id="moreParticipantsButton">Plus de participants</a>
				<button type="submit" data-theme="b">Enregistrer</button>
			</div>
		</form>
		<div id="participantTemplate" style="display: none;">
			<div data-role="fieldcontain">
				<label></label>
				<input maxlength="255" type="text" />
				<div class="formValidationMessage"></div>
			</div>
		</div>
	</div>
</div>

<script src="{$CONTEXT_PATH}/js/people-add.js" type="text/javascript"></script>
{literal}
<script type="text/javascript">
	var nParticipant = 0;
	$(function() {

		$('#addPeopleForm').validate({
			errorPlacement : function (label, element) {
				label.appendTo($('#' + element[0].id + 'FormValidationMessage'));
			}
		});

		$('#moreParticipantsButton').click(function () {
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
		var newItem = $('#participantTemplate > div').clone();
		newItem.attr('id', null);
		newItem.find('label').attr('for', sprintf('namesList%s', nParticipant)).html(sprintf('Participant %s&nbsp;:', nParticipant));
		newItem.find('input').attr('id', sprintf('namesList%s', nParticipant)).attr('name', sprintf('namesList[%s]', nParticipant));
		newItem.find('div.formValidationMessage').attr('id', sprintf('namesList%sFormValidationMessage', nParticipant));
		newItem.insertBefore('#addPeopleButton');
	}
</script>
{/literal}
