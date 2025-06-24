<!-- Put this inside main-wrapper class div, which is just inside body tag -->

<?php
    // function to check which page we're on, so we can highlight that option in the menu.
    function isActive($pageOption) {
        global $page;
        return $page == $pageOption;
    }

?>

<div class="grid-x grid-padding-x">

    <div class="large-12 cell" id="title_box">
        <h3 id="the_title">THE MATT PAYNE WEB PAGE</h3>
    </div>

    <div class="large-12 cell">
        <a href="/" class="button menu-button <?php echo isActive('about') ? 'active' : ''; ?>">ABOUT</a>
        <a href="/books" class="button menu-button <?php echo isActive('books') ? 'active' : ''; ?>">BOOKS</a>
        <a href="/audio" class="button menu-button <?php echo isActive('audio') ? 'active' : ''; ?>">AUDIO</a>
        <a href="/blog" class="button menu-button <?php echo isActive('blog') ? 'active' : ''; ?>">BLOG</a>
        <div class="hr">&nbsp;</div>
    </div>

</div>
