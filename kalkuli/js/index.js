function loadValidationRules() {
	$('#sheetName').rules(
		'add',
		{
			required : true
		}
	);

	$('#creatorEmail').rules(
		'add',
		{
			required : true,
			email: true
		}
	);

	$('#retrieveEmail').rules(
		'add',
		{
			required : true,
			email: true
		}
	);
}