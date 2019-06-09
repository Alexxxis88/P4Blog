<?php $title = 'Billet simple pour l\'Alaska'; ?>

<?php ob_start(); ?>


<!-- Pagination -->
<?php require('paginationFE.php'); ?>

<!-- Display all posts -->
<?php
while($datas = $posts->fetch())
{
$id = (int) $datas['id']; 
?>

    <div class="postsBlock">
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
            
        <p class="posts">
            <?= substr($datas['content'], 0, 600) . "..." ?>
                <button class="regularBtns"><a href="index.php?action=post&id=<?=$id?>">Lire la suite</a></button>
                <button class="regularBtns"><a href="index.php?action=post&id=<?=$id?>#commentsAnchor">Commentaires</a></button>

        </p>
        
    <?php
    // FIXME: factoriser le code avec l'affichage ou non (1)des boutons modifier / supprimer sur listPostsView et PostView (2) des boutons approuver / supprimer des com sur PostView (3) l'affichage du menu admin de template.php
    if( (isset($_COOKIE['login']) AND $_COOKIE['login'] == 'Admin') OR  (isset($_SESSION['username']) AND $_SESSION['username'] == 'Admin'))
    { 
    ?>       
        <button class="adminBtns"><a href="index.php?action=manageView&id=<?=$id?>">Modifier</a></button>
        <button class="adminBtns"><a href="index.php?action=deletePost&amp;id=<?= $id?>" onclick="return confirm('Etes vous sûr?')">Supprimer</a></button>
    <?php
    }  
    ?>     
    </div>
<?php
}  
$posts->closeCursor();
?> 

<!-- Pagination -->
<?php require('paginationFE.php'); ?>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>