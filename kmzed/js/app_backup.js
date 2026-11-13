$(document).foundation()
window.onload = doLoad

let k_worker


const doConvert = () => {
    if (k_worker) {
        k_worker.terminate()
    }
    k_worker = new Worker("js/worker.js")
    k_worker.onmessage = (e) => {
        console.log(e.data)
        document.getElementById("output").innerHTML = e.data
    }
    k_worker.postMessage("start")
}


function doLoad() {
    document.getElementById("convert_btn").addEventListener("click", doConvert)

}