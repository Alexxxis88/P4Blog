<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="public/css/style.css" rel="stylesheet" /> 

        <!--GDPR Cookies disclaimer-->
        <script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="8f33029f-67db-4439-af40-bfb1da747800" type="text/javascript" async></script>
    </head>
        
    <body>
    <?php require('view/frontend/menu.php') ?>  
        <?= $content ?>

        <section id="footer">
            <a href="contact.php">Contact</a>
            <a href="about.php">A propos de l'auteur</a>
            <button><a href="#header">back to top</a></button>
        </section>  
    </body>
</html>