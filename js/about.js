$(document).foundation()

const container = document.getElementById("front_books_grid")
let book_items = Array.from(container.children)
const getNumCols = width => width >= 1024 ? 2 : 1


const layoutGrid =() => {
  const num_cols = getNumCols(document.documentElement.clientWidth)

  // Remove old columns
  container.innerHTML = ''

  // Create column containers
  const columns = []
  for (let i = 0; i < num_cols; i++) {
    const col = document.createElement("div")
    col.className = "column"
    columns.push(col)
    container.appendChild(col)
  }

  // Distribute items
  book_items.forEach((item, index) => columns[index % num_cols].appendChild(item))
}

// Initial layout
layoutGrid()

// Relayout on resize
window.addEventListener('resize', layoutGrid)