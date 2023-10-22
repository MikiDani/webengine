import { OpenCloseDiv, OpenCloseDivPassword, DomCheckModify } from './scripts.js'

console.log(lang)

var speed = 200

$(document).ready(function() {
	const openCloseDivLogin = new OpenCloseDivPassword({ 
		buttonDiv: 'forgot-button',
		actionDiv: 'forgot-action',
		speed: speed,
		startState: false,
		switchelements: ['email'],
	})

	const openCloseDivRobotButton = new OpenCloseDiv({ 
		buttonDiv: 'robot-button',
		actionDiv: 'robot-action',
		speed: speed,
		startState: false
	})

	const openCloseDivCurrentButton = new OpenCloseDivPassword({ 
		buttonDiv: 'change-button',
		actionDiv: 'change-action',
		speed: speed,
		startState: false,
		switchelements: ['newpassword', 'newpasswordagain'],
	})

	const openCloseUnsubscribe = new OpenCloseDivPassword({ 
		buttonDiv: 'unsubscribe-button',
		actionDiv: 'unsubscribe-action',
		speed: speed,
		startState: false,
		switchelements: ['currentpassword', 'modifyprofilebutton'],
	})

	// LANGUAGE CHANGE
	if ($('#selectlang').length) {
		$("#selectlang").on("change", function () {
			$("#changelang").submit();
		});
	}

	// LOGIN VALIDATE
	if ($('#login-form').length) {
		$('#login-form').validate({
			rules: {
				usernameoremail: {
					required: true,
					minlength: 8,
					maxlength: 255
				},
				password: {
					required: true,
					minlength: 8,
					maxlength: 255
				},
			}
		});
	}

	// FORGOT PASSWORD VALIDATE
	if ($('#forgot-password').length) {
		$('#forgot-password').validate({
			rules: {
				email: {
					required: true,
					email: true,
				},
			}
		});
	}

	// REGISTRATION VALIDATE
	if ($('#registration-form').length) {
		$('#registration-form').validate({
			rules: {
				name: {
					required: true,
					minlength: 8,
					maxlength: 50
				},
				email: {
					required: true,
					email: true
				},
				password: {
					required: true,
					minlength: 8,
					maxlength: 255
				},
				re_password: {
					required: true,
					minlength: 8,
					maxlength: 255,
					equalTo: "#password"
				}
			},
			messages: {
			}
		});
	}

	// NEWPASSRORD VALIDATE
	if ($('#newpass-form').length) {
		$('#newpass-form').validate({
			rules: {
				password: {
					required: true,
					minlength: 8,
					maxlength: 255
				},
				re_password: {
					required: true,
					minlength: 8,
					maxlength: 255,
					equalTo: "#password"
				}
			}
		});
	}

	// PROFILE VALIDATE
	if ($('#profile-form').length) {
		$('#profile-form').validate({
			rules: {
					name: {
					minlength: 8,
					maxlength: 255
				},
				currentpassword: {
					required: true,
					minlength: 8,
					maxlength: 255
				},
				newpassword: {
					required: true,
					minlength: 8,
					maxlength: 255,
				},
				newpasswordagain: {
					required: true,
					minlength: 8,
					maxlength: 255,
					equalTo: "#newpassword"
				}
			}
		});
	}

	// UNSUBSCRIBE VALIDATE
	if ($('#unsubscribe-form').length) {
		$('#unsubscribe-form').validate({
			rules: {
				currentpassword: {
					required: true,
					minlength: 8,
					maxlength: 255
				},
				confirm: {
					required: true,
				}
			},
			errorPlacement: function (error, element) {
				error.appendTo("#checkbox-messages");
			},
		});
	}

	// VALIDATE MESSAGES
	if (lang == 'hu') {
		jQuery.extend(jQuery.validator.messages, {
			required: "Kötelező kitölteni.",
			remote: "Kérjük, javítsa ki ezt a mezőt.",
			email: "Kérjük, adjon meg egy érvényes e-mail címet.",
			url: "Kérjük, adjon meg egy érvényes URL-t.",
			date: "Kérjük, adjon meg egy érvényes dátumot.",
			dateISO: "Adjon meg egy érvényes dátumot (ISO).",
			number: "Kérjük, adjon meg egy érvényes számot.",
			digits: "Kérjük, csak számjegyeket írjon be.",
			creditcard: "Kérjük, adjon meg egy érvényes hitelkártyaszámot.",
			equalTo: "Kérjük, adja meg újra ugyanazt az értéket.",
			accept: "Kérjük, adjon meg egy értéket érvényes kiterjesztéssel.",
			maxlength: jQuery.validator.format("Kérjük, legfeljebb {0} karaktert adjon meg."),
			minlength: jQuery.validator.format("Kérjük, adjon meg legalább {0} karaktert."),
			rangelength: jQuery.validator.format("Kérjük, adjon meg egy {0} és {1} karakter hosszúságú értéket."),
			range: jQuery.validator.format("Kérjük, adjon meg egy értéket {0} és {1} között."),
			max: jQuery.validator.format("Kérjük, adjon meg {0}-nál kisebb vagy azzal egyenlő értéket."),
			min: jQuery.validator.format("Kérjük, adjon meg egy nagyobb vagy egyenlő értéket, mint {0}.")
		});
	} else {
		jQuery.extend(jQuery.validator.messages, {
			required: "This field is required.",
			remote: "Please fix this field.",
			email: "Please enter a valid email address.",
			url: "Please enter a valid URL.",
			date: "Please enter a valid date.",
			dateISO: "Please enter a valid date (ISO).",
			number: "Please enter a valid number.",
			digits: "Please enter only digits.",
			creditcard: "Please enter a valid credit card number.",
			equalTo: "Please enter the same value again.",
			accept: "Please enter a value with a valid extension.",
			maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
			minlength: jQuery.validator.format("Please enter at least {0} characters."),
			rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
			range: jQuery.validator.format("Please enter a value between {0} and {1}."),
			max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
			min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
		});
	}
})