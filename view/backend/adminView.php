<?php $title = 'Page d\'administration'; ?>

<?php ob_start(); ?>

    <div style="text-align:center" >
        <button class="adminBtns"><a href="index.php?action=publishChapter">Publier un chapitre</a></button>
        <button class="adminBtns"><a href="index.php?action=listPostsAdmin">Editer les chapitres</a></button>
        <button class="adminBtns"><a href="index.php?action=manageComments">Commentaires</a></button>
            
    </div>

    <?php
while($datasAdmin = $postsAdmin->fetch())
{
$id = (int) $datasAdmin['id']; 
?>

    <div class="posts">
        <h2><?= htmlspecialchars($datasAdmin['title']) ?></h2>
        <p>Publié le <?= $datasAdmin['mod_publish_date'] ?></p>
            
        <p class="posts">
            <?= substr($datasAdmin['content'], 0, 600) . "..." ?>
                <button><a href="index.php?action=post&id=<?=$id?>">Lire la suite</a></button><br/>
                <button><a href="index.php?action=post&id=<?=$id?>#commentsAnchor">Commentaires</a></button>

        </p>
        <button class="adminBtns">Modifier</button>
        <button class="adminBtns"><a href="index.php?action=deletePost&amp;id=<?= $id?>">Supprimer</a></button>
    </div>
<?php
}  
$postsAdmin->closeCursor();
?>     
   
<?php $content = ob_get_clean(); ?>

<?php require('backendTemplate.php'); ?>
