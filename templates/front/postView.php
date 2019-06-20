<?php $title = $post->title() ; ?>

<?php ob_start(); ?>
    <p><a href="index.php">Retour à la page d'accueil</a></p>
 
<section class="postAndlastPosts">

<!-- < ?php var_dump($post) //FIXME remove me?> -->
<!-- displays the post -->
    <div class="postsPostView">
        <h3><?= htmlspecialchars($post->chapterNb()) ?></h3>
        <h2><?= htmlspecialchars($post->title()) ?></h2>

    <?php //FIXME duplicate content (except $post instead of $data) with listPostsView. Worth factoring into a function ? 
        if($post->publishDate() ==  $post->editDate() )
        {
           echo '<p>Publié le '. $post->publishDate() . '</p>';
        }
        else
        {
            echo '<p>Edité le '. $post->editDate() . '</p>';
        }
         
    ?>    
        <p class="posts">
            <?= nl2br($post->content()) ?>
            
        </p>
        
        <?php
    // FIXME: factoriser le code avec l'affichage ou non (1)des boutons modifier / supprimer sur listPostsView et PostView (2) des boutons approuver / supprimer des com sur PostView (3) l'affichage du menu admin de template.php
    if( (isset($_COOKIE['login']) AND $_COOKIE['login'] == 'Admin') OR  (isset($_SESSION['username']) AND $_SESSION['username'] == 'Admin'))
    { 
    ?>       
        <button class="adminBtns"><a href="index.php?action=manageView&id=<?=$post->id()?>">Modifier</a></button>
        <button class="adminBtns"><a href="index.php?action=deletePost&amp;id=<?= $post->id() ?>" onclick="return confirm('Etes-vous sûr?')" >Supprimer</a></button>
    <?php
    }  
    ?>      
    </div>
    
<?php $content = ob_get_clean(); ?>
<?php require('templates/base.php'); ?>