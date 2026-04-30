$(document).foundation()

// one guy vs many guys
const one_guy = document.getElementById("one_guy")
const many_guys = document.getElementById("many_guys")
let show_one_guy = false

const set_guys = () => {
  if (show_one_guy) {
    one_guy.classList.remove("hidden")
    many_guys.classList.add("hidden")
  } else {
    one_guy.classList.add("hidden")
    many_guys.classList.remove("hidden")
  }
}


const switch_show_guys = () => {
  show_one_guy = !show_one_guy
  set_guys()
}

one_guy.addEventListener('click', switch_show_guys)
many_guys.addEventListener('click', switch_show_guys)


const container = document.getElementById("front_books_grid")
let book_items = Array.from(container.children)
const getNumCols = width =>
  width >= 1600 ? 3 :
  width >= 1024 ? 2 : 1

const more_books_link_container = document.getElementById("more_books_link_container_container")
const more_books_link = Array.from(more_books_link_container.children)[0]

const layoutGrid =() => {
  const width = document.documentElement.clientWidth
  const num_cols = getNumCols(width)

  // Remove old columns
  container.innerHTML = ''
  more_books_link_container.innerHTML = ""

  // Create column containers
  const columns = []
  for (let i = 0; i < num_cols; i++) {
    const col = document.createElement("div")
    col.className = "column"
    columns.push(col)
    container.appendChild(col)
  }

  const max_books = width >= 1600 ? 6 : 4

  // Distribute items
  book_items.forEach((item, index) => {
    index < max_books && columns[index % num_cols].appendChild(item)
  })

  // add "more books" to the final column
  columns[columns.length - 1].appendChild(more_books_link)
}

// Initial layout
layoutGrid()

// Relayout on resize
window.addEventListener('resize', layoutGrid)