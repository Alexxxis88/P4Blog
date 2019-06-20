<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="public/css/style.css" rel="stylesheet" /> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

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
        
    </head>
        
    <body>
    <!-- Back to top button anchor -->
    <div id="header"></div>
    
    <?php
    //display the right menu depending on the user role
    // FIXME: factoriser le code avec l'affichage ou non (1)des boutons modifier / supprimer sur listPostsView et PostView (2) des boutons approuver / supprimer des com sur PostView (3) l'affichage du menu admin de template.php
    // if( (isset($_COOKIE['login']) AND $_COOKIE['login'] == 'Admin') OR  (isset($_SESSION['username']) AND $_SESSION['username'] == 'Admin'))
    // {
        require('admin/menuAdmin.php');
    // }
    // else{
    //     require('front/menu.php');
    // }
    ?>
    
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