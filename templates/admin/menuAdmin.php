<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
    <div class="menuAdmin">
        <a href="index.php"><i class="fas fa-home"></i></a>
            <div class="menuBtns" id="menuDesktop" >
                
                <div class="adminMenu">
                    <a class="adminMenuLink" href="index.php?action=displayPublishView"><i class="fas fa-pen-nib"></i>Publier</a>
                    <a class="adminMenuLink" href="index.php?action=listPosts"><i class="fas fa-edit"></i>Editer</a>
                    <a class="adminMenuLink" href="index.php?action=manageComments"><i class="fas fa-comments" id="comAlert"></i>Commentaires</a>
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

            <!-- Burger Menu Icon -->        
            <div id="burgerMenu">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>
                    
            <!-- Burger Menu Navigation -->         
            <nav class="navMenu"  id="burgerNav">
                <ul>
                            <li><a class="adminMenuLink" href="index.php?action=displayPublishView"><i class="fas fa-pen-nib"></i>Publier</a></li>
                            <li><a class="adminMenuLink" href="index.php?action=listPosts"><i class="fas fa-edit"></i>Editer</a></li>
                            <li><a class="adminMenuLink" href="index.php?action=manageComments"><i class="fas fa-comment-alt"></i>Commentaires</a></li>
                            <li><a class="adminMenuLink" href="index.php?action=manageUsers&page=1&sortBy=10"><i class="fas fa-users"></i>Utilisateurs</a></li>

                            <li><a class="adminMenuLink" href="index.php?action=displayStatsView"><i class="fas fa-chart-line"></i>Statistiques</a></li>
                            <!-- Log Out button -->
                            <li><a href="index.php?action=logOutCheck"><i class="fas fa-sign-out-alt"></i>Deconnexion</button></a></li>

                            <!-- Change Password button -->
                            <li><a href="" data-toggle="modal" data-target="#updatePassModal"><i class="fas fa-unlock-alt"></i>Changer de Password</a></li>
                </ul>
            </nav>

    </body>
</html>

<!-- Display comment to manage alert -->
<!-- gives an arary, the first value ( [0] ) is the result of SUM on the flag column in comments table -->
<?php if($nbOfReportedComments[0] > 0){ ?>
    <script>$('#comAlert').css("color", "red");</script>
<?php } ?>


<?php require('templates/front/changePassView.php'); ?>
