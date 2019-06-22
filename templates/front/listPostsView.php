<?php $title = 'Billet simple pour l\'Alaska'; ?>

<?php ob_start(); ?>

<!-- Pagination -->
<?php require('templates/pagination.php'); ?>

<!-- Display all posts -->
<?php 
// var_dump($post) //FIXME remove me


if(!empty($posts)) //needed otherwise gives an error on the listPostsView.php when no posts in DB
{    
    for ($i = 0 ; $i < sizeof($posts) ; $i++)
    {   
        $id = $posts[$i]->id(); //gets the id of the post to use in buttons "read more" & "comments" urls
        $chapter = $posts[$i]->chapterNb();
        $content = $posts[$i]->content();
        $postTitle = $posts[$i]->title();
        $editDate = $posts[$i]->modEditDate();
        $publishDate = $posts[$i]->modPublishDate();


        ?>

        <div class="postsBlock">
        <h3><?= htmlspecialchars($chapter) ?></h3>
        <h2><?= htmlspecialchars($postTitle) ?></h2>
        <?php 
        if($publishDate ==  $editDate)
        {
        echo '<p>Publié le '.  $publishDate . '</p>';
        }
        else
        {
            echo '<p>Edité le '. $editDate . '</p>';
        }
        
        ?>   
            
        <p class="posts">
            <?= substr($content, 0, 600) . "..." ?>
                <button class="regularBtns"><a href="index.php?action=post&id=<?=$id?>&page=1&sortBy=5">Lire la suite</a></button>
                <button class="regularBtns"><a href="index.php?action=post&id=<?=$id?>&page=1&sortBy=5#commentsAnchor">Commentaires</a></button> 
        </p>

        <?php
        // FIXME: factoriser le code avec l'affichage ou non (1)des boutons modifier / supprimer sur listPostsView et PostView (2) des boutons approuver / supprimer des com sur PostView (3) l'affichage du menu admin de template.php
        if( isset($checkUserRole['groupId']) && $checkUserRole['groupId'] == 1)
        { 
        ?>       
            <button class="adminBtns"><a href="index.php?action=manageView&id=<?=$id?>">Modifier</a></button>
            <button class="adminBtns"><a href="index.php?action=deletePost&amp;id=<?= $id?>" onclick="return confirm('Etes-vous sûr?')">Supprimer</a></button>
        <?php
        }  
        ?>     
        
        </div>
    <?php
    }
}
?>


<!-- Pagination -->
<?php require('templates/pagination.php'); ?>

<?php $content = ob_get_clean(); ?>
<?php require('templates/base.php'); ?>