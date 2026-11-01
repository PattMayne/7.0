

var sixPanels
var smallPanels
var buyButtons
var showButtonsButton
var showHideButton

function start() {
    console.log("Hello")
    sixPanels = document.getElementsByClassName("one_of_six")
    smallPanels = document.getElementsByClassName("small_picture_panel")
    buyButtons = document.getElementsByClassName("buy_button_left")
    showButtonsButton = document.getElementById("show_buy_button_left_button")
    showHideButton = document.getElementById("show-hide-button")
    setPanelSizes()
    setButtonVisibility()

    showHideButton.addEventListener("click", show_hide_bio)
}

function show_hide_bio() {
    var restOfBio = document.getElementById("hide_first")
    if (restOfBio.style.display == "none") {
        restOfBio.style.display = ""
        showHideButton.innerHTML = "LESS"
    } else {
        restOfBio.style.display = "none"
        showHideButton.innerHTML = "MORE"
    }
    console.log("showing hiding bio")
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

    var restOfBio = document.getElementById("hide_first")
    if (window.innerWidth < 1020) {
        restOfBio.style.display = "none"
        showHideButton.style.display = ""
        showHideButton.innerHTML = "MORE"
    } else {
        restOfBio.style.display = ""
        showHideButton.innerHTML = "LESS"
        showHideButton.style.display = "none"
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

