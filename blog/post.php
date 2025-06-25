<!--
    NAMING CONVENTION:
    * YYYY-MM-DD-post-title-slug.php

    Text can wrap around inline images.

-->

<?php


$slug = $_GET['slug'] ?? '2025-06-24-blog-maker';
$file_path_and_name = 'posts/' . $slug . '.php';
$article_html = file_get_contents($file_path_and_name);

$doc = new DOMDocument();
$doc->loadHTML($article_html);
libxml_clear_errors();

$article_title = $doc->getElementById('article_title')->nodeValue; // nodeValue ONLY retrieves text (clears all tags)
$article_element = $doc->getElementById('article_body'); // Get the article element itself for now
$article_body = $doc->saveHTML($article_element); // get the raw HTML of the article element for later echoing


?>

<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<?php $page = 'blog'; ?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $article_title; ?></title>
    <link rel="icon" href="../img/guy_icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../css/foundation.css">
    <link rel="stylesheet" href="../../css/app.css?ts=<?=time()?>">
</head>

<body>

    <div class="main-wrapper">
        
        <?php include '../header.php' ?>

            <div class="grid-x grid-padding-x">
                <div class="large-12 cell">
                    <h1 class="post_title"><?php echo $article_title; ?></h1>
                </div>
            </div>

            <div id="article_container">




                <!-- ARTICLE GOES HERE -->

                <?php echo $article_body; ?>





            </div>

            <div class="grid-x grid-padding-x">
                <div class="large-4 medium-6 small-12 cell">

                    <div class="callout primary">
                        <h5>More posts.</h5>

                        <?php include 'list.php'; ?>

                    </div>

                </div>
            </div>
    </div> <!-- END OF MAIN WRAPPER -->


    <!-- BEGINNING OF FOOTER -->

    <?php include '../footer.php' ?>

    <!-- END OF FOOTER -->

    <script src="../../js/vendor/jquery.js"></script>
    <script src="../../js/vendor/what-input.js"></script>
    <script src="../../js/vendor/foundation.js"></script>
</body>

</html>