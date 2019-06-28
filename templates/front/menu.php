<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
    </head>
    <body>
        <div class="menu">
             <a href="index.php"><i class="fas fa-home"></i></a>
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
                    } else { //else user name not knwon, hence name not displayed
                    ?>

                    <!-- Log In button -->
                    <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#logInModal">Connexion</button>

                    <!-- Sing In button -->
                    <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#singInModal">Inscription</button>
    
                    <?php
                    }
                    ?> 
            </div>    
        </div>      
    </body>
</html>
<?php require('templates/front/logInView.php'); ?>
<?php require('templates/front/singInView.php'); ?>
<?php require('templates/front/changePassView.php'); ?>

