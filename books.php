<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pattmayne.com 7.0 BOOKS</title>
    <link rel="icon" href="img/guy_icon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="css/app.css">
</head>

<body>

    <div class="main-wrapper">
    <?php include '../header.php'; ?>


<?php

    if (file_exists('data/books.xml')) {
        $xml = simplexml_load_file('data/books.xml');
    
        print_r($xml);
        echo $xml;
    } else {
        exit('Failed to open ../data/books.xml.');
    }

    echo 'hello';

    //include '../index.php';

?>

    <!-- END OF MAIN CONTENT BOX -->


    <!-- BEGINNING OF FOOTER -->

    <?php include 'footer.php' ?>

    <!-- END OF FOOTER -->

    <script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/what-input.js"></script>
    <script src="js/vendor/foundation.js"></script>
    <script src="js/app4.js"></script>
</body>

</html>