$.validator.addMethod('minStrict', function( value, element, param ) {
	return this.optional(element) || value > param;
});

