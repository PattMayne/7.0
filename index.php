<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<?php
    $page = 'about';
    include 'helpers.php';
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pattmayne.com 7.0</title>
    <link rel="icon" href="img/guy_icon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="css/app.css?ts=<?=time()?>">
</head>

<body>

    <div class="main-wrapper"> <!-- main warapper -->
        
        <?php include 'header.php' ?>

        <div class="grid-x grid-padding-x"> <!-- 2 -->
            <!-- START OF MAIN CONTENT BOXES -->

            <div class="large-3 medium-5 small-12 cell" id="about_box"> 

                <div class="grid-x grid-padding-x">

                    <div class="large-12 cell">
                        <img src="img/matt-1.png" id="profile-pic">
                    </div>

                    <div class="large-12 cell">
                        <div class="callout primary">
                            
                            <p class="bold-text">Matt Payne writes novels of comedy, satire, and adventure.</p>

                            <p>His stories have appeared in Futurist Letters, Qwerty Magazine, Depraved Desires 2, The Society of Misfit Stories 3 (Bards and Sages), and elswhere.</p>

                            <div class="social_button_container">
                                <a class="button social" href="https://pattmayne.substack.com" target="blank">
                                    &nbsp;&nbsp;<img id="substk_pic" src="img/substk.png">
                                </a><a class="button social" href="https://www.youtube.com/pattmayne" target="blank">
                                    &nbsp;&nbsp;<img id="yt_pic" src="img/yt.png">
                                </a><a class="button social" href="https://www.twitter.com/pattmayne" target="blank">
                                    &nbsp;&nbsp;<img id="twitter_pic" src="img/twit.png">&nbsp;&nbsp;
                                </a>
                            </div>
                            

                        </div>

                    </div>
                </div>
            </div>

            <!-- Now we put the BOOKS in a TWO-CELL div -->

            <div class="large-9 medium-7 small-12 cell"> <!-- 3 -->

                <div class="grid-x grid-padding-x"> <!-- 4 -->
                    <div class="large-12 cell">
                        <h3 class="section-title-text show-for-small-only">Books</h3>
                    </div>


        <!-- BOOKS LIST (to go within the grid-x) -->


<?php

/*
    Declare global variables for book data.
    We will loop through XML data, fill each variable,
    include (render) the book HTML snippet,
    then hit the next book and override all the data.
*/

$title;
$image_filename;
$description;
$links;
$genres;

if (file_exists('./data/books.xml')) {
    $books_xml = simplexml_load_file('./data/books.xml');
    $max_books_to_display = 4;
    $books_displayed = 0;

    foreach ($books_xml->book as $book) {

        // Fill the variables with book data,
        // overriding data from previous iteration.
        $title = $book->title;
        $image_filename = $book->image_filename;
        $description = $book->description;
        $raw_links = $book->links;
        $genres = $book->genres;
        $links = array();
        foreach ($raw_links->link as $link) {
            $links[] = array(
                'text' => $link->text,
                'url' => $link->url
            );
        }

        // Data is ready. Render the book snippet.
        include 'book.php';

        // Limit the number of books on the front page
        $books_displayed += 1;

        if ($books_displayed >= 4) {
            break;
        }
    }

} else {
    exit('Failed to open ../data/books.xml.');
}


?>
        <!-- END OF BOOKS LIST -->
                    <div class="large-12 cell" id="more_books_link_container">
                        <a href="/books" class="more_books_link"><h3 id="more_books">MORE BOOKS</h3></a>
                    </div>

                </div> <!-- end of 4 -->
            </div> <!-- end of 3 -->
        </div> <!-- end of 2 -->
    </div> <!-- end of main wrapper -->


    <!-- END OF MAIN CONTENT BOX -->


    <!-- BEGINNING OF FOOTER -->

    <?php include 'footer.php' ?>

    <!-- END OF FOOTER -->

    <script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/what-input.js"></script>
    <script src="js/vendor/foundation.js"></script>
</body>

</html>