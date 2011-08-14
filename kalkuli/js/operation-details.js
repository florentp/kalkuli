function loadValidationRules() {
	$('#amount').rules(
		'add',
		{
			required : true,
			number : true,
			minStrict : 0
		}
	);

	$('#weight').rules(
		'add',
		{
			required : true,
			number : true,
			minStrict : 0
		}
	);
}