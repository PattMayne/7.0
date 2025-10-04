<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<?php $page = 'about'; ?>

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

    <div class="main-wrapper">
        
        <?php include 'header.php' ?>

        <div class="grid-x grid-padding-x">
            <!-- START OF MAIN CONTENT BOXES -->

            <div class="large-3 medium-5 small-12 cell" id="about_box">

                <div class="grid-x grid-padding-x">

                    <div class="large-12 cell">
                        <img src="img/matt-1.png" id="profile-pic">
                    </div>

                    <div class="large-12 cell">
                        <div class="callout primary">
                            <p class="bold-text">Matt Payne writes novels of comedy, satire, and adventure.</p>

                            <div class="social_button_container">
                                <a class="button social" href="https://pattmayne.substack.com" target="blank">
                                    <img id="substk_pic" src="img/substk.png">&nbsp;Substack
                                </a><a class="button social" href="https://www.youtube.com/pattmayne" target="blank">
                                    <img id="yt_pic" src="img/yt.png">&nbsp;YouTube
                                </a><a class="button social" href="https://www.twitter.com/pattmayne" target="blank">
                                    <img id="twitter_pic" src="img/twit.png">&nbsp;Twitter
                                </a>
                            </div>
                            
                            <p class="bold-text">His stories have appeared in Futurist Letters, Qwerty Magazine, Depraved Desires 2, The Society of Misfit Stories 3 (Bards and Sages), and elswhere.</p>


                        </div>

                    </div>
                </div>
            </div>

            <!-- Now we put the BOOKS in a TWO-CELL div -->

            <div class="large-9 medium-7 small-12 cell">

                <div class="grid-x grid-padding-x">
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

if (file_exists('./data/books.xml')) {
        $books_xml = simplexml_load_file('./data/books.xml');

        foreach ($books_xml->book as $book) {

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
            include 'book.php';
        }

    } else {
        exit('Failed to open ../data/books.xml.');
    }


?>
        <!-- END OF BOOKS LIST -->

                </div>

            </div>

        </div>
    </div>


    <!-- END OF MAIN CONTENT BOX -->


    <!-- BEGINNING OF FOOTER -->

    <?php include 'footer.php' ?>

    <!-- END OF FOOTER -->

    <script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/what-input.js"></script>
    <script src="js/vendor/foundation.js"></script>
</body>

</html>