<?php $title = 'Gestion des commentaires'; ?>

<?php ob_start(); ?>

<h2>Commentaires signalés</h2>
<?php
    while ($datas = $reportedComments->fetch())
    {
    ?>
        <div class="reportedComments">       
                <p >Le <strong><?= htmlspecialchars($datas['author']) ?></strong> du <?= $datas['mod_comment_date'] ?>
                a été signalé <strong> <?= $datas['flag'] ?></strong> fois </p>
                <p><?= nl2br(htmlspecialchars($datas['comment'])) ?></p>
                <p><a href="index.php?action=post&id=<?= $datas['post_id']?>">Voir l'article associé [<?= $datas['post_id'] ?>]</a> </p>


                <!-- FIXME : edit class of the approve btn -->
                <button class="userBtns"><a href="index.php?action=approveComment&amp;commentId=<?= $datas['id'] ?>"  onclick="return alert('Commentaire approuvé')" >Approuver</a></button>

                <button class="adminBtns"><a href="index.php?action=deleteComment&amp;id=<?= $datas['id'] ?>&amp;commentId=<?= $datas['id'] ?>" onclick="return confirm('Etes vous sûr?')">Supprimer</a></button>
        </div>
    <?php
    }
    
    ?>

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

<h2>Commentaires à modérer</h2>
<?php
    while ($datassss = $newComments->fetch())
    {       
    ?>
        <div class="acceptDenyComments">       
                <p ><strong><?= htmlspecialchars($datassss['author']) ?></strong> posté le <?= $datassss['mod_comment_date'] ?>
                <p><?= nl2br(htmlspecialchars($datassss['comment'])) ?></p>
                <p><a href="index.php?action=post&id=<?= $datassss['post_id']?>">Voir l'article associé [<?= $datassss['post_id'] ?>]</a> </p>


                <!-- FIXME : edit class of the approve btn -->
                <button class="userBtns"><a href="index.php?action=approveComment&amp;commentId=<?= $datassss['id'] ?>"  onclick="return alert('Commentaire approuvé')" >Approuver</a></button>

                <button class="adminBtns"><a href="index.php?action=deleteComment&amp;id=<?= $datassss['id'] ?>&amp;commentId=<?= $datassss['id'] ?>" onclick="return confirm('Etes vous sûr?')">Supprimer</a></button>
        </div>
    <?php
    }
    
    ?>





         

        <!-- displays a message if no new comments -->   
       <div class="noCommentsToManage">Il n'y a pas de commentaire à modérer</div>
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
