$(document).foundation()

// one guy vs many guys
const one_guy = document.getElementById("one_guy")
const many_guys = document.getElementById("many_guys")
const small_one_guy = document.getElementById("small_one_guy")
const small_many_guys = document.getElementById("small_many_guys")
let show_one_guy = false

const set_guys = () => {
  if (show_one_guy) {
    one_guy.classList.remove("hidden")
    many_guys.classList.add("hidden")
    small_one_guy.classList.remove("hidden")
    small_many_guys.classList.add("hidden")
  } else {
    one_guy.classList.add("hidden")
    many_guys.classList.remove("hidden")
    small_one_guy.classList.add("hidden")
    small_many_guys.classList.remove("hidden")
  }
}


const switch_show_guys = () => {
  show_one_guy = !show_one_guy
  set_guys()
}

one_guy.addEventListener('click', switch_show_guys)
many_guys.addEventListener('click', switch_show_guys)
small_one_guy.addEventListener('click', switch_show_guys)
small_many_guys.addEventListener('click', switch_show_guys)

const container = document.getElementById("front_books_grid")
let book_items = Array.from(container.children)
const getNumCols = width =>
  width >= 1024 ? 4 :
  width >= 640 ? 3 :
  width >= 500 ? 4 :
  width >= 420 ? 3 : 2

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
    col.className = "front_books_column"
    columns.push(col)
    container.appendChild(col)
  }

  const max_books = book_items.length

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