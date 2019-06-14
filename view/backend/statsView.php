<?php $title = 'Statistiques du site'; ?>

<?php ob_start(); ?>
 

<h2>Commentaires</h2>
<h3>Chapitre le plus commenté </h3>
<p><strong><?= $rankingBestPost['title'] ?></strong> avec <strong><?= $rankingBestPost['comment_count'] ?></strong> commentaires </p>
<p>Publié le <?= $rankingBestPost['mod_publish_date'] ?> </p>

<h3>Chapitre le moins commenté</h3>
<p><strong><?= $rankingWorstPost['title'] ?></strong> avec <strong><?= $rankingWorstPost['comment_count'] ?></strong> commentaires </p>
<p>Publié le <?= $rankingWorstPost['mod_publish_date'] ?> </p>

<h3>Tous les Chapitre</h3>

<?php 
while ($datas = $allPostsStats->fetch()) //NOT WORKING
    {       
 ?>
<div class="reportedComments">
 <p><?= $datas['title'] ?></p><p> Nombre de commentaires <?= $datas['comment_count'] ?></p>
</div>
 <?php  
}    
  ?>



<h2>Utilisateurs</h2>
<h3>Utilisateurs le plus actif : </h3>
<p><?= $bestContributor['username'] ?> avec <?= $bestContributor['user_com_count'] ?> commentaires publiés inscrit le <?= $bestContributor['mod_registration_date'] ?> </p></p>
<h3>Utilisateurs le moins actif : </h3>
<p><?= $worstContributor['username'] ?> avec <?= $worstContributor['user_com_count'] ?> commentaires publiés inscrit le <?= $worstContributor['mod_registration_date'] ?> </p>

<h3>Utilisateurs le plus ancien : </h3>
<p><?= $oldestUserRegistered['username'] ?> inscrit le <?= $oldestUserRegistered['mod_registration_date'] ?></p>
<h3>Utilisateurs le plus récent : </h3>
<p><?= $newestUserRegistered['username'] ?> inscrit le <?= $newestUserRegistered['mod_registration_date'] ?></p>


<?php $content = ob_get_clean(); ?>

<?php require('backendTemplate.php'); ?>
