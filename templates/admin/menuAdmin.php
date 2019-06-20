<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link href="public/css/style.css" rel="stylesheet" /> 
    </head>
    <body>
        <section id="headerAdmin">
                    
        <h1><?= $title ?></h1>
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

        <div class="adminMenu">
            <button class="adminBtns"><a href="index.php?action=displayPublishView">Publier un chapitre</a></button>
            <button class="adminBtns"><a href="index.php?action=listPosts">Editer les chapitres</a></button>
            <button class="adminBtns"><a href="index.php?action=manageComments">Commentaires</a></button>
            <!-- <p>test < ?= $nbOfReportedComments['flag_total'] ?></p>   -->
            <!-- NOT WORKING : display number of comments to manage  -->
            <div class="comAlert"></div>
            <button class="adminBtns"><a href="index.php?action=manageUsers&page=1&sortBy=10">Utilisateurs</a></button>
            <button class="adminBtns"><a href="index.php?action=displayStatsView">Statistiques</a></button>
        </div>
 <!-- displays an alert icon if comments to manage -->   
 

  
        </section>
    </body>
</html>