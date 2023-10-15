import { OpenCloseDiv } from './scripts.js'

$(document).ready(function() {
    const openCloseDivLogin = new OpenCloseDiv({ 
        buttonDiv: 'forgot-button',
        actionDiv: 'forgot-action',
        speed: 200,
        startState: false
    })

    const openCloseDivRobotButton = new OpenCloseDiv({ 
        buttonDiv: 'robot-button',
        actionDiv: 'robot-action',
        speed: 200,
        startState: false
    })

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

    // VALIDATE MESSAGES
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
})