<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="public/css/style.css" rel="stylesheet" /> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

        <!-- TinyMCE -->
        <script src="https://cdn.tiny.cloud/1/mpujcznv2qarii6l81l67tjf7m8okalduchv3ot3xy9hv0g3/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script type="text/javascript">
        tinymce.init({
        selector: '#postContent'
        });
        </script>
    </head>
        
    <body>
    <!-- Back to top button anchor -->
    <div id="header"></div>
    <?php require('view/backend/menuAdmin.php') ?>  
        
        <?= $content ?>

        <section id="footer">
            <a href="index.php?action=contact">Contact</a>
            <a href="index.php?action=about">A propos de l'auteur</a>
            <button><a href="#header">back to top</a></button>
        </section>         
    </body>
</html>
