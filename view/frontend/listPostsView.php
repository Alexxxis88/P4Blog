<?php $title = 'Billet simple pour l\'Alaska'; ?>

<?php ob_start(); ?>

<?php
while($datas = $posts->fetch())
{
$id = (int) $datas['id']; 
?>

    <div class="posts">
        <h2><?= htmlspecialchars($datas['title']) ?></h2>
        <p>Publié le <?= $datas['mod_publish_date'] ?></p>
            
        <p class="posts">
            <?= substr($datas['content'], 0, 600) . "..." ?>
                <button class="regularBtns"><a href="index.php?action=post&id=<?=$id?>">Lire la suite</a></button>
                <button class="regularBtns"><a href="index.php?action=post&id=<?=$id?>#commentsAnchor">Commentaires</a></button>

        </p>
        <button class="adminBtns"><a href="index.php?action=manageView&id=<?=$id?>">Modifier</a></button>
        <button class="adminBtns"><a href="index.php?action=deletePost&amp;id=<?= $id?>" onclick="return confirm('Etes vous sûr?')">Supprimer</a></button>
    </div>
<?php
}  
$posts->closeCursor();
?>     
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>