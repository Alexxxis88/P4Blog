<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="public/css/style.css" rel="stylesheet" /> 
    </head>
        
    <body>
    <section id="header">
                <h1>Billet simple pour l'Alaska</h1>
                <div class="adminFields">
                    <form method="post" action ="index.php?action=listPostsAdmin">
                        <input type="text" name="log" placeholder="votre pseudo" required />
                        <input type="password" name="password" placeholder="votre password" required />
                        <input type="submit" name="login" value ="Connexion" /> 
                    </form>
                </div>

                <div class="adminFields">
                    <form method="post" action ="index.php?action=singIn">
                        <input type="submit" name="singIn" value ="Inscription" /> 
                    </form>
                </div>

    </section>
        
        <?= $content ?>

        <section id="footer">
            <a href="contact.php">Contact</a>
            <a href="about.php">A propos de l'auteur</a>
            <button><a href="#header">back to top</a></button>
        </section>  
    </body>
</html>