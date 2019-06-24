<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?= $title ?></title>

        <!-- Jquerry -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

        <!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:700%7CNunito:300,600" rel="stylesheet"> 

        <!-- Bootstrap -->
        <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

        <!-- Font Awesome Icon -->
		<link rel="stylesheet" href="css/font-awesome.min.css">
        <script src="https://kit.fontawesome.com/0e45521ec5.js"></script>

        <!-- Custom stlylesheet -->
        <link href="css/style.css" rel="stylesheet" /> 

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
    // FIXME: factoriser le code avec l'affichage ou non (1)des boutons modifier / supprimer sur listPostsView et PostView (2) des boutons approuver / supprimer des com sur PostView (3) l'affichage du menu admin de template.php
    if(isset($checkUserRole['groupId']) && $checkUserRole['groupId'] == 1)
    {
        require('admin/menuAdmin.php');
    }
    else{
        require('front/menu.php');
    }
    ?>
        <h1><?= $title ?></h1>
        <?= $content ?>

        <section id="footer">
            <a href="index.php?action=contact">Contact</a>
            <a href="index.php?action=about">A propos de l'auteur</a>
            <button><a href="#header">back to top</a></button>
        </section> 

    <!-- My JS scripts -->
    <script src="public/js/displayFunctions.js"></script>

    </body>
</html>