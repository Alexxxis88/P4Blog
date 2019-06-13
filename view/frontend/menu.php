<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="public/css/style.css" rel="stylesheet" /> 
    </head>
    <body>
        <h1>Billet simple pour l'Alaska</h1>

        <!-- FIXME: factoriser le code de display du bouton Deconnexion pour SESSION ou COOKIE -->
        <?php //if there is cookies, they are used to display user name
        if(isset($_COOKIE['login']) AND !empty($_COOKIE['login']) AND isset($_COOKIE['hash_pass']) AND !empty($_COOKIE['hash_pass'])){
        ?>
        <p><strong style="color:red">COOKIE</strong> Vous êtes connecté en tant que <strong><?= $_COOKIE['login'] ?></strong></p>
            
        <!-- Log Out button -->
        <div class="adminFields">
            <form method="post" action ="index.php?action=logOutCheck">
                <input type="submit" name="logOut" value ="Deconnexion" /> 
            </form>
        </div>    

        <!-- Change Password button -->
        <div class="adminFields">
                <form method="post" action ="index.php?action=changePasswordView">
                    <input type="submit" name="changePass" value ="Changer de Password" /> 
                </form>
        </div>

        
        
        <?php
        } //else if there is session information, it's used to display user name
        elseif(isset($_SESSION['id']) AND isset($_SESSION['username'])){
            ?>
            <p><strong style="color:red">SESSION</strong> Vous êtes connecté en tant que <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></p>
                
            <!-- Log Out button -->
            <div class="adminFields">
                <form method="post" action ="index.php?action=logOutCheck">
                    <input type="submit" name="logOut" value ="Deconnexion" /> 
                </form>
            </div> 
            
                <!-- Change Password button -->
            <div class="adminFields">
                <form method="post" action ="index.php?action=changePasswordView">
                    <input type="submit" name="changePass" value ="Changer de Password" /> 
                </form>
            </div>
            
            <?php
            }
            //FIXME : factoriser le code ci dessus

        else{ //else user name not knwon, hence name not displayed
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
    </body>
</html>