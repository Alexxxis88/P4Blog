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

                    <?php 
                    if(isset($_SESSION['id']) AND isset($_SESSION['username'])){
                    ?>
                    <p>Vous êtes connecté en tant que <strong><?= $_SESSION['username'] ?></strong></p>

                    <!-- Log Out button -->
                    <div class="adminFields">
                        <form method="post" action ="index.php?action=logOutCheck">
                            <input type="submit" name="logOut" value ="Deconnexion" /> 
                        </form>
                    </div>    
                    
                    <?php
                    }
                    else{
                    ?>

                    <!-- Log In button -->
                    <div class="adminFields">
                        <form method="post" action ="index.php?action=logInCheck">
                            <label for="username">Pseudo</label>
                            <input type="text" id="username" name="username"  placeholder="votre pseudo" required />
                            
                            <label for="pass">Password</label>
                            <input type="password" id="pass" name="pass" placeholder="votre password" required />
                            
                            <label for="autoLogIn">Connexion automatique</label>
                            <input type="checkbox" id="autoLogIn" name="autoLogIn" />

                            <input type="submit" name="login" value ="Connexion" /> 
                        </form>
                    </div>
                

                    <!-- Sin In button -->
                    <!-- FIXME when bootstrap implementd, display in a modal box rather than a page / view -->
                    <div class="adminFields">
                        <form method="post" action ="index.php?action=singIn">
                            <input type="submit" name="singIn" value ="Inscription" /> 
                        </form>
                    </div>
                    <?php
                    }
                    ?>    
        </section>
    </body>
</html>