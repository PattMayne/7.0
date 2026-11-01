

var sixPanels
var smallPanels
var buyButtons
var showButtonsButton

function start() {
    console.log("Hello")
    sixPanels = document.getElementsByClassName("one_of_six")
    smallPanels = document.getElementsByClassName("small_picture_panel")
    buyButtons = document.getElementsByClassName("buy_button_left")
    showButtonsButton = document.getElementById("show_buy_button_left_button")
    setPanelSizes()
    setButtonVisibility()
}

function setPanelSizes() {
    for (let i = 0; i < sixPanels.length; i++) {
        sixPanels[i].style.height = String(parseInt(getNineFromSixteen(sixPanels[i].getBoundingClientRect().width))) + "px"
    }

    for (let i = 0; i < smallPanels.length; i++) {
        smallPanels[i].style.height = String(parseInt(getNineFromSixteen(smallPanels[i].getBoundingClientRect().width))) + "px"
    }
}

function setButtonVisibility() {
    if (window.innerWidth < 450) {
        showButtonsButton.style.display = ""
        hideBuyButtons()
    } else {
        showBuyButtons()
        showButtonsButton.style.display = "none"
    }
}

function showBuyButtons() {
    console.log("clicked")
    for (let i = 0; i < buyButtons.length; i++) {
        buyButtons[i].style.display = ""
    }
    document.getElementById("show_buy_button_left_button").style.display = "none"
}

function hideBuyButtons() {
    console.log("clicked")
    for (let i = 0; i < buyButtons.length; i++) {
        buyButtons[i].style.display = "none"
    }
}

// Get the proportionate height for a 16:9 rectangle based on given width
const getNineFromSixteen = sixteenth => sixteenth * 0.5625


document.onload = start()
window.addEventListener('resize', () => {
    setPanelSizes()
    setButtonVisibility()

})

