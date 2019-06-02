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
            <?= nl2br(htmlspecialchars($datas['content'])) ?>
                <button>Lire la suite</button><br/>
            <a href="index.php?action=post&id=<?=$id?>">Commentaires</a>
        </p>
        <button class="adminBtns">Modifier</button>
        <button class="adminBtns">Supprimer</button>
    </div>
<?php
}  
$posts->closeCursor();
?>     
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>

        
