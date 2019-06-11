<?php $title = 'Gestion des commentaires'; ?>

<?php ob_start(); ?>

<?php
    while ($datas = $reportedComments->fetch())
    {

        
    ?>
        <!-- transform non html links in comments into clickable links -->
        <?php $datas['comment'] = htmlspecialchars($datas['comment']);
        $datas['comment'] = preg_replace('#http[s]?://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', $datas['comment']); ?>


                <div class="reportedComments">       
            <p >Le <strong><?= htmlspecialchars($datas['author']) ?></strong> du <?= $datas['mod_comment_date'] ?>
                a été signalé <strong> <?= $datas['flag'] ?></strong> fois </p>
            <p><?= nl2br($datas['comment']) ?></p>
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
