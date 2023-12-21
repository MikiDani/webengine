import { OpenCloseDiv, OpenCloseDivPassword } from './scripts.js'

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

	// ADD NEW MODULE VALIDATE
	if ($('#newmodule-form').length) {
		$('#newmodule-form').validate({
			rules: {
				new_date: {
					required: true,
					date: true
				},
				new_title: {
					required: true,
					maxlength: 255
				},
				new_message: {
					required: true,
				},
				new_link: {
					// url: true,
					required: true,
					maxlength: 400
				},
				new_image: {
					required: false
				},
			}
		});
	}

	// ADD NEW MODULE VALIDATE
	if ($('#sendemailmodule-form').length) {
		$('#sendemailmodule-form').validate({
			rules: {
				message: {
					required: false,
				},
				newsletter: {
					required: false,
				},
			}
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

	//////////////////////////////
	// MENU ELEMENT CREATOR ALL //
	//////////////////////////////
	if ($('#menu-box').length) {

		window.myVar = {}
		var menuSpeed = 20

		//first count id-s
		var firstIdCounterIds = function() {
			$("#menu-box").find('li').each(function (){
				let actualMaxId = parseInt($("#menu-box").attr('data-max-id'))
				let liId = parseInt($(this).attr('data-id'))
				if (actualMaxId < liId) {
					$("#menu-box").attr('data-max-id', liId)
				}
			});
		}
		firstIdCounterIds()

		var maxIdCounter = function() {
			let actualMaxId = parseInt($("#menu-box").attr('data-max-id'))
			$("#menu-box").attr('data-max-id', actualMaxId + 1)

			return actualMaxId + 1;
		}

		// OPEN ACTUAL MENU
		if (page_menulistid) {
			$(document).ready(function() {
				$(`#select_${page_menulistid}`).click()
			});
		}

		// MENULIST ELEMENT CREATOR
		var createNewMenuListElement = function (newId, ulCountNumber) {
			let newElement =`
			<li data-id="${newId}" class="menu-sortable menu-sortable_${ulCountNumber} list-style-type-none">
				<div class="menulist-box bg-primary p-2 m-1 text-center rounded">
					<div class="menulist-i-position">
						<i class="bi bi-arrows-move me-1"></i>
					</div>
					<div class="menulist-i-add">
						<i id="plus_${newId}" class="plus-button d-inline-block me-1"></i>
					</div>
					<div class="menulist-i-delete">
						<i id="delete_${newId}" class="minus-button-menulist d-inline-block me-1"></i>
					</div>
					<div class="row p-0 m-0">
						<div class="p-0 m-0 mx-auto col-8 col-lg-5">
							<span class="align-middle form-menulang">HU:</span>
							<input type="text" name="menuname_hu" value="Új menüsor-${newId}" class="form-menuname align-middle" form="null">
						</div>
						<div class="p-0 m-0 mx-auto col-8 col-lg-5 mt-2 mt-lg-0">
							<span class="align-middle form-menulang">EN:</span>
							<input type="text" name="menuname_en" value="New element-${newId}" class="form-menuname align-middle" form="null">
						</div>
					</div>
					<div class="menulist-i-select">
						<i id="select_${newId}" class="select-button d-inline-block align-middle"></i>
					</div>
					<div class="menulist-i-openclose">
						<i id="openclose_${newId}" class="bi bi bi-filter d-inline-block"></i>
					</div>
				</div>
			</li>`;
			return newElement;
		}

		// MODULE ELEMENT CREATOR
		var createNewModuleElement = function (menurowid, newModulelistid, moduleTypeId, moduleTypeName, new_modulename_hu, new_modulename_en) {
			//textmoduletypelabel = bringing variable on blade
			let newElement = `
			<div id="menumodulelist_${newModulelistid}" data-modulelist-id="${newModulelistid}" class="module-sortable_${menurowid} pos-relative bg-primary p-3 pt-1 m-0 mb-2 rounded">
				<input type="hidden" name="edit[${menurowid}][${newModulelistid}][moduletype]" value="${moduleTypeId}">
				<div class="pos-module-arrow">
					<i class="bi bi-arrows-move d-inline-block align-middle ms-1"></i>
				</div>
				<div class="pos-module-delete">
					<i class="minus-button-module d-inline-block align-middle me-1" data-modulelist-id="${newModulelistid}"></i>
				</div>
				<div class="text-center text-small">modulelistid: ${newModulelistid}</div>
				<div class="text-center mb-1">${textmoduletypelabel} <strong>${moduleTypeName}</strong></div>
				<div class="p-0 m-0 d-flex justify-content-start align-items-center">
					<div class="p-0 m-0 width-10">HU:</div>
					<div class="p-0 m-0 width-90">
						<input type="text" name="edit[${menurowid}][${newModulelistid}][modulename_hu]" value="${new_modulename_hu}" class="form-control">
					</div>
				</div>
				<div class="p-0 m-0 d-flex justify-content-start align-items-center mt-1">
					<div class="p-0 m-0 width-10">EN:</div>
					<div class="p-0 m-0 width-90">
						<input type="text" name="edit[${menurowid}][${newModulelistid}][modulename_en]" value="${new_modulename_en}" class="form-control">
					</div>
				</div>
				<div id="selectmodule_${newModulelistid}" class="btn bg-warning mt-2 w-100">${textmustbesaved}</div>
			</div>`;
			return newElement;
		}

		// CREATE ROOT MENU ELEMENT
		$("#new-root-menu").on('click', function() {
			$('#nomenuelement').hide()

			let rootUl = $("#menu-box").children('ul').first()
			let newId = maxIdCounter();

			let newElement = createNewMenuListElement(newId, 1)
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
		arrangementMenuElements() // first load
		
		// ARANGEMENT MODULE ELEMENTS
		var arrangementModuleElements = function () {
			$("div[class^='modulerow_']").each(function() {
				
				let thisId = $(this).attr('data-id')

				$(this).sortable({
					connectWith: `.module-sortable_${thisId}`
				}).disableSelection();
			});
		}
		arrangementModuleElements()	// first load

		var menuModuleListMaxIdCounter = function() {
			$("div[id^='menumodulelist_']").each(function() {
				let dataMaxId = $("#menu-module-box").attr('data-menumodulelist-maxid')
				let thisId = $(this).attr('data-modulelist-id')
				if (thisId >= dataMaxId)	{
					$("#menu-module-box").attr('data-menumodulelist-maxid', thisId)
				}
			})
			let actualMaxId = parseInt($("#menu-module-box").attr('data-menumodulelist-maxid')) + 1

			$("#new_modulename_hu").attr('value', `Új modul ${actualMaxId}`); $("#new_modulename_hu").val(`Új modul ${actualMaxId}`)
			$("#new_modulename_en").attr('value', `New Module ${actualMaxId}`); $("#new_modulename_en").val(`Új modul ${actualMaxId}`)
			$('*').blur();

			return actualMaxId;
		}
		menuModuleListMaxIdCounter()  // first load

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

		// BUTTON DELETE MODULE
		var buttonDeleteModuleAction = function (element) {
			let question = confirm(textmoduledeletealert);
			if (question == true) {
				let thisId = element.attr('data-modulelist-id')
				$(`#menumodulelist_${thisId}`).remove()
			}
		}
		$(".minus-button-module").on('click', function () {
			buttonDeleteModuleAction($(this))
		});
		
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
			menuModuleListMaxIdCounter()
			$("#new_menumodule").show()
			let thisLi = clone.closest('.menu-sortable')
			var thisId = thisLi.attr('data-id')
			let moduleHeadText = (lang == 'hu') ? thisLi.find("input[name='menuname_hu']").val() : thisLi.find("input[name='menuname_en']").val();

			myVar.selectedModuleId = thisId
			$("#id_menulist").val(thisId)
			$("div[class^='modulerow_']").each(function() {
				$("#menu-module-label").html(`<div class="text-center">${moduleHeadText}<span class="text-small">&#160;&#160; id: ${thisId}</span></div>`)
				if (thisId == $(this).attr('data-id')) { $(this).show() } else { $(this).hide() }
			})
		}
		$("#menu-box").find("i[id^='select_']").on('click', function() {
			$("#menu-box").find(".selected-menuelement-bg").removeClass("selected-menuelement-bg")
			$(this).closest('.menulist-box').addClass('selected-menuelement-bg')
			var clone = $(this)
			selectAction(clone)
		});

		// DELETE
		var deleteAction = function(clone) {
			let liELement = clone.closest('.menu-sortable')
			let dataId = liELement.attr('data-id')
			var childUl = clone.closest('.menu-sortable').find('ul')
			
			if(!(childUl.length > 0)) {
				let question = confirm(textmoduledeletealert);
				if (question == true) {
					if (liELement.siblings().length == 0) {
						// Last li element. Delete environment and parent element openclose icon reset standard position
						let parentElementOpenCloseIcon = liELement.parent().closest('.menu-sortable').find("i[id^='openclose_']")
						parentElementOpenCloseIcon.removeClass('bi-caret-down bi-caret-right-fill bi-filter')
						parentElementOpenCloseIcon.addClass(' bi-filter')

						liELement.parent().remove()
					} else {
						// Not last li element. Only delete.
						liELement.remove()
					}
					// DELETE MODULES ELEMENTS
					if ($(`.modulerow_${dataId}`).length > 0) {
						$(`.modulerow_${dataId}`).remove()
						if (dataId == myVar.selectedModuleId) {
							$('#menu-module-label').text(textselectedelementlabel)
							$('#new_menumodule').hide()
						}
					}
					// IF MENU-BOX EMPTY
					if ($('#menu-box').length == 0 || $('#menu-box ul').find('li').length == 0) {
						$('#nomenuelement').show()
					}
				}
			} else {
				// Have children, cannot delete parent
				childUl.css('border-radius', '0.5rem')
				childUl.css('background-color', 'gold')
			
				var intervalId = setInterval(function () {
					childUl.css('background-color', 'white')
					clearInterval(intervalId)
				}, 1000);
			}
		}
		$("#menu-box").find("i[id^='delete_']").on('click', function() {
			let clone = $(this)
			deleteAction(clone)
		});

		// PLUS MENU BUTTON
		var plusButtonsclickEvent = function(clone) {
			let newId = parseInt($("#menu-box").attr('data-max-id')) + 1
			$("#menu-box").attr('data-max-id', newId)

			let parentLi = clone.closest('.menu-sortable')
	
			if (parentLi.children('ul').length > 0) {
				// Have children UL
				let childUl = parentLi.children('ul')
				let ulCountNumber = childUl.first().attr('data-count')
				let newElement = createNewMenuListElement(newId, ulCountNumber)
				childUl.append(newElement)
			} else {
				// No have children UL Now create
				parentLi.find("div i[id^='openclose_']").removeClass('bi-caret-down bi-caret-right-fill bi-filter')
				parentLi.find("div i[id^='openclose_']").addClass('bi-caret-down')

				let newUlCountNumber = $("#menu-box").find('ul').length + 1
				let newUlElement = $(`<ul data-count="${newUlCountNumber}" class="menu-menurow_${newUlCountNumber}"></ul>`);
				let newElement = createNewMenuListElement(newId, newUlCountNumber)
				newUlElement.append(newElement)
				parentLi.append(newUlElement)
			}

			newAddEventlisteners(newId)
		}
		$("#menu-box").find(`i[id^='plus_']`).on('click', function() {
			let clone = $(this)
			plusButtonsclickEvent(clone)
		});

		//ADD MODULE BUTTON
		$("#add-module-button").on('click', function () {

			var createModuleElement = function (parentElement, moduleTypeId, moduleTypeName, new_modulename_hu, new_modulename_en) {
				let newModulelistid = menuModuleListMaxIdCounter();
				$("#new_modulename_hu").attr('value', `Új modul ${newModulelistid + 1}`)
				$("#new_modulename_en").attr('value', `New Module ${newModulelistid + 1}`)
				let newModuleElement = createNewModuleElement(myVar.selectedModuleId, newModulelistid, moduleTypeId, moduleTypeName, new_modulename_hu, new_modulename_en)

				parentElement.prepend(newModuleElement)

				return newModulelistid;
			}

			let moduleTypeId = $("select[name='new_moduletype']").val()
			let moduleTypeName = $("select[name='new_moduletype'] option:selected").text()
			let new_modulename_hu = $("#new_modulename_hu").val()
			let new_modulename_en = $("#new_modulename_en").val()

			let findingElement = $("#menu-module-box").find(`.modulerow_${myVar.selectedModuleId}`)

			let newModulelistid

			// isset modulelist
			if (findingElement.length > 0) {
				newModulelistid = createModuleElement(findingElement, moduleTypeId, moduleTypeName, new_modulename_hu, new_modulename_en)
			// not isset modulelist
			} else {
				let newDivElement = `<div class="modulerow_${myVar.selectedModuleId} p-0 m-0" data-id="${myVar.selectedModuleId}"></div>`;
				$("#menu-module-label").after(newDivElement)
				let findingElement = $("#menu-module-box").find(`.modulerow_${myVar.selectedModuleId}`)
				newModulelistid = createModuleElement(findingElement, moduleTypeId, moduleTypeName, new_modulename_hu, new_modulename_en)

				arrangementModuleElements()
			}
			// DELETE button
			$(`#menumodulelist_${newModulelistid}`).find(`i[data-modulelist-id='${newModulelistid}']`).on('click', function() {
				buttonDeleteModuleAction($(this))
			});
			// SAVE button
			$(`#selectmodule_${newModulelistid}`).on('click', function() {
				$("#save-menu").click();
			});
		});

		// MAKE MENU SAVE ARRAY
		$("#save-menu").on('click', function() {
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

	/////////////////
	// NEWS MODULE //
	/////////////////
	if ($('#news-box').length) {

		// Scroll jump
		if (typeof rowId !== 'undefined' && $(`#newsrow-head_${rowId}`).length > 0) document.getElementById(`newsrow-head_${rowId}`).scrollIntoView();

		$('#collapseButton').click(function(){
			$('.collapse-icon i').toggleClass('bi-chevron-bar-down bi-chevron-bar-up');
		});

		// ARANGEMENT NEWS MODULE ELEMENTS
		var newsModuleElements = function () {
			$("#news-all").sortable({
				connectWith: ".editNewsSortable"
			}).disableSelection();
		}
		newsModuleElements() // first load

		$('#newmodule-form, #editmodule-form').on('keypress', 'input', function(event) {
			if (event.which === 13) {
				event.preventDefault();
				$(this).blur();
				return false;
			}
		});

		$(".openclose-arrows-pos").on('click', function(event) {
			event.stopPropagation();
			let thisId = $(this).attr('data-id');
			if ($(`#newsrow-content_${thisId}`).css('display') === 'none') {
				$(this).find('i').removeClass('bi-caret-down-fill')
				$(this).find('i').addClass('bi-caret-up-fill')
				$(`#newsrow-content_${thisId}`).show(100)
				$("input[name='rowid']").each(function() {
					$(this).val(thisId)
					console.log($(this).val())
				});
				
			} else {
				$(this).find('i').removeClass('bi-caret-up-fill')
				$(this).find('i').addClass('bi-caret-down-fill')
				$(`#newsrow-content_${thisId}`).hide(100)
				$("input[name='rowid']").each(function() {
					$(this).val(null)
					console.log($(this).val())
				});
			}
		});

		$(".news-label-click").on('click', function() {
			let thisId = $(this).attr('data-id');
			if ($(`#newsrow-content_${thisId}`).css('display') === 'none') {
				$(this).find('.openclose-arrows-pos').find('i').removeClass('bi-caret-down-fill')
				$(this).find('.openclose-arrows-pos').find('i').addClass('bi-caret-up-fill')
				$(`#newsrow-content_${thisId}`).show(100)
				$("input[name='rowid']").each(function() {
					$(this).val(thisId)
					console.log($(this).val())
				});
				
			} else {
				$(this).find('.openclose-arrows-pos').find('i').removeClass('bi-caret-up-fill')
				$(this).find('.openclose-arrows-pos').find('i').addClass('bi-caret-down-fill')
				$(`#newsrow-content_${thisId}`).hide(100)
				$("input[name='rowid']").each(function() {
					$(this).val(null)
					console.log($(this).val())
				});
			}
		});
		
		$(".delete-arrows-pos").on('click', function() {
			let question = confirm(texteditnewsdeletemessage);
			if (question == true) {
				let thisId = $(this).attr('data-id');
				$(`.editNewsSortable_${thisId}`).remove()

				if ($('#news-all').find('.editNewsSortable').length == 0) {
					$('#news-all').append('<div class="mt-2 m-0 p-2 bg-success text-white fw-bold rounded">' + textemptymessage + '</div>')
				}
			}
		});

		var colorizer = function (element, value, originalColor, warningColor, time) {
			element.css('color', warningColor)

			element.text(value)
			const myTimeout = setTimeout(function() {
				element.css('color', originalColor)
			}, time);

			function myStopFunction() {
			clearTimeout(myTimeout);
			}
		}

		$("input[name$='[date]']").on('change', function() {
			let thisId = $(this).attr('data-id')
			let value = $(this).val()
			colorizer($(`#newsrow-head_${thisId}`).find('.newsrow-datetime'), value, 'white', 'yellow', 1000)
			
		});

		$("input[name$='[title]']").on('keyup', function() {
			let thisId = $(this).attr('data-id')
			let value = $(this).val()
			colorizer($(`#newsrow-head_${thisId}`).find('.newsrow-title'), value, 'white', 'yellow', 1000)
		});

		$(".allopen").on('click', function(){
			$('.newsrow-content').show(100);
			$(".openclose-arrows-pos").find('i').removeClass('bi-caret-down-fill bi-caret-up-fill')
			$(".openclose-arrows-pos").find('i').addClass('bi-caret-up-fill')
		});

		$(".allclose").on('click', function(){
			$('.newsrow-content').hide(100);
			$(".openclose-arrows-pos").find('i').removeClass('bi-caret-down-fill bi-caret-up-fill')
			$(".openclose-arrows-pos").find('i').addClass('bi-caret-down-fill')
		});
	}

	////////////////////
	// GALLERY MODULE //
	////////////////////
	if ($('#gallery-box').length) {

		// ARANGEMENT GALLERY PICTURES ELEMENTS
		var arrangementPicturesElements = function () {
			$("#pictures-list").sortable({
				connectWith: `.picture-sortable`
			}).disableSelection();
		}
		arrangementPicturesElements() // first load
	}

	$('#collapseButton').click(function(){
		$('.collapse-icon i').toggleClass('bi-chevron-bar-down bi-chevron-bar-up');
	});
})
