$(document).foundation()

var theLoop = null;
var counterMax = 100

function start() {

    let loadingTextText = "LOADING HTML PAGE"
    const period = " . "

    const loadingText = document.getElementById("loading-text")
    let counter = 0

    theLoop = setInterval(() => {
        counter++;
        loadingTextText = loadingTextText.concat(period)
        loadingText.innerHTML = loadingTextText

        if (counter > counterMax) {
            clearInterval(theLoop)
            loadingText.innerHTML = 'PAGE READY: <a href="https://pattmayne.com">CLICK HERE</a> OR BE REDIRECTED'
        }

    }, 100);

}

document.onload = start();
