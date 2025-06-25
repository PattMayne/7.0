<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<?php $page = 'blog'; ?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLOG - pattmayne.com</title>
    <link rel="icon" href="../img/guy_icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/foundation.css">
    <link rel="stylesheet" href="../css/app.css?ts=<?=time()?>">
</head>

<body>

    <div class="main-wrapper">
        
        <?php include '../header.php' ?>
    <div class="grid-x grid-padding-x">
        <div class="large-12 cell">
            <h3 class="section-title-text hide-for-small-only">POSTS</h3>
        </div>

    </div>
        
    <div id="posts_list_box">
        <h4 class="section-title-text show-for-small-only">POSTS</h4>
        <?php include 'list.php'; ?>
    </div>

    </div>


    <!-- END OF MAIN CONTENT BOX -->


    <!-- BEGINNING OF FOOTER -->

    <?php include '../footer.php' ?>

    <!-- END OF FOOTER -->

    <script src="../js/vendor/jquery.js"></script>
    <script src="../js/vendor/what-input.js"></script>
    <script src="../js/vendor/foundation.js"></script>
</body>

</html>