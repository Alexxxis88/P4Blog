<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
    <div class="menuAdmin">
        <a href="index.php"><i class="fas fa-home"></i></a>
            <div class="menuBtns">
                
                <div class="adminMenu">
                    <a class="adminMenuLink" href="index.php?action=displayPublishView"><i class="fas fa-pen-nib"></i>Publier</a>
                    <a class="adminMenuLink" href="index.php?action=listPosts"><i class="fas fa-edit"></i>Editer</a>
                    <a class="adminMenuLink" href="index.php?action=manageComments"><i class="fas fa-comments"></i>Commentaires</a>
                    <!-- <p>test < ?= $nbOfReportedComments['flag_total'] ?></p>   -->
                    <!-- NOT WORKING : display number of comments to manage  -->
                    <div class="comAlert"></div>
                    <a class="adminMenuLink" href="index.php?action=manageUsers&page=1&sortBy=10"><i class="fas fa-users"></i>Utilisateurs</a>
                    <a class="adminMenuLink" href="index.php?action=displayStatsView"><i class="fas fa-chart-line"></i>Statistiques</a>
                </div>
                <!-- Log Out button -->
                <a href="index.php?action=logOutCheck"><button type="button" class="btn btn-info ">Deconnexion</button></a>

                <!-- Change Password button -->
                <button type="button" class="btn btn-info updatePassBtn" data-toggle="modal" data-target="#updatePassModal">Changer de Password</button>

 <!-- displays an alert icon if comments to manage -->   
            </div>    
    </div> 
        </section>
    </body>
</html>
<?php require('templates/front/changePassView.php'); ?>
