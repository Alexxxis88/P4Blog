<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?= $title ?></title>

        <!-- Favico -->
        <link rel="apple-touch-icon" sizes="57x57" href="./public/img/favico/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="./public/img/favico/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="./public/img/favico/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="./public/img/favico/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="./public/img/favico/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="./public/img/favico/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="./public/img/favico/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="./public/img/favico/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="./public/img/favico/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="./public/img/favico/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="./public/img/favico/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="./public/img/favico/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="./public/img/favico/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <!-- Jquerry -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

        <!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:700%7CNunito:300,600" rel="stylesheet"> 

        <!-- Bootstrap -->
        <link type="text/css" rel="stylesheet" href="./public/css/bootstrap.min.css"/>

        <!-- Font Awesome Icon -->
		<link rel="stylesheet" href="./public/css/font-awesome.min.css">
        <script src="https://kit.fontawesome.com/0e45521ec5.js"></script>

        <!-- Custom stlylesheet -->
        <link href="./public/css/style.css" rel="stylesheet" /> 

        <!--GDPR Cookies disclaimer-->
        <script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="8f33029f-67db-4439-af40-bfb1da747800" type="text/javascript" async></script>

        <!-- TinyMCE -->
        <script src="https://cdn.tiny.cloud/1/mpujcznv2qarii6l81l67tjf7m8okalduchv3ot3xy9hv0g3/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script type="text/javascript">
        tinymce.init({
        selector: '#postContent',
        language_url : 'vendor/tinymce/langs/fr_FR.js',
        language: 'fr_FR'
        });
        </script>


        <!-- Google Charts -->
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> FIXME : delete ? change l'apparence du menu. Une fois le design fini voir si le fait de l'enlever /rajouter change un truc--> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
    if(isset($checkUserRole['groupId']) && $checkUserRole['groupId'] == 1)
    {
        require('admin/menuAdmin.php');
    }
    else{
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
                            <a data-toggle="modal" data-target="#exampleModal">Contact</a> &emsp;
                            <a href="index.php?action=legalNotice">Mentions légales</a>
                        </h5>
                    </div>                    
                </div> 
            </div>
            <!-- Back to top -->
            <a href="#header" onclick="$('html,body').animate({scrollTop:0},'slow');return false;"><i class="fas fa-arrow-circle-up"></i></a>
            <!-- Copyright -->
            <div class="footer-copyright text-center py-3">
                <span>&copy;<script>document.write(new Date().getFullYear());</script> Alexis Gautier | Template en partie réalisé par <a href="https://colorlib.com" target="_blank">Colorlib</a>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </span>
            </div>    
        </footer>

<?php require('templates/front/contactView.php'); ?>
<!-- My scripts -->
<!-- <script src="./public/js/burger.js" ></script> -->
<script src="./public/js/myModal.js" ></script>

<script>
// Burger menu
$("#burgerMenu").on("click", () => { 
    $("#burgerNav").toggle();
    $(".bar1, .bar2, .bar3").toggleClass("change");
    $(".menuAdmin, .menu").css("box-shadow", "none");
});</script>

    </body>
</html>