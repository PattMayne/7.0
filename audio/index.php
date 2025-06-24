<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<?php $page = 'audio'; ?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pattmayne.com 7.0 AUDIO</title>
    <link rel="icon" href="img/guy_icon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="css/app.css">
</head>

<body>

    <div class="main-wrapper">
        <?php include '../header.php'; ?>

        <!-- The grid for ALL items. -->
        <div class="grid-x grid-padding-x">
            
            <!-- Put all albums in this column. Close after the XML-reading loop. -->
            <div class="large-4 medium-6 small-12 cell">
                <h3 class="section-title-text">MUSIC</h3>

                <!-- ALBUMS LIST (to go within the grid-x) -->

<?php

    $audio_xml;

    //  ALBUMS

    /*
        Declare global variables for data.
        We will loop through XML data, fill each variable,
        include (render) the album HTML snippet,
        then hit the next album and override all the data.
    */

$album_title;
$album_image_filename;
$album_description;
$album_link_url;
$album_link_text;

if (file_exists('../data/audio.xml')) {
        $audio_xml = simplexml_load_file('../data/audio.xml');
        $albums_xml = $audio_xml->albums;

        foreach ($albums_xml->album as $album) {
            
            // Fill the variables with book data,
            // overriding data from previous iteration.
            $album_title = $album->title;
            $album_image_filename = $album->image_filename;
            $album_description = $album->description;
            $album_link_url = $album->link_url;
            $album_link_text = $album->link_text;

            // Data is ready. Render the book snippet.
            include '../album.php';
        }

    } else {
        exit('Failed to open ../data/audio.xml.');
    }


?>
        <!-- END OF ALBUMS LIST -->
        </div>

        <div class="large-4 medium-6 small-12 cell">
                <h3 class="section-title-text">PODCASTS</h3>


<?php

    //  ALBUMS

    /*
        Declare global variables for data.
        We will loop through XML data, fill each variable,
        include (render) the album HTML snippet,
        then hit the next album and override all the data.
    */

$podcast_title;
$podcast_description;
$podcast_link_url;
$podcast_link_text;


$podcasts_xml = $audio_xml->podcasts;

foreach ($podcasts_xml->podcast as $podcast) {
    
    // Fill the variables with book data,
    // overriding data from previous iteration.
    $podcast_title = $podcast->title;
    $podcast_description = $podcast->description;
    $podcast_link_url = $podcast->link_url;
    $podcast_link_text = $podcast->link_text;

    // Data is ready. Render the book snippet.
    include '../podcast.php';
}


?>
        <!-- End of podcasts column. -->
        </div>

        <!-- End of grid (both albums AND podcasts) -->
        </div>

    <!-- END OF MAIN CONTENT BOX -->

    </div>

    <!-- BEGINNING OF FOOTER -->

    <?php include '../footer.php' ?>

    <!-- END OF FOOTER -->

    <script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/what-input.js"></script>
    <script src="js/vendor/foundation.js"></script>
</body>

</html>
