<?php $title = 'Gestion des commentaires'; ?>

<?php ob_start(); ?>

<h2>Commentaires signalés</h2>
<form action="index.php?action=manageAllSelectedComments" method="post"> 
        <input type="checkbox" id="checkAllReported" checked>
        <label for="checkAllReported"> Tout sélectionner / désélectionner </label>
        <input type="submit" name="deleteSelectedComments[]" value="Supprimer" onclick="return confirm('Etes vous sûr?')">
        <input type="submit" name="approveSelectedComments[]" value="Approuver" onclick="return alert('Commentaire(s) approuvé(s)')">
<?php


        //je déclare un tableau vide qui va me servir a stocker tous les ids des commentaires signalés
        $arrayComments = array();

    while ($datas = $reportedComments->fetch())
    {

        
    ?>
        <!-- transform non html links in comments into clickable links -->
        <?php $datas['comment'] = htmlspecialchars($datas['comment']);
        $datas['comment'] = preg_replace('#http[s]?://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', $datas['comment']); ?>


                <div class="reportedComments">
                      <p class="commentHead">Le <strong><?= htmlspecialchars($datas['author']) ?></strong> du <?= $datas['mod_comment_date'] ?>
                                a été signalé <strong> <?= $datas['flag'] ?></strong> fois </p>
                                <p><?= nl2br(htmlspecialchars($datas['comment'])) ?></p>
                                <p><a href="index.php?action=post&id=<?= $datas['post_id']?>">Voir l'article associé [<?= $datas['post_id'] ?>]</a> </p>
                        
                        <label for="commentID"> Id du commentaire : <?= $datas['id'] ?> </label>
                        <input type="checkbox" id="commentID" name="selectComments[]" value="<?= $datas['id']?>" checked >
        
                        <!-- FIXME : edit class of the approve btn -->
                        <button class="userBtns"><a href="index.php?action=approveComment&amp;commentId=<?= $datas['id'] ?>"  onclick="return alert('Commentaire approuvé')" >Approuver</a></button>

                        <button class="adminBtns"><a href="index.php?action=deleteComment&amp;id=<?= $datas['id'] ?>&amp;commentId=<?= $datas['id'] ?>" onclick="return confirm('Etes vous sûr?')">Supprimer</a></button>
                </div>
        <?php
        
        //pour chaque commentaire, je rajoute son id dans le tableau $arrayComments
        array_push($arrayComments, $datas['id']);
       
    }
?>
<!-- <?php 
        //vérifications des infos qu'on génère ---------------------------------
        $comma_separated = implode(",", $arrayComments);
        echo '<br/><strong>tous les ids du tableau convertir en UNE CHAINE: ' . $comma_separated . '</strong>'; 

        $arrayLength = count($arrayComments, COUNT_NORMAL);
        for( $i = 0; $i < $arrayLength; $i++){
                echo'<br/>la valeurs $arrayComments[$i =' . $i . ']  du tableau $arrayComments: ' . $arrayComments[$i];
        }

        //FIN vérifications des infos qu'on génère ---------------------------------

?> -->
        
</form>

    <!-- Select / Deselect all checkboxes (for Reported comments)  -->   
        <script>
        $('#checkAllReported').change(function(){
                $('input[type=checkbox][id=commentID]').prop('checked', $(this).prop('checked'))
        })
        </script>

    <!-- displays a message if no reported comments -->   
    <div class="noReportedComments">Il n'y a pas de commentaire signalé</div>
        <script>
                if ( !$.trim($('.reportedComments').html() ).length ) 
                {
                        $('.noReportedComments').css("display", "block");
                } else {
                        $('.noReportedComments').css("display", "none");
                }
       </script>   

<h2>Commentaires à publier</h2>
<form action="index.php?action=publishAllSelectedComments" method="post"> 
        <input type="checkbox" id="checkAllToPublish" checked>
        <label for="checkAllToPublish"> Tout sélectionner / désélectionner </label>
        <input type="submit" name="deleteSelectedComments[]" value="Supprimer" onclick="return confirm('Etes vous sûr?')">
        <input type="submit" name="publishSelectedComments[]" value="Publier" onclick="return alert('Commentaire(s) publié(s)')">
<?php

//je déclare un tableau vide qui va me servir a stocker tous les ids des commentaires signalés
$arrayPublish = array();

    while ($datasPublish = $newComments->fetch())
    {       
    ?>
                <div class="acceptDenyComments">
                    <p class="commentHead">Le <strong><?= htmlspecialchars($datasPublish['author']) ?></strong> posté le <?= $datasPublish['mod_comment_date'] ?>
                    <p><?= nl2br(htmlspecialchars($datasPublish['comment'])) ?></p>
                    <p><a href="index.php?action=post&id=<?= $datasPublish['post_id']?>">Voir l'article associé [<?= $datasPublish['post_id'] ?>]</a> </p>
            
                        <label for="commentPublishID"> Id du commentaire : <?= $datasPublish['id'] ?> </label>
                        <input type="checkbox" id="commentPublishID" name="selectPublishComments[]" value="<?= $datasPublish['id']?>" checked >
        
                        <!-- FIXME : edit class of the approve btn -->
                        <button class="userBtns"><a href="index.php?action=approveComment&amp;commentId=<?= $datasPublish['id'] ?>"  onclick="return alert('Commentaire publié')" >Publier</a></button>

                        <button class="adminBtns"><a href="index.php?action=deleteComment&amp;id=<?= $datasPublish['id'] ?>&amp;commentId=<?= $datasPublish['id'] ?>" onclick="return confirm('Etes vous sûr?')">Supprimer</a></button>
                </div>
        <?php
        
        //pour chaque commentaire à publier, je rajoute son id dans le tableau $arrayPublish
        array_push($arrayPublish, $datasPublish['id']);
       
    }
?>
        
</form>


    <!-- Select / Deselect all checkboxes (for Reported comments)  -->   
    <script>
        $('#checkAllToPublish').change(function(){
                $('input[type=checkbox][id=commentPublishID]').prop('checked', $(this).prop('checked'))
        })
        </script>


         

        <!-- displays a message if no new comments -->   
       <div class="noCommentsToManage">Il n'y a pas de commentaire à publier</div>
        <script>
                if ( !$.trim($('.acceptDenyComments').html() ).length ) 
                {
                        $('.noCommentsToManage').css("display", "block");
                } else {
                        $('.noCommentsToManage').css("display", "none");
                }
       </script>    
        
   
<?php $content = ob_get_clean(); ?>

<?php require('backendTemplate.php'); ?>
