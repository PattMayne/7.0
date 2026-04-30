// Access the canvas element and its 2D rendering context
const canvas_desktop = document.getElementById("uncube_canvas_desktop")
const canvas_mobile = document.getElementById("uncube_canvas_mobile")
const width = canvas_desktop.width // Canvas width
const height = canvas_desktop.height // Canvas height

const ctx_desktop = canvas_desktop.getContext("2d") // 2D drawing context
const ctx_mobile = canvas_mobile.getContext("2d") // 2D drawing context

ctx_desktop.strokeStyle = "#00ff10"  // Set the color for the line
ctx_desktop.lineWidth = 3  // Set the width of the line

ctx_mobile.strokeStyle = "#00ff10"  // Set the color for the line
ctx_mobile.lineWidth = 2  // Set the width of the line

const isVisible = (elem) => window.getComputedStyle(elem).display !== 'none'

const img_draw_data = {
    x: canvas_desktop.width / 4,
    y: canvas_desktop.height / 4,
    width: canvas_desktop.width / 2,
    height: canvas_desktop.height / 2
}

let fake_tilt = true
const tilt = 0.2

let guy_is_cool = true
let dotted_lines = false

//const conguy = document.getElementById("./img/conguy.png")
let conguy = new Image();
//conguy.src = "./img/coolconguy.png"
conguy.src = guy_is_cool ? "./img/coolconguy.png" : "./img/conguy.png"

const switch_guy = () => {
    guy_is_cool = !guy_is_cool
    conguy.src = guy_is_cool ? "./img/coolconguy.png" : "./img/conguy.png"
    dotted_lines = !dotted_lines
}

canvas_desktop.addEventListener("click", switch_guy)
canvas_mobile.addEventListener("click", switch_guy)

const timeout = 60 // Timeout for animation update
const f = 500  // Focal length for 3D projection (larger values make objects smaller)
const D = 410  // Distance from the viewer (larger values make objects appear smaller)

const clearScreen = ctx => ctx.clearRect(0, 0, width, height) // Clear the canvas to prepare for the next frame

function line(ctx, x1, y1, x2, y2) {
    ctx.beginPath()  // Start a new drawing path
    ctx.moveTo(x1, y1)  // Move to the start point
    ctx.lineTo(x2, y2)  // Draw a line to the end point
    ctx.stroke()  // Apply the stroke to render the line
}


// the vector class to represent a 3D vector (point)
class vector {
    constructor(x, y, z) {
        this.x = x // x-coordinate
        this.y = y // y-coordinate
        this.z = z // z-coordinate
    }


    // Convert a 3D point to a 2D point for drawing
    get_point2d() {
        return project3Dto2D(this.x, this.y, this.z)
    }

    // Rotate the vector around the X-axis
    rotateX(theta) {
        const cosTheta = Math.cos(theta)
        const sinTheta = Math.sin(theta)
        const yNew = this.y * cosTheta - this.z * sinTheta
        const zNew = this.y * sinTheta + this.z * cosTheta
        this.y = yNew
        this.z = zNew
    }

    // Rotate the vector around the Y-axis
    rotateY(theta) {
        const cosTheta = Math.cos(theta)
        const sinTheta = Math.sin(theta)
        const xNew = this.x * cosTheta + this.z * sinTheta
        const zNew = -this.x * sinTheta + this.z * cosTheta
        this.x = xNew
        this.z = zNew
    }

    // Rotate the vector around the Z-axis
    rotateZ(theta) {
        const cosTheta = Math.cos(theta)
        const sinTheta = Math.sin(theta)
        const xNew = this.x * cosTheta - this.y * sinTheta
        const yNew = this.x * sinTheta + this.y * cosTheta
        this.x = xNew
        this.y = yNew
    }

    // Scale the vector by a factor relative to the center
    scale(scaleFactor, center) {
        this.x = (this.x - center.x) * scaleFactor + center.x
        this.y = (this.y - center.y) * scaleFactor + center.y
        this.z = (this.z - center.z) * scaleFactor + center.z
    }
}


function project3Dto2D(x, y, z) {
    const x2D = (x / (z + D)) * f + width / 2
    const y2D = fake_tilt ? -((y + tilt * z) / (z + D)) * f + height / 2 : (-(y / (z + D)) * f + height / 2)
    return { x: x2D, y: y2D }  // Return the 2D coordinates
}


// Class to represent a 3D model (collection of points and edges)
class model {
    constructor(name, points, edges = [], dotted_edges = []) {
        this.name = name // Name of the model
        this.points = points // Array of 3D points
        this.edges = edges // Array of edges connecting the points
        this.dotted_edges = dotted_edges // Array of dotted edges
    }

    // Draw the model on the canvas
    draw(ctx) {

        // First, draw the points (actually skip this)
        false && this.points.forEach(this_point => this_point.draw()) // Draw each point using the draw method from the vector class

        // Draw the edges BEHIND the guy
        this.edges.forEach(this_edge => {
            if (this_edge[0].z < 0 && this_edge[1].z < 0) return
            const start = this_edge[0].get_point2d() // Start point of the edge
            const end = this_edge[1].get_point2d() // End point of the edge
            line(ctx, start.x, start.y, end.x, end.y) // Draw the line between the two points
        })

        // draw face
        ctx.drawImage(
            conguy,
            img_draw_data.x,
            img_draw_data.y,
            img_draw_data.width,
            img_draw_data.height
        )

        // Draw the edges in FRONT of the guy
        this.edges.forEach(this_edge => {
            if (this_edge[0].z < 5 || this_edge[1].z < 5) {                
                const start = this_edge[0].get_point2d() // Start point of the edge
                const end = this_edge[1].get_point2d() // End point of the edge
                line(ctx, start.x, start.y, end.x, end.y) // Draw the line between the two points
            }
        })

        if (dotted_lines) {
            ctx.setLineDash([10, 5]); // 5px dash, 15px gap
            this.dotted_edges.forEach(this_edge => {
                const start = this_edge[0].get_point2d() // Start point of the edge
                const end = this_edge[1].get_point2d() // End point of the edge
                line(ctx, start.x, start.y, end.x, end.y) // Draw the line between the two points
            })
            ctx.setLineDash([]); // Reset to solid line
        }
    }

