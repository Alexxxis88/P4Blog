<?php $title = 'Statistiques du site'; ?>

<?php ob_start(); ?>
 

<h2>Commentaires</h2>
<h3>Article le plus commenté</h3>
<h3>Article le moins commenté</h3>

<h3>Tous les articles</h3>

<?php 
// while ($datas = $allPostsStats->fetch()) //NOT WORKING
//     {       
//     ?>
<!-- //     <div class="reportedComments">
//      <p>< ?= $datas['title'] ?></p><p> Nombre de commentaires< ?= $datas['nb_com'] ?></p>
//      </div>
//      < ?php  -->
<!-- //      }    
//      ? > -->



<h2>Utilisateurs</h2>
<h3>Utilisateurs le plus actif : XXX (nb de commentaires) : ? </h3>
<h3>Utilisateurs le moins actif XXX (nb de commentaires) : ? </h3>


<?php $content = ob_get_clean(); ?>

<?php require('backendTemplate.php'); ?>
