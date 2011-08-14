$.validator.addMethod('minStrict', function( value, element, param ) {
	return this.optional(element) || value > param;
});

$.datepicker.setDefaults({
	dateFormat: 'dd/mm/yy',
	duration: 0
});