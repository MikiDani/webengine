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

export { OpenCloseDiv }