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
        
        <?= $content ?>

        
    </body>
</html>