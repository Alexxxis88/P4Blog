<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="public/css/style.css" rel="stylesheet" /> 
    </head>
        
    <body>
    
                <h1><?= $title ?></h1>
                <div class="adminFields">
                    <form method="post" action ="index.php"> <!-- URL à améliorer -->
                        <input type="submit" name="logout" value ="Deconnexion" /> 
                    </form>
                </div>

                <div style="text-align:center" >
        <button class="adminBtns"><a href="view/backend/publishView.php">Publier un chapitre</a></button>
        <button class="adminBtns"><a href="index.php?action=listPostsAdmin">Editer les chapitres</a></button>
        <button class="adminBtns"><a href="index.php?action=manageComments">Commentaires</a></button>
            
    </div>
        
        <?= $content ?>

        
    </body>
</html>