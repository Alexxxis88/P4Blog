<?php $title = 'Gestion des commentaires'; ?>

<?php ob_start(); ?>

<?php
    while ($datas = $reportedComments->fetch())
    {

        
    ?>
                <div class="reportedComments">       
            <p ><strong><?= htmlspecialchars($datas['author']) ?></strong> le <?= $datas['mod_comment_date'] ?></p>
            <p><?= nl2br(htmlspecialchars($datas['comment'])) ?></p>
            <p><a href="index.php?action=post&id=<?= $datas['post_id']?>">Voir l'article associé [<?= $datas['post_id'] ?>]</a> </p>


            <!-- FIXME : edit class of the approve btn -->
            <button class="userBtns"><a href="index.php?action=approveComment&amp;commentId=<?= $datas['id'] ?>"  onclick="return alert('Commentaire approuvé')" >Approuver</a></button>

            <button class="adminBtns"><a href="index.php?action=deleteComment&amp;id=<?= $datas['id'] ?>&amp;commentId=<?= $datas['id'] ?>" onclick="return confirm('Etes vous sûr?')">Supprimer</a></button>
            </div>
    <?php
    }
    
    ?>
            
        <div class="noCommentsToManage">Il n'y a pas de commentaire à modérer</div>
        <script>
                if ( !$.trim($('.reportedComments').html() ).length ) 
                {
                        $('.noCommentsToManage').css("display", "block");
                } else {
                        $('.noCommentsToManage').css("display", "none");
                }
       </script>     
        
   
<?php $content = ob_get_clean(); ?>

<?php require('backendTemplate.php'); ?>
