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



<div class="large-<?php echo $book_callout_sizes["large"] ?> medium-<?php echo $book_callout_sizes["medium"] ?> small-<?php echo $book_callout_sizes["small"] ?> cell">
    <div class="callout book_callout">
        <div class="book-container">
            <div class="book-details">

                <<?php echo $title_heading_size; ?> class="book-title <?php if ($page == 'single') {echo ' section-title-text';}  ?>" >
                    <?php echo $title; ?>
                </<?php echo $title_heading_size; ?>>

                <img src="../img/<?php echo $image_filename; ?>" class="book-img-wrap" />
                <p class="book-desc"><?php echo $description; ?></p>
            </div>
        </div>

        <?php

            // Show the links.
            foreach ($links as $link) {
                echo '<a class="button CTA book-CTA" href="';
                echo $link['url'];
                echo '" target="blank">';
                echo $link['text'];
                echo '</a>';
            }
        ?>

    </div>
</div>

