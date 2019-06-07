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
    
                <h1><?= $title ?></h1>
                <div class="adminFields">
                    <form method="post" action ="index.php"> <!-- URL à améliorer -->
                        <input type="submit" name="logout" value ="Deconnexion" /> 
                    </form>
                </div>

                <div style="text-align:center" >
        <button class="adminBtns"><a href="index.php?action=displayPublishView">Publier un chapitre</a></button>
        <button class="adminBtns"><a href="index.php?action=listPostsAdmin">Editer les chapitres</a></button>
        <button class="adminBtns"><a href="index.php?action=manageComments">Commentaires</a></button>
        <!-- <p>test < ?= $nbOfReportedComments['flag_total'] ?></p>  NOT WORKING : display number of comments to manage --> 
        
    </div>
        
        <?= $content ?>

        
    </body>
</html>
