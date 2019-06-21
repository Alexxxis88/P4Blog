<?php $title = 'Billet simple pour l\'Alaska'; ?>

<?php ob_start(); ?>


<!-- Display all posts -->
<?php 
// var_dump($post) //FIXME remove me


if(!empty($posts)) //needed otherwise gives an error on the listPostsView.php when no posts in DB
{    
    for ($i = 0 ; $i < sizeof($posts) ; $i++)
    {
        $id = $posts[$i]->id(); //gets the id of the post to use in buttons "read more" & "comments" urls

        ?>

        <div class="postsBlock">
        <h3><?= htmlspecialchars($posts[$i]->chapterNb()) ?></h3>
        <h2><?= htmlspecialchars($posts[$i]->title()) ?></h2>
        <?php 
        if($posts[$i]->modPublishDate() ==  $posts[$i]->modEditDate() )
        {
        echo '<p>Publié le '. $posts[$i]->modPublishDate() . '</p>';
        }
        else
        {
            echo '<p>Edité le '. $posts[$i]->modEditDate() . '</p>';
        }
        
        ?>   
            
        <p class="posts">
            <?= substr($posts[$i]->content(), 0, 600) . "..." ?>
                <button class="regularBtns"><a href="index.php?action=post&id=<?=$id?>&page=1&sortBy=5">Lire la suite</a></button>
                <button class="regularBtns"><a href="index.php?action=post&id=<?=$id?>&page=1&sortBy=5#commentsAnchor">Commentaires</a></button> 
        </p>

        <?php
        // FIXME: factoriser le code avec l'affichage ou non (1)des boutons modifier / supprimer sur listPostsView et PostView (2) des boutons approuver / supprimer des com sur PostView (3) l'affichage du menu admin de template.php
        // if( (isset($_COOKIE['login']) AND $_COOKIE['login'] == 'Admin') OR  (isset($_SESSION['username']) AND $_SESSION['username'] == 'Admin'))
        // { 
        // ?>       
            <button class="adminBtns"><a href="index.php?action=manageView&id=<?=$id?>">Modifier</a></button>
            <button class="adminBtns"><a href="index.php?action=deletePost&amp;id=<?= $id?>" onclick="return confirm('Etes-vous sûr?')">Supprimer</a></button>
        <!-- < ?php
        }  
        ?>      -->
        
        </div>
    <?php
    }
}
?>



<?php $content = ob_get_clean(); ?>
<?php require('templates/base.php'); ?>