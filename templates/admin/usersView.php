<?php $title = 'Gestion des utilisateurs'; ?>

<?php ob_start(); ?>
<?php require('templates/pagination.php'); ?>
<p>Afficher par <button><a href="index.php?action=manageUsers&page=<?= $_GET['page'] ?>&sortBy=10">10</a></button> <button><a href="index.php?action=manageUsers&page=<?= $_GET['page'] ?>&sortBy=20">20</a></button> <button><a href="index.php?action=manageUsers&page=<?= $_GET['page'] ?>&sortBy=99999999999999999999">Tous</a></button></p>     

<h2>Utilisateurs</h2>
<form action="index.php?action=manageAllSelectedUsers" method="post"> 
        <input type="checkbox" id="checkAllUsers" >
        <label for="checkAllUsers"> Tout sélectionner / désélectionner </label>
        <input type="submit" name="deleteSelectedUsers[]" value="Supprimer" onclick="return confirm('Etes-vous sûr?')">


<?php
    //je déclare un tableau vide qui va me servir a stocker tous les ids des utilisateurs
    $arrayUsersIDs = array();
 
if(!empty($allUsers)) //needed otherwise gives an error on the usersView.php when no users in DB
{    
    for ($i = 0 ; $i < sizeof($allUsers) ; $i++)
    {
        $userid = $allUsers[$i]->id(); 
        $username = $allUsers[$i]->username();
        $email = $allUsers[$i]->email();
        $registrationDate = $allUsers[$i]->modRegistrationDate();
        $group = $allUsers[$i]->groupId();

    ?>
        <div class="usersDisplay">
                <p class=""><strong><?= htmlspecialchars($username) ?></strong> <?= $email ?>
                        enregistré le <strong> <?= $registrationDate ?></strong> 
                
                        <p>role : 
                        <?php 
                        if( $group == 0)
                            { 
                                echo  'Utilisateur';
                                ?>
                                <button class="adminBtns"><a href="index.php?action=updateRole&amp;userID=<?= $userid ?>&amp;role=1" onclick="return confirm('Etes-vous sûr?')">Passer en Admin</a></button>
                                <?php
                                
                            }
                        elseif( $group == 1)
                        { 
                            echo '<strong>Admin</strong>';
                            ?>
                            <button class="adminBtns"><a href="index.php?action=updateRole&amp;userID=<?= $userid ?>&amp;role=0" onclick="return confirm('Etes-vous sûr?')">Passer en Utilisateur</a></button>
                            <?php
                        }      
                        ?></p>

                
                <input type="checkbox" id="userID" name="selectUsers[]" value="<?= $userid?>" >

                <button class="adminBtns"><a href="index.php?action=deleteUser&amp;userID=<?= $userid ?>" onclick="return confirm('Etes-vous sûr?')">Supprimer</a></button>
        </div>
    <?php
        
        //pour chaque utilisateur, je rajoute son id dans le tableau $arrayUsersIDs
        array_push($arrayUsersIDs, $userid);    
    }
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