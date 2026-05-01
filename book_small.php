<!-- We trust that the global variables are filled and valid in the calling script. -->
<?php

    // see if $bookSizes is already set

    $book_callout_sizes = ($page == 'about') ? [
        "small" => 12,
        "medium" => 12,
        "large" => 6
    ] : (($page == 'single') ? [
        "small" => 12,
        "medium" => 6,
        "large" => 6
    ] : [
        "small" => 12,
        "medium" => 6,
        "large" => 4
    ]);
    
?>



<div>
    <div class="book-container">
        <div class="front-book-details">
            <a href="/book/?slug=<?php echo $slug; ?>">
                <img src="../img/<?php echo $image_filename; ?>" />
                <div class="overlay">
                    <!-- overlay content, e.g.: -->
                    <div>
                        <h6 class="front-book-title orange_text" >
                            <?php echo $title; ?>
                        </h6>

                        <div class="front_genres_box">
                            <?php
                                $genre_list = explode(",", $genres);
                                // Show the links.
                                foreach ($genre_list as $genre) {
                                    echo '<span class="front_genre_span">';
                                    echo $genre;
                                    echo '</span>';
                                }
                            ?>
                        </div>

                    </div>
                </div>
            </a>
        </div>
    </div>

</div>

