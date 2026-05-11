<!-- Put this inside main-wrapper class div, which is just inside body tag -->

<?php
    // function to check which page we're on, so we can highlight that option in the menu.
    function isActive($pageOption) {
        global $page;
        return $page == $pageOption;
    }

?>

<div class="grid-x grid-padding-x">

    <div class="large-12 cell">
        <div id="title_box">
            <h2 id="the_title"><span id="title_left">The</span> Matt Payne <span id="title_right">Web Page</span></h2>
        </div>
        <div id="menu_box">
            <a href="/" class="button menu-button <?php echo isActive('about') ? 'active' : ''; ?>">ABOUT</a>
            <a href="/books" class="button menu-button <?php echo (isActive('books') || isActive('single')) ? 'active' : ''; ?>">BOOKS</a>
            <a href="/audio" class="button menu-button <?php echo isActive('audio') ? 'active' : ''; ?>">AUDIO</a>
            <a href="https://blog.pattmayne.com" class="button menu-button <?php echo isActive('blog') ? 'active' : ''; ?>">BLOG</a>
            <div class="hr hide-for-small-only">&nbsp;</div>
        </div>
    </div>

</div>
