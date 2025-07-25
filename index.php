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

            <div class="large-4 medium-6 small-12 cell" id="about_box">

                <div class="grid-x grid-padding-x">

                    <div class="large-12 cell">
                        <img src="img/matt-1.png" id="profile-pic">
                    </div>

                    <div class="large-12 cell">
                        <div class="callout primary">
                            <p class="bold-text">Matt Payne is a Canadian author, web developer, and podcaster. He is the greatest Canadian novelist of all time. He has complete faith in himself.</p>

                            <div class="social_button_container">
                                <a class="button social" href="https://pattmayne.substack.com" target="blank">
                                    <img id="substk_pic" src="img/substk.png">&nbsp;Substack
                                </a><a class="button social" href="https://www.youtube.com/pattmayne" target="blank">
                                    <img id="yt_pic" src="img/yt.png">&nbsp;YouTube
                                </a><a class="button social" href="https://www.twitter.com/pattmayne" target="blank">
                                    <img id="twitter_pic" src="img/twit.png">&nbsp;Twitter
                                </a>
                            </div>
                            


                        </div>

                    </div>
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