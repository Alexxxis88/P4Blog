<?php $title = 'Page d\'administration'; ?>

<?php ob_start(); 
while($datasAdmin = $postsAdmin->fetch())
{
$id = (int) $datasAdmin['id']; 
?>

    <div class="posts"><!-- edit class because div and <p> have same class name -->
        <h2><?= htmlspecialchars($datasAdmin['title']) ?></h2>
        <p>Publié le <?= $datasAdmin['mod_publish_date'] ?></p>
        <p>Edité le <?= $datasAdmin['mod_edit_date'] ?></p>
    
        <p class="posts"><!-- edit class because div and <p> have same class name -->
            <?= substr($datasAdmin['content'], 0, 600) . "..." ?>
                <button class="regularBtns"><a href="index.php?action=post&id=<?=$id?>">Lire la suite</a></button>
                <button class="regularBtns"><a href="index.php?action=post&id=<?=$id?>#commentsAnchor">Commentaires</a></button>
        </p>
        <button class="adminBtns"><a href="index.php?action=manageView&id=<?=$id?>">Modifier</a></button>
        <button class="adminBtns"><a href="index.php?action=deletePost&amp;id=<?= $id?>" onclick="return confirm('Etes vous sûr?')">Supprimer</a></button>
    </div>
<?php
}  
$postsAdmin->closeCursor();
?>     
   
<?php $content = ob_get_clean(); ?>

<?php require('backendTemplate.php'); ?>
