function loadValidationRules() {
	$('#namesList1').rules(
		'add',
		{
			required : true
		}
	);
}

function addParticipantRow() {
	nParticipant++;
	var item = $('<tr><th><label></label></th><td><input class="name" maxlength="255" type="text" /><div class="formValidationMessage"></div></td></tr>');
	item.find('label').attr('for', sprintf('namesList%s', nParticipant)).html(sprintf('Participant %s&nbsp;:', nParticipant));
	item.find('input').attr('id', sprintf('namesList%s', nParticipant)).attr('name', sprintf('namesList[%s]', nParticipant));
	item.find('div').attr('id', sprintf('namesList%sFormValidationMessage', nParticipant))
	item.insertBefore('#moreParticipantsRow');
}