<?php $title = 'Gestion des utilisateurs'; ?>

<?php ob_start(); ?>
 

<h2>Utilisateurs</h2>
<form action="index.php?action=manageAllSelectedUsers" method="post"> 
        <input type="checkbox" id="checkAllUsers" >
        <label for="checkAllUsers"> Tout sélectionner / désélectionner </label>
        <input type="submit" name="deleteSelectedUsers[]" value="Supprimer" onclick="return confirm('Etes-vous sûr?')">


<?php
    //je déclare un tableau vide qui va me servir a stocker tous les ids des utilisateurs
    $arrayUsersIDs = array();
    for ($i = 0 ; $i < sizeof($allUsers) ; $i++)
    {
    ?>
        <div class="usersDisplay">
                <p class=""><strong><?= htmlspecialchars($allUsers[$i]->username()) ?></strong> <?= $allUsers[$i]->email() ?>
                        enregistré le <strong> <?= $allUsers[$i]->modRegistrationDate() ?></strong> 
                
                        
                        <!-- FIXME : a supprimer car je ne peux me co en admin qu'avec le log in 'Admin' et pas en fonction du group_id -->
                        <!-- <p>role : 
                        <?php 
                        if($allUsers[$i]->groupId() == 0)
                            { 
                                echo  'Utilisateur';
                                ?>
                                <button class="adminBtns"><a href="index.php?action=updateRole&amp;userID=<?= $allUsers[$i]->id() ?>&amp;role=1" onclick="return confirm('Etes-vous sûr?')">Passer en Admin</a></button>
                                <?php
                                
                            }
                        elseif($allUsers[$i]->groupId() == 1)
                        { 
                            echo '<strong>Admin</strong>';
                            ?>
                            <button class="adminBtns"><a href="index.php?action=updateRole&amp;userID=<?= $allUsers[$i]->id() ?>&amp;role=0" onclick="return confirm('Etes-vous sûr?')">Passer en Utilisateur</a></button>
                            <?php
                        }      
                        ?></p> -->

                
                <input type="checkbox" id="userID" name="selectUsers[]" value="<?= $allUsers[$i]->id()?>" >

                <button class="adminBtns"><a href="index.php?action=deleteUser&amp;userID=<?= $allUsers[$i]->id() ?>" onclick="return confirm('Etes-vous sûr?')">Supprimer</a></button>
        </div>
    <?php
        
        //pour chaque utilisateur, je rajoute son id dans le tableau $arrayUsersIDs
        array_push($arrayUsersIDs, $allUsers[$i]->id());    
    }
    ?>    
</form>

<!-- < ?php var_dump($allUsers); ?> FIXME : erase me -->

    <!-- Select / Deselect all checkboxes (for Reported comments)  -->   
        <script>
        $('#checkAllUsers').change(function(){
                $('input[type=checkbox][id=userID]').prop('checked', $(this).prop('checked'))
        })
        </script>


<?php $content = ob_get_clean(); ?>

<?php require('templates/base.php'); ?>