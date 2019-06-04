<?php $title = 'Administration des commentaires'; ?>

<?php ob_start(); ?>

    
<?php
    while ($datas = $reportedComments->fetch())
    {
    ?>
        <p><strong><?= htmlspecialchars($datas['author']) ?></strong> le <?= $datas['mod_comment_date'] ?></p>
        <p><?= nl2br(htmlspecialchars($datas['comment'])) ?></p>
        <p><a href="index.php?action=post&id=<?= $datas['post_id']?>">Voir l'article associé [<?= $datas['post_id'] ?>]</a> </p>


        <!-- FIXME : edit class of the approve btn -->
        <button class="userBtns"><a href="index.php?action=approveComment"  onclick="return alert('Commentaire approuvé')" >Approuver</a></button>

        <!-- TODO : make the button work-->
        <button class="adminBtns"><a href="#" onclick="return confirm('Etes vous sûr?')">Supprimer</a></button>
    <?php
    }
    ?>
   
<?php $content = ob_get_clean(); ?>

<?php require('backendTemplate.php'); ?>
