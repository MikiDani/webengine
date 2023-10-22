class OpenCloseDiv {
	constructor({ buttonDiv, actionDiv, speed, startState}) {
		this.openCloseDiv({ buttonDiv: buttonDiv, actionDiv: actionDiv, speed: speed, startState: startState })
	}
	
	openCloseDiv({buttonDiv, actionDiv, speed, startState}) {
		(startState == true) ? $(`.${actionDiv}`).show() : $(`.${actionDiv}`).hide();
		$(`.${buttonDiv}`).on('click', function() {
			($(`.${actionDiv}`).css('display') == 'none')
			? $(`.${actionDiv}`).show(speed)
			: $(`.${actionDiv}`).hide(speed)
		})
	}
}

class OpenCloseDivPassword extends OpenCloseDiv {
	constructor ({buttonDiv: buttonDiv, actionDiv: actionDiv, speed: speed, startState: startState, switchelements }) {
		super({ buttonDiv: buttonDiv, actionDiv: actionDiv, speed: speed, startState: startState })
		this.switchelements = switchelements

		this.switchelements.forEach(switchelement => {
			$(`.${buttonDiv}`).on('click', function() {
				if ($(`#${switchelement}`).prop('disabled') == true) {
					$(`#${switchelement}`).prop('disabled', false)
				} else {
					$(`#${switchelement}`).prop('disabled', true)
				}
			})
		});
	}
}

class DomCheckModify {
	constructor(elementId) {
		this.element = document.getElementById(elementId)        
		
		var clone = this
		
		var observer = new MutationObserver(function(mutations) {
			console.log(clone.element)
			console.log(mutations)
			console.log("A DOM megváltozott a myElement elemen.")
		});

		var config = { childList: true, subtree: true };

		observer.observe(this.element, config);
	}
}

export { OpenCloseDiv, OpenCloseDivPassword, DomCheckModify }