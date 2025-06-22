$(document).foundation()


let footerText;

function start() {
    const date = new Date();
    const year = date.getFullYear();

    footerText = document.getElementById("footer-text")
    footerText.innerHTML = "Copyright Matt Payne " + year

}

document.onload = start();
