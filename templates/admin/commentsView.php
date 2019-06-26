<?php $title = 'Gestion des commentaires'; ?>

<?php ob_start(); ?>

<div class="manageComBtns">
        <button class="manageComBtn"><a href="#reportedAnchor">Signalés</a></button>
        <button class="manageComBtn"><a href="#publishdAnchor">A publier</a></button>
</div>        

<h2 id="reportedAnchor">Commentaires signalés</h2>
<form action="index.php?action=manageAllSelectedComments" method="post"> 
        <input type="checkbox" id="checkAllReported" checked>
        <label for="checkAllReported"> Tout sélectionner / désélectionner </label>
        <input type="submit" name="deleteSelectedComments[]" value="Supprimer" onclick="return confirm('Etes-vous sûr?')">
        <input type="submit" name="approveSelectedComments[]" value="Approuver" onclick="return alert('Commentaire(s) approuvé(s)')">
<?php
        //je déclare un tableau vide qui va me servir a stocker tous les ids des commentaires signalés
        $arrayComments = array();
if(!empty($reportedComments)) //needed otherwise gives an error on the commentsView.php when no comments reported
{       
    for ($i = 0 ; $i < sizeof($reportedComments) ; $i++)
    {

        $idComment = $reportedComments[$i]->id(); //gets the id of the post to use in buttons "read more" & "comments" urls
        $postId = $reportedComments[$i]->postId();
        $author = $reportedComments[$i]->author();
        $comment = $reportedComments[$i]->comment();
        $commentDate = $reportedComments[$i]->modCommentDate();
        $updateDate = $reportedComments[$i]->modUpdateDate();
        $flag = $reportedComments[$i]->flag();

        
    ?>
        <!-- FIXME transform non html links in comments into clickable links
        < ?php $reportedComments[$i]->comment() = htmlspecialchars($datas['comment']);
        $datas['comment'] = preg_replace('#http[s]?://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', $datas['comment']); ?> -->


                <div class="reportedComments">
                      <p class="commentHead">Le <strong><?= htmlspecialchars($author) ?></strong> du <?= $commentDate ?>
                                a été signalé <strong> <?= $flag ?></strong> fois </p>
                                <p><?= nl2br(htmlspecialchars($comment)) ?></p>
                                <p><a href="index.php?action=post&id=<?= $postId?>&page=1&sortBy=5">Voir l'article associé [<?= $postId ?>]</a> </p>

                                <!-- sends straight to the right comment using the comment id as an anchor -->
                                <p><a href="index.php?action=post&id=<?= $postId?>&page=1&sortBy=99999999999999999999#<?= $idComment?>">Voir le commentaire</a> </p>
                        
                        <label for="commentID"> Id du commentaire : <?= $idComment ?> </label>
                        <input type="checkbox" id="commentID" name="selectComments[]" value="<?= $idComment?>" checked >
        
                        <!-- FIXME : edit class of the approve btn -->
                        <button><a href="index.php?action=approveComment&amp;commentId=<?= $idComment ?>"  onclick="return alert('Commentaire approuvé')" >Approuver</a></button>

                        <button><a href="index.php?action=deleteComment&amp;id=<?= $postId ?>&amp;commentId=<?= $idComment ?>" onclick="return confirm('Etes-vous sûr?')">Supprimer</a></button>
                </div>
        <?php
        
        //pour chaque commentaire, je rajoute son id dans le tableau $arrayComments
        array_push($arrayComments, $idComment);
       
    }
}
?>        
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

<h2 id="publishdAnchor">Commentaires à publier</h2>
<form action="index.php?action=publishAllSelectedComments" method="post"> 
        <input type="checkbox" id="checkAllToPublish" checked>
        <label for="checkAllToPublish"> Tout sélectionner / désélectionner </label>
        <input type="submit" name="deleteSelectedComments[]" value="Supprimer" onclick="return confirm('Etes-vous sûr?')">
        <input type="submit" name="publishSelectedComments[]" value="Publier" onclick="return alert('Commentaire(s) publié(s)')">
<?php
//je déclare un tableau vide qui va me servir a stocker tous les ids des commentaires signalés
$arrayPublish = array();

if(!empty($newComments)) //needed otherwise gives an error on the commentsView.php when no new comments to manage
{
    for ($i2 = 0 ; $i2 < sizeof($newComments) ; $i2++)
    { 
        $idComment = $newComments[$i2]->id(); //gets the id of the post to use in buttons "read more" & "comments" urls
        $postId = $newComments[$i2]->postId();
        $author = $newComments[$i2]->author();
        $comment = $newComments[$i2]->comment();
        $commentDate = $newComments[$i2]->modCommentDate();
    ?>

              
                <div class="acceptDenyComments">
                    <p class="commentHead">Le <strong><?= htmlspecialchars($author) ?></strong> posté le <?= $commentDate ?>
                    
                    <!-- transform non html links in comments into clickable links--> 
                    <p><?= nl2br($comment = preg_replace('#http[s]?://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', htmlspecialchars($comment))) ?></p>
                    
                    <p><a href="index.php?action=post&id=<?= $postId?>&page=1&sortBy=5">Voir l'article associé [<?= $postId ?>]</a> </p>
            
                        <label for="commentPublishID"> Id du commentaire : <?= $idComment ?> </label>
                        <input type="checkbox" id="commentPublishID" name="selectPublishComments[]" value="<?= $idComment?>" checked >
        
                        <button><a href="index.php?action=approveComment&amp;commentId=<?= $idComment ?>"  onclick="return alert('Commentaire publié')" >Publier</a></button>

                        <button><a href="index.php?action=deleteComment&amp;id=<?= $postId ?>&amp;commentId=<?= $idComment ?>" onclick="return confirm('Etes-vous sûr?')">Supprimer</a></button>
                </div>
        <?php
        
        //pour chaque commentaire à publier, je rajoute son id dans le tableau $arrayPublish
        array_push($arrayPublish, $idComment);
       
    }
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
        


 <!-- displays a message if no new comments -->   
        <script>
                if ( !$.trim($('.reportedComments, .acceptDenyComments').html() ).length ) 
                {
                        $('.comAlert').css("display", "none");
                } else {
                        $('.comAlert').css("display", "block");
                }
       </script>    

   
<?php $content = ob_get_clean(); ?>

<?php require('templates/base.php'); ?>