<?php $title = 'Administration des commentaires'; ?>

<?php ob_start(); ?>

<div class="reportedComments">    
<?php
    while ($datas = $reportedComments->fetch())
    {

        
    ?>
        
            <p><strong><?= htmlspecialchars($datas['author']) ?></strong> le <?= $datas['mod_comment_date'] ?></p>
            <p><?= nl2br(htmlspecialchars($datas['comment'])) ?></p>
            <p><a href="index.php?action=post&id=<?= $datas['post_id']?>">Voir l'article associé [<?= $datas['post_id'] ?>]</a> </p>


            <!-- FIXME : edit class of the approve btn -->
            <button class="userBtns"><a href="index.php?action=approveComment&amp;commentId=<?= $datas['id'] ?>"  onclick="return alert('Commentaire approuvé')" >Approuver</a></button>

            <button class="adminBtns"><a href="index.php?action=deleteComment&amp;id=<?= $datas['id'] ?>&amp;commentId=<?= $datas['id'] ?>" onclick="return confirm('Etes vous sûr?')">Supprimer</a></button>
    <?php
    }
    
    ?>
            </div>
        
   
<?php $content = ob_get_clean(); ?>

<?php require('backendTemplate.php'); ?>
