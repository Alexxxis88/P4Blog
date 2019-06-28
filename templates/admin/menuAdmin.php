
    <div class="menuAdmin">
        <a href="index.php"><span class="fas fa-home"></span></a>
            <div class="menuBtns" id="menuDesktop" >
                <div class="adminMenu">
                    <a class="adminMenuLink" href="index.php?action=displayPublishView"><span class="fas fa-pen-nib"></span>Publier</a>
                    <a class="adminMenuLink" href="index.php?action=listPosts"><span class="fas fa-edit"></span>Editer</a>
                    <a class="adminMenuLink" href="index.php?action=manageComments"><span class="fas fa-comments" id="comAlert"></span>Commentaires</a>
                    <a class="adminMenuLink" href="index.php?action=manageUsers&page=1&sortBy=10"><span class="fas fa-users"></span>Utilisateurs</a>
                    <a class="adminMenuLink" href="index.php?action=displayStatsView"><span class="fas fa-chart-line"></span>Statistiques</a>
                </div>
                
                <!-- Log Out button -->
                <a href="index.php?action=logOutCheck"><button type="button" class="btn btn-info ">Deconnexion</button></a>

                <!-- Change Password button -->
                <button type="button" class="btn btn-info updatePassBtn" data-toggle="modal" data-target="#updatePassModal">Changer de Password</button>
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
            <li><a class="adminMenuLink" href="index.php?action=displayPublishView"><span class="fas fa-pen-nib"></span>Publier</a></li>
            <li><a class="adminMenuLink" href="index.php?action=listPosts"><span class="fas fa-edit"></span>Editer</a></li>
            <li><a class="adminMenuLink" href="index.php?action=manageComments"><span class="fas fa-comment-alt"></span>Commentaires</a></li>
            <li><a class="adminMenuLink" href="index.php?action=manageUsers&page=1&sortBy=10"><span class="fas fa-users"></span>Utilisateurs</a></li>

            <li><a class="adminMenuLink" href="index.php?action=displayStatsView"><span class="fas fa-chart-line"></span>Statistiques</a></li>
            <!-- Log Out button -->
            <li><a href="index.php?action=logOutCheck"><span class="fas fa-sign-out-alt"></span>Deconnexion</button></a></li>

            <!-- Change Password button -->
            <li><a href="" data-toggle="modal" data-target="#updatePassModal"><span class="fas fa-unlock-alt"></span>Changer de Password</a></li>
        </ul>
    </nav>


<!-- Display comment to manage alert -->
<!-- gives an arary, the first value ( [0] ) is the result of SUM on the flag column in comments table -->
<?php if ($nbOfReportedComments[0] > 0) { ?>
    <script>$('#comAlert').css("color", "red");</script>
<?php } ?>

<?php require('templates/front/changePassView.php'); ?>
