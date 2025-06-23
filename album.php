<!-- We trust that the global variables are filled and valid in the calling script. -->

<div class="callout book_callout">
    <div class="music-container">
        <img src="img/<?php echo $album_image_filename;?>" class="music-img" />
        <div class="music-details">
            <h6><?php echo $album_title;?></h6>
            <p><?php echo $album_description;?></p>
            <a class="button CTA music-CTA-lg"
                href="<?php echo $album_link_url;?>" target="blank">
                <?php echo $album_link_text;?>
            </a>
        </div>
    </div>

    <a class="button CTA music-CTA-sm"
        href="<?php echo $album_link_url;?>" target="blank">
        <?php echo $album_link_text;?>
    </a>
</div>