    // Rotate the model around the X-axis
    rotateX(theta) {
        theta = theta * Math.PI / 180
        this.points.forEach(this_point => this_point.rotateX(theta))
    }

    // Rotate the model around the Y-axis
    rotateY(theta) {
        theta = theta * Math.PI / 180
        this.points.forEach(this_point => this_point.rotateY(theta))
    }

    // Rotate the model around the Z-axis
    rotateZ(theta) {
        theta = theta * Math.PI / 180
        this.points.forEach(this_point => this_point.rotateZ(theta))
    }

    // Scale the model by a factor relative to the center of the model
    scale(scaleFactor) {
        this.points.forEach(this_point => this_point.scale(scaleFactor, this.getCenter()))
    }

    // Get the center of the model by averaging all points
    getCenter() {
        let centerX = 0, centerY = 0, centerZ = 0
        this.points.forEach(this_point => {
            centerX += this_point.x
            centerY += this_point.y
            centerZ += this_point.z
        })

        return new vector(
            centerX / this.points.length,
            centerY / this.points.length,
            centerZ / this.points.length
        )
    }
}


const points = [
    // square facing me
    new vector(-100, -100, 0), // Bottom-left 0
    new vector(0, -100, 0), // Bottom-middle
    new vector(100, -100, 0), // Bottom-right
    new vector(100, 0, 0), // Middle-right

    new vector(100, 100, 0), // Top-right 4
    new vector(0, 100, 0), // Top-Middle (REAL CENTER TOP) 5
    new vector(-100, 100, 0), // Top-left
    new vector(-100, 0, 0), // Middle-left

    new vector(0, 0, 0), // Center 8 // CHANGE "CENTER" TO FAKE CENTER, shorter (each segment needs its OWN)

    // square dissecting me vertically
    new vector(0, -100, -100), // Bottom-front 9
    new vector(0, -100, 0), // Bottom-middle (REAL CENTER BOTTOM) 10
    new vector(0, -100, 100), // Bottom-back
    new vector(0, 0, 100), // Middle-back

    new vector(0, 100, 100), // Top-back 13
    new vector(0, 100, 0), // Top-middle
    new vector(0, 100, -100), // Top-front
    new vector(0, 0, -100), // Middle-front

    // horizontal square
    new vector(-100, 0, -100), // Left-front 17
    new vector(0, 0, -100), // Middle-front 18
    new vector(100, 0, -100), // Right-front 
    new vector(100, 0, 0), // Right-middle 20

    new vector(100, 0, 100), // Right-back 21
    new vector(0, 0, 100), // Middle-back  22
    new vector(-100, 0, 100), // Left-back 
    new vector(-100, 0, 0), // Left-middle  24

    // part-lines for horizontal square
    new vector(0, 0, -30), // Middle-front END 25
    new vector(30, 0, 0), // Right-middle END 26
    new vector(0, 0, 30), // Middle-back END 27
    new vector(-30, 0, 0), // Left-middle END 28
]


const edges = [
    // Square facing me (outside)
    [points[0], points[1]],
    [points[1], points[2]],
    [points[2], points[3]],
    [points[3], points[4]],
    [points[4], points[5]],
    [points[5], points[6]],
    [points[6], points[7]],
    [points[7], points[0]],
    // Square dissecting me vertically (outside)
    [points[9], points[10]],
    [points[10], points[11]],
    [points[11], points[12]],
    [points[12], points[13]],
    [points[13], points[14]],
    [points[14], points[15]],
    [points[15], points[16]],
    [points[16], points[9]],
    // Horizontal square (outside)
    [points[17], points[18]],
    [points[18], points[19]],
    [points[19], points[20]],
    [points[20], points[21]],
    [points[21], points[22]],
    [points[22], points[23]],
    [points[23], points[24]],
    [points[24], points[17]],
]

const inner_edges = [
    [points[8], points[10]],
    [points[8], points[12]],
    [points[8], points[14]],
    [points[8], points[18]],

    [points[8], points[20]],
    [points[8], points[22]],
    [points[8], points[24]],
]

// WILL NOT USE (the illusion doesn't work)
const partial_inner_edges = [
    [points[18], points[25]],
    [points[20], points[26]],
    [points[22], points[27]],
    [points[24], points[28]],
]


// Create the model using the points and edges defined above
const mdl = new model("cube", points, edges, inner_edges)
mdl.scale(1)  // Initial scaling of the model

// Function to update the canvas, clear the screen, and draw the model
function update() {
    let context = isVisible(canvas_desktop) ? ctx_desktop : ctx_mobile
    clearScreen(context) // Clear the screen before drawing

    // rotate and draw the model
    mdl.rotateY(5)
    mdl.rotateZ(-0.5)
    mdl.rotateX(0.4)
    mdl.draw(context)

    // Continuously update the canvas at the specified timeout interval
    setTimeout(update, timeout)
}

setTimeout(update, timeout)
