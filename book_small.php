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
    
    $title_heading_size = $page != 'single' ? 'h6' : 'h3';

?>



<div>
    <div class="book-container">
        <div class="book-details">

            <img src="../img/<?php echo $image_filename; ?>" />
        </div>
    </div>

</div>

