function loadValidationRules() {
	$('#amount').rules(
		'add',
		{
			required : true,
			number : true,
			minStrict : 0
		}
	);

	$('#description').rules(
		'add',
		{
			required : true
		}
	);

	$('.weight').each(function() {
		$(this).rules(
			'add',
			{
				required : true,
				number : true,
				minStrict : 0
			}
		);
	});
}