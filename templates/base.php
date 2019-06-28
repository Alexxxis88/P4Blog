<!DOCTYPE html>
    <html lang="fr">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Un Billet Simple pour l'Alaska</title>

            <!-- Favico -->
            <link rel="icon" href="./public/img/favicon.ico" type="image/x-icon">

            <!-- Metatags for social media -->
            <meta name="description" content="Bienvenue sur le blog de Jean Forteroche!" />

            <!-- Twitter Card data -->
            <meta name="twitter:card" content="summary">
            <meta name="twitter:site" content="@publisher_handle">
            <meta name="twitter:title" content="Un billet simple pour l'Alaska - Jean Forteroche">
            <meta name="twitter:description" content="Découvrez Un billet simple pour l'Alaska, le nouveau roman de Jean Forteroche">
            <meta name="twitter:creator" content="@author_handle">
            <!-- Twitter Summary card images must be at least 200x200px -->
            <meta name="twitter:image" content="http://ocr.straightandalert.com/jean-forteroche/public/img/home-picture.jpg">

            <!-- Open Graph data -->
            <meta property="og:title" content="Un billet simple pour l'Alaska - Jean Forteroche" />
            <meta property="og:type" content="website" />
            <meta property="og:url" content="http://ocr.straightandalert.com/jean-forteroche/index.php" />
            <meta property="og:image" content="http://ocr.straightandalert.com/jean-forteroche/public/img/home-picture.jpg" />
            <meta property="og:description" content="Découvrez Un billet simple pour l'Alaska, le nouveau roman de Jean Forteroche" />
            <meta property="og:site_name" content="Un billet simple pour l'Alaska" />

            <!-- Jquerry -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

            <!-- Google font -->
            <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:700%7CNunito:300,600" rel="stylesheet">

            <!-- Google reCaptcha -->
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>

            <!-- Bootstrap -->
                <!-- Latest compiled and minified CSS -->
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

                <!-- Optional theme -->
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

                <!-- Latest compiled and minified JavaScript -->
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

            <!-- Font Awesome Icon -->
            <script src="https://kit.fontawesome.com/0e45521ec5.js"></script>

            <!-- Custom stlylesheet -->
            <link href="./public/css/style.min.css" rel="stylesheet" />

            <!--GDPR Cookies disclaimer-->
            <script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="56b79623-bfec-4453-85a4-74b56c492891" async></script>

            <!-- TinyMCE -->
            <script src="https://cdn.tiny.cloud/1/mpujcznv2qarii6l81l67tjf7m8okalduchv3ot3xy9hv0g3/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
            <script>
            tinymce.init({
            selector: '#postContent',
            language_url : 'vendor/tinymce/langs/fr_FR.js',
            language: 'fr_FR'
            });
            </script>

            <!-- Google Charts -->
            <script src="https://www.google.com/jsapi"></script>
            <script src="https://www.gstatic.com/charts/loader.js"></script>

            <?php require('templates/admin/statsCharts.php'); ?>

            <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->

            </head>

    <body>
        <!-- Back to top button anchor -->
        <div id="header"></div>

        <?php
        //display the right menu depending on the user role
        if (isset($checkUserRole['groupId']) && $checkUserRole['groupId'] == 1) {
            require('admin/menuAdmin.php');
        } else {
            require('front/menu.php');
        }
        ?>
            <?= $content ?>

            <!-- Footer -->
            <footer id="footer">
                <div class="container">
                    <!-- Grid row-->
                    <div class="row text-center d-flex justify-content-center">
                        <div class="col-md-12 ">
                            <h5 class="text-uppercase font-weight-bold">
                                <a href="index.php?action=about">A propos</a> &emsp; 
                                <a data-toggle="modal" data-target="#contactModal">Contact</a> &emsp;
                                <a href="index.php?action=legalNotice">Mentions légales</a>
                            </h5>
                        </div>                    
                    </div> 
                </div>
                <!-- Back to top -->
                <a href="#header" onclick="$('html,body').animate({scrollTop:0},'slow');return false;"><span class="fas fa-arrow-circle-up"></span></a>
                <!-- Copyright -->
                <div class="footer-copyright text-center py-3">
                    <span>&copy;<script>document.write(new Date().getFullYear());</script> Alexis Gautier | Template en partie réalisé par <a href="https://colorlib.com" target="_blank">Colorlib</a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </span>
                </div>    
            </footer>

        <?php require('templates/front/contactView.php'); ?>

        <!-- My scripts -->
        <script src="./public/js/main.min.js"></script>

    </body>
</html>