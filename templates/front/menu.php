<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="public/css/style.css" rel="stylesheet" /> 
    </head>
    <body>

        <?php //if there is cookies or session information, they are used to display user name
        if(isset($_COOKIE['login']) OR isset($_SESSION['id']))
        { 
            if(isset($_COOKIE['login']))
            {
                $username = $_COOKIE['login'];
                $logedAs = 'COOKIE'; //FIXME : delete me
            }
            elseif(isset($_SESSION['username']))
            {
                $username = $_SESSION['username'];
                $logedAs = 'SESSION'; //FIXME : delete me
            }
        ?>
           <p><strong style="color:red"><?= $logedAs ?></strong>  <!-- FIXME : delete me -->
            Vous êtes connecté en tant que <strong><?= htmlspecialchars($username) ?></strong> </p>
                
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
    

        <!-- Sing In button -->
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