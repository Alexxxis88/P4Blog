<?php $title = 'Gestion des utilisateurs'; ?>

<?php ob_start(); ?>

<div class="container">
<h2>Gestion des utilisateurs</h2>

            <?php require('templates/pagination.php'); ?>
            <p>Afficher par 
            <a href="index.php?action=manageUsers&page=<?= $_GET['page'] ?>&sortBy=10"><button class="btn btn-info btn-sm"><strong>10</strong></button></a> 
            <a href="index.php?action=manageUsers&page=<?= $_GET['page'] ?>&sortBy=20"><button class="btn btn-info btn-sm"><strong>20</strong></button></a> 
            <a href="index.php?action=manageUsers&page=<?= $_GET['page'] ?>&sortBy=99999999999999999999"><button class="btn btn-info btn-sm"><strong>Tous</strong></button></a> 


            <form action="index.php?action=manageAllSelectedUsers" method="post"> 
                    <input type="checkbox" id="checkAllUsers" >
                    <label for="checkAllUsers"> Tout sélectionner / désélectionner </label>
                    <input class="btn btn-danger btn-sm" type="submit" name="deleteSelectedUsers[]" value="Supprimer" onclick="return confirm('Etes-vous sûr?')">


            <?php
                //This array is used to stock every users'Ids
                $arrayUsersIDs = array();
            
            if (!empty($allUsers)) { //needed otherwise gives an error on the usersView.php when no users in DB
                for ($i = 0 ; $i < sizeof($allUsers) ; $i++) {
                    $userid = $allUsers[$i]->id();
                    $username = $allUsers[$i]->username();
                    $email = $allUsers[$i]->email();
                    $registrationDate = $allUsers[$i]->modRegistrationDate();
                    $group = $allUsers[$i]->groupId(); ?>
                    <div class="usersDisplay">
                        <p class="userListHeader"><input type="checkbox" id="userID" name="selectUsers[]" value="<?= $userid?>" ><strong><?= htmlspecialchars($username) ?></strong>&emsp;-&emsp;<?= $email ?>&emsp;-&emsp;enregistré le <strong> <?= $registrationDate ?></strong></p> 

                            <div class="roleAndDelete">
                                <p ><a class="deleteUserLink" href="index.php?action=deleteUser&amp;userID=<?= $userid ?>" onclick="return confirm('Etes-vous sûr?')"><span class="fas fa-user-times"></span>Supprimer</a>    
                                <p><strong>Role :</strong> 
                                <?php
                                if ($group == 0) {
                                    echo  'Utilisateur'; ?>
                                        <button class="btn btn-warning btn-sm"><a href="index.php?action=updateRole&amp;userID=<?= $userid ?>&amp;role=1" onclick="return confirm('Etes-vous sûr?')">Passer en Admin</a></button>
                                        <?php
                                } elseif ($group == 1) {
                                    echo '<strong style="color:red">Admin</strong>'; ?>
                                    <button class="btn btn-warning btn-sm"><a href="index.php?action=updateRole&amp;userID=<?= $userid ?>&amp;role=0" onclick="return confirm('Etes-vous sûr?')">Passer en Utilisateur</a></button>
                                    <?php
                                } ?></p>
                            </div>           
                    </div>
                <?php
                    
                    //pour chaque utilisateur, je rajoute son id dans le tableau $arrayUsersIDs
                    array_push($arrayUsersIDs, $userid);
                }
            }
                ?>    
            </form>
</div>

    


<?php $content = ob_get_clean(); ?>

<?php require('templates/base.php'); ?>