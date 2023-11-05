import { OpenCloseDiv, OpenCloseDivPassword, DomCheckModify } from './scripts.js'

//console.log(lang)

var speed = 200

$(document).ready(function() {
	// AUTENTICATION login, register, profil
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
	// MENU ELEMENT CREATOR ALL
	if ($('#menu-box').length) {

		var menuSpeed = 20

		//first count id-s
		var firstIdCounterIds = function() {
			$("#menu-box").find('li').each(function (){
				let actualMaxId = parseInt($("#menu-box").attr('data-max-id'))
				let liId = parseInt($(this).attr('data-id'))
				console.log('max: '+ actualMaxId + '  elid: ' + liId)
				if (actualMaxId < liId) {
					$("#menu-box").attr('data-max-id', liId)
				}
			});
			console.log('utanna max: '+ $("#menu-box").attr('data-max-id'))
		}
		firstIdCounterIds()

		var maxIdCounter = function() {
			let actualMaxId = parseInt($("#menu-box").attr('data-max-id'))
			$("#menu-box").attr('data-max-id', actualMaxId + 1)

			return actualMaxId + 1;
		}

		// ELEMENT CREATOR
		var createNewElement = function (newId, ulCountNumber) {
			let newElement = `
			<li id="${newId}" data-id="${newId}" class="menu-sortable menu-sortable_${ulCountNumber} menu-list-line-height">
				<div class="menu-list-line-min-width bg-secondary p-2 m-1 text-center rounded">
					<i class="bi bi-arrows-move d-inline-block align-middle me-1"></i>
					<i id="plus_${newId}" class="plus-button d-inline-block align-middle me-1"></i>
					<i id="delete_${newId}" class="minus-button d-inline-block align-middle me-1"></i>
					<span class="align-middle">HU:</span>
					<input type="text" name="menuname_hu" value="Új menüsor-${newId}" class="form-menuname d-inline-block align-middle">
					<span class="align-middle">EN:</span>
					<input type="text" name="menuname_en" value="New element-${newId}" class="form-menuname d-inline-block align-middle">
					<i id="select_${newId}" class="select-button d-inline-block align-middle"></i>
					<i id="openclose_${newId}" class="bi bi-filter mt-05 float-end d-inline-block align-middle"></i>
				</div>
			</li>`;
			return newElement;
		}

		// CREATE ROOT MENU ELEMENT
		$("#new-root-menu").on('click', function() {
			$('#nomenuelement').hide()

			let rootUl = $("#menu-box").children('ul').first()
			let newId = maxIdCounter();

			let newElement = createNewElement(newId, 1)
			rootUl.append(newElement)

			newAddEventlisteners(newId)
		});
				
		// ARANGEMENT MENU ELEMENTS
		var arrangementMenuElements = function () {
			$("ul[class^='menu-menurow_']").each(function() {
				let count = $(this).attr('data-count')
				$(this).sortable({
					connectWith: `.menu-sortable_${count}`
				}).disableSelection();
			});
		}
		arrangementMenuElements()	// first load

		// ADD EVENTLISTENERS
		var newAddEventlisteners = function(newId) {
			$("#menu-box").find(`i[id^='plus_${newId}']`).off()
			$("#menu-box").find(`i[id^='plus_${newId}']`).on('click', function() {
				let clone = $(this)
				plusButtonsclickEvent(clone)
			});
			$("#menu-box").find(`i[id^='openclose_${newId}']`).on('click', function() {
				let clone = $(this)
				openCloseAction(clone)
			});
			$("#menu-box").find(`i[id^='delete_${newId}']`).on('click', function() {
				let clone = $(this)
				deleteAction(clone)
			});
			$("#menu-box").find(`i[id^='select_${newId}']`).on('click', function() {
				let clone = $(this)
				selectAction(clone)
			});
			arrangementMenuElements()
		}
		
		// OPEN / CLOSE
		var openCloseAction = function(clone) {
			var iconElement = clone
			let childUl = clone.closest('.menu-sortable').find('ul')
			if(childUl.length > 0) {
				childUl.children('li').each(function() {
					if ($(this).css('display') == 'none') {
						$(this).show(menuSpeed)
						iconElement.removeClass('bi-caret-right-fill')
						iconElement.addClass('bi-caret-down')
					} else {
						iconElement.removeClass('bi-caret-down')
						iconElement.addClass('bi-caret-right-fill')
						$(this).hide(menuSpeed)
					}
				});
			}
		}
		$("#menu-box").find("i[id^='openclose_']").on('click', function() {
			let clone = $(this)
			openCloseAction(clone)
		});

		// SELECT
		var selectAction = function(clone) {
			let thisLi = clone.closest('.menu-sortable');
			let thisId = thisLi.attr('data-id');
			$("#menu-element-label").text('This menu element ID: ' + thisId)
		}
		$("#menu-box").find("i[id^='select_']").on('click', function() {
			var clone = $(this)
			selectAction(clone)
		});

		// DELETE
		var deleteAction = function(clone) {
			let liELement = clone.closest('.menu-sortable')
			var childUl = clone.closest('.menu-sortable').find('ul')

			if(!(childUl.length > 0)) {
				if (liELement.siblings().length == 0) {
					// Last li element. Delete environment and parent element openclose icon reset standard position
					let parentElementOpenCloseIcon = liELement.parent().closest('.menu-sortable').find("i[id^='openclose_']")
					parentElementOpenCloseIcon.removeClass('bi-caret-down bi-caret-right-fill bi-filter')
					parentElementOpenCloseIcon.addClass(' bi-filter')

					liELement.parent().remove();
				} else {
					// Not last li element. Only delete.
					liELement.remove()
				}
				if ($('#menu-box').length == 0 || $('#menu-box ul').find('li').length == 0) {
					$('#nomenuelement').show()
				}
			} else {
				console.log('Van GYERMEK');
				childUl.css('border-radius', '0.5rem');
				childUl.css('background-color', 'gold');
			
				var intervalId = setInterval(function () {
					childUl.css('background-color', 'white');
					clearInterval(intervalId);
				}, 1000);
			}
		}
		$("#menu-box").find("i[id^='delete_']").on('click', function() {
			let clone = $(this)
			deleteAction(clone)
		});

		// PLUS BUTTON
		var plusButtonsclickEvent = function(clone) {
			let newId = ($("#menu-box").find('li').length > 0) ? $("#menu-box").find('li').length + 1 : 1;
			let parentLi = clone.closest('.menu-sortable')
	
			if (parentLi.children('ul').length > 0) {
				// have children UL
				let childUl = parentLi.children('ul')
				let ulCountNumber = childUl.first().attr('data-count')
				let newElement = createNewElement(newId, ulCountNumber)
				childUl.append(newElement)
			} else {
				// no have children UL Now create.
				parentLi.find("div i[id^='openclose_']").removeClass('bi-caret-down bi-caret-right-fill bi-filter')
				parentLi.find("div i[id^='openclose_']").addClass('bi-caret-down')

				let newUlCountNumber = $("#menu-box").find('ul').length + 1
				let newUlElement = $(`<ul data-count="${newUlCountNumber}" class="menu-menurow_${newUlCountNumber}"></ul>`);
				let newElement = createNewElement(newId, newUlCountNumber)
				newUlElement.append(newElement)
				parentLi.append(newUlElement)
			}

			newAddEventlisteners(newId)
		}
		$("#menu-box").find(`i[id^='plus_']`).on('click', function() {
			let clone = $(this)
			plusButtonsclickEvent(clone)
		});

		// MAKE MENU SAVE ARRAY
		$("#save-menu").on('click', function() {		
			window.myVar = {}
			myVar.menu = []
			myVar.count = 0
			myVar.count_ul = 0
			
			const recursiveBulder = (ul_element) => {
				myVar.count++;
				let legoMenu = []
				ul_element.children('li').each(function() {
					myVar.count++;
					let menuIns = {}
					menuIns['id'] = $(this).attr('data-id')
					menuIns['sequence'] = myVar.count;
					menuIns['menuname_hu'] = $(this).find("input[name='menuname_hu']").val()
					menuIns['menuname_en'] = $(this).find("input[name='menuname_en']").val()
					let searchUl = $(this).children('ul');
					if (searchUl.length > 0) {
						menuIns['child'] = recursiveBulder(searchUl)
					}
					legoMenu.push(menuIns)
				});
				return legoMenu;
			}
			
			if ($("#menu-box").children('ul').length > 0) {
				$("#menu-box").children('ul').each(function() {
					let ul_element = $(this)
					myVar.menu = recursiveBulder(ul_element)
					$('#menuarray').val(JSON.stringify(myVar.menu))
					$('#menu-save').submit()
					window.myVar = {}
				});
			} else {
				$('#menuarray').val(JSON.stringify(null))
				$('#menu-save').submit()
			}
		});
    }
})