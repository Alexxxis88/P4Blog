<?php $title = 'Billet simple pour l\'Alaska'; ?>

<?php ob_start(); ?>


<!-- Display all posts -->
<?php
while($datas = $posts->fetch())
{
$id = (int) $datas['id']; 
?>

    <div class="posts"><!-- edit class because div and <p> have same class name -->
        <h2><?= htmlspecialchars($datas['title']) ?></h2>
        <?php //FIXME duplicate content (except $data instead of $post) with PostsView. Worth factoring into a function ? 
        if($datas['mod_publish_date'] ==  $datas['mod_edit_date'] )
        {
           echo '<p>Publié le '. $datas['mod_publish_date'] . '</p>';
        }
        else
        {
            echo '<p>Edité le '. $datas['mod_edit_date'] . '</p>';
        }
         
    ?>    
            
        <p class="posts"><!-- edit class because div and <p> have same class name -->
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