<?php


foreach ($books_xml->book as $book) {

    // get this early for possible sorting
    $genres = $book->genres;

    // CAN BE SIMPLIFIED

    // Skip if we HAVE a genre and this is NOT that genre (first iteration)
    if ($to_print == ToPrint::Genre) {
        $genre_list = explode(",", $genres);
        $has_genre = false;
        foreach ($genre_list as $genre) {
            if ($genre == $prime_genre) {
                $has_genre = true;
            }
        }

        if (!$has_genre) {
            continue;
        }
    }

    // Skip if we HAVE a genre and this IS that genre (2nd iteration)
    if ($to_print == ToPrint::NonGenre) {
        $genre_list = explode(",", $genres);
        $has_genre = false;
        foreach ($genre_list as $genre) {
            if ($genre == $prime_genre) {
                $has_genre = true;
            }
        }

        if ($has_genre) {
            continue;
        }
    }
    
    // Fill the variables with book data,
    // overriding data from previous iteration.
    $title = $book->title;
    $image_filename = $book->image_filename;
    $description = $book->description;
    $raw_links = $book->links;
    $links = array();
    foreach ($raw_links->link as $link) {
        $links[] = array(
            'text' => $link->text,
            'url' => $link->url
        );
    }

    // Data is ready. Render the book snippet.
    include '../book.php';
}

?>