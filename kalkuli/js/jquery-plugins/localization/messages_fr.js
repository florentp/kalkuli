/*
 * Translated default messages for the jQuery validation plugin.
 * Locale: FR
 */
jQuery.extend(jQuery.validator.messages, {
        required: '<span class="ui-icon ui-icon-alert"></span> Ce champ est requis.',
        remote: '<span class="ui-icon ui-icon-alert"></span> Veuillez remplir ce champ pour continuer.',
        email: '<span class="ui-icon ui-icon-alert"></span> Veuillez entrer une adresse email valide.',
        url: '<span class="ui-icon ui-icon-alert"></span> Veuillez entrer une URL valide.',
        date: '<span class="ui-icon ui-icon-alert"></span> Veuillez entrer une date valide.',
        dateISO: '<span class="ui-icon ui-icon-alert"></span> Veuillez entrer une date valide (ISO).',
        number: '<span class="ui-icon ui-icon-alert"></span> Veuillez entrer un nombre valide.',
        digits: '<span class="ui-icon ui-icon-alert"></span> Veuillez entrer (seulement) une valeur numérique.',
        creditcard: '<span class="ui-icon ui-icon-alert"></span> Veuillez entrer un numéro de carte de crédit valide.',
        equalTo: '<span class="ui-icon ui-icon-alert"></span> Veuillez entrer une nouvelle fois la même valeur.',
        accept: '<span class="ui-icon ui-icon-alert"></span> Veuillez entrer une valeur avec une extension valide.',
        maxlength: jQuery.validator.format('<span class="ui-icon ui-icon-alert"></span> Veuillez ne pas entrer plus de {0} caractères.'),
        minlength: jQuery.validator.format('<span class="ui-icon ui-icon-alert"></span> Veuillez entrer au moins {0} caractères.'),
        rangelength: jQuery.validator.format('<span class="ui-icon ui-icon-alert"></span> Veuillez entrer entre {0} et {1} caractères.'),
        range: jQuery.validator.format('<span class="ui-icon ui-icon-alert"></span> Veuillez entrer une valeur entre {0} et {1}.'),
        max: jQuery.validator.format('<span class="ui-icon ui-icon-alert"></span> Veuillez entrer une valeur inférieure ou égale à {0}.'),
        min: jQuery.validator.format('<span class="ui-icon ui-icon-alert"></span> Veuillez entrer une valeur supérieure ou égale à {0}.'),

		// Custom messages
		minStrict: jQuery.validator.format('<span class="ui-icon ui-icon-alert"></span> Veuillez entrer une valeur supérieure à {0}.')
});