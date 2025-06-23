<!-- We trust that the global variables are filled and valid in the calling script. -->

<div class="large-4 medium-6 small-12 cell">
    <div class="callout book_callout">
        <div class="book-container">
            <img src="img/<?php echo $image_filename;?>" class="book-img" />
            <div class="book-details">
                <h6 class="book-title"><?php echo $title;?></h6>
                <p><?php echo $description;?></p>
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

