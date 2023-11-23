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

export { OpenCloseDiv, OpenCloseDivPassword }