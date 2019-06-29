<div class="menu">
    <a href="index.php"><span class="fas fa-home"></span></a>
    <div class="menuBtns">
        <?php //if there is cookies or session information, they are used to display user name
        if (isset($_COOKIE['login']) or isset($_SESSION['id'])) {
            if (isset($_COOKIE['login'])) {
                $username = $_COOKIE['login'];
            } elseif (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
            } ?>
            <p class="helloText">Bonjour <strong><?= htmlspecialchars($username) ?></strong> </p>

            <!-- Log Out button -->
            <a href="index.php?action=logOutCheck"><button type="button" class="btn btn-info ">Deconnexion</button></a>

            <!-- Change Password button -->
            <button type="button" class="btn btn-info updatePassBtn " data-toggle="modal" data-target="#updatePassModal">Changer de Password</button>
        <?php
        } else {?>
            <!-- Log In button -->
            <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#logInModal">Connexion</button>

            <!-- Sing In button -->
            <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#singInModal">Inscription</button>
        <?php
        }
        ?>
    </div>
</div>
<?php
require('templates/front/logInView.php');
require('templates/front/singInView.php');
require('templates/front/changePassView.php');
?>

