<?php $title = 'Statistiques du site'; ?>

<?php ob_start(); ?>
 

<h2>Commentaires</h2>
<h3>Article le plus commenté</h3>
<h3>Article le moins commenté</h3>

<h3>Tous les articles</h3>
<p>Article 1 : nombre de commentaires</p>
<p>Article 2 : nombre de commentaires</p>
<p>Article ... : nombre de commentaires</p>
<p>Article X : nombre de commentaires</p>

<h2>Utilisateurs</h2>
<h3>Utilisateurs le plus actif : XXX (nb de commentaires) : ? </h3>
<h3>Utilisateurs le moins actif XXX (nb de commentaires) : ? </h3>


<?php $content = ob_get_clean(); ?>

<?php require('backendTemplate.php'); ?>
