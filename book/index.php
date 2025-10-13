<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<?php

    $page = 'single';
    include '../helpers.php';

    if (!isset($_GET['slug']) || $_GET['slug'] == '') {
        // slug is either not set, or is set but empty
        echo("no slug at all");
        header("Location: /");
        exit;
    }

    // make sure there's a slug, and that it exists in the XML, else redirect back to /books
    $slug = $_GET['slug'];    
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOOKS - pattmayne.com</title>
    <link rel="icon" href="../img/guy_icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/foundation.css">
    <link rel="stylesheet" href="../css/app.css?ts=<?=time()?>">
</head>

<body>

    <div class="main-wrapper">
        <?php include '../header.php'; ?>

        <div class="grid-x grid-padding-x">
            <div class="large-12 cell">
            </div>

        <!-- BOOKS LIST (to go within the grid-x) -->


<?php

/*
    Declare global variables for book data.
    We will loop through XML data, fill each variable,
    include (render) the book HTML snippet,
    then hit the next book and override all the data.

    REDO THIS SINGLE PAGE to be a GENERIC single page which takes a book TITLE as a querystring
*/

$title;
$image_filename;
$description;
$links;

if (file_exists('../data/books.xml')) {
    $books_xml = simplexml_load_file('../data/books.xml');
    $found_book = false;

    foreach ($books_xml->book as $book) {

        if($book->slug != $slug) {
            continue;
        }

        $found_book = true;
        
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

    if(!$found_book) {
        // No book matched the slug
        header("Location: /");
        exit;
    }

} else {
    exit('Failed to open ../data/books.xml.');
}


?>
        <!-- END OF BOOKS LIST -->

        </div>

    <!-- END OF MAIN CONTENT BOX -->

    </div>

    <!-- BEGINNING OF FOOTER -->

    <?php include '../footer.php' ?>

    <!-- END OF FOOTER -->

    <script src="../js/vendor/jquery.js"></script>
    <script src="../js/vendor/what-input.js"></script>
    <script src="../js/vendor/foundation.js"></script>
</body>

</html>