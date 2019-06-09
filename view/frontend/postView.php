<?php $title = $post['title'] ; ?>

<?php ob_start(); ?>
    <p><a href="index.php">Retour à la page d'accueil</a></p>
 
<section class="postAndlastPosts">

<!-- displays the post -->
    <div class="postsPostView">
        <h2><?= htmlspecialchars($post['title']) ?></h2>

    <?php //FIXME duplicate content (except $post instead of $data) with listPostsView. Worth factoring into a function ? 
        if($post['mod_publish_date'] ==  $post['mod_edit_date'] )
        {
           echo '<p>Publié le '. $post['mod_publish_date'] . '</p>';
        }
        else
        {
            echo '<p>Edité le '. $post['mod_edit_date'] . '</p>';
        }
         
    ?>    
        <p class="posts">
            <?= nl2br($post['content']) ?>
            
        </p>
        
        <?php
    // FIXME: factoriser le code avec l'affichage ou non (1)des boutons modifier / supprimer sur listPostsView et PostView (2) des boutons approuver / supprimer des com sur PostView (3) l'affichage du menu admin de template.php
    if( (isset($_COOKIE['login']) AND $_COOKIE['login'] == 'Admin') OR  (isset($_SESSION['username']) AND $_SESSION['username'] == 'Admin'))
    { 
    ?>       
        <button class="adminBtns"><a href="index.php?action=manageView&id=<?=$post['id']?>">Modifier</a></button>
        <button class="adminBtns"><a href="index.php?action=deletePost&amp;id=<?= $post['id'] ?>" onclick="return confirm('Etes vous sûr?')" >Supprimer</a></button>
    <?php
    }  
    ?>      
    </div>


<!-- displays the last 3 posts -->
    <div class="lastPosts">
    <h3>Les derniers chapitres publiés</h3>

        <?php
        while($datas = $lastPosts->fetch())
        {
        $id = (int) $datas['id']; 
        ?>
                <h4><?= htmlspecialchars($datas['title']) ?></h4>
                
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
                    <p class="lastPostsP">
                        <?= substr($datas['content'], 0, 200) . "..." ?><br/>
                        <button class="regularBtns"><a href="index.php?action=post&id=<?=$id?>">Lire la suite</a></button>      
                    </p>
                    
        <?php
        }  
        $lastPosts->closeCursor();
        ?>
        </div>     
</section>



<!-- NOT WORKING : show more / less comments -->
<!-- < ?php  $displayLimit =+ 5 ?>     -->

<!-- displays the comment form -->
    <!-- <h2 id="commentsAnchor">Commentaires</h2>
    <form action="index.php?action=post&id=< ?=$id?>&showComments=< ?=$displayLimit?>#commentsAnchor" method="post"> <!-- je veux envoyer la valeur de showfive dans l'url-->
        <!-- <input type="text" name="showFive" value="< ?=$displayLimit?>" />
        <input type="submit" name="showFive" value="Afficher plus">
    </form> -->


    
   
<h2 id="commentsAnchor">Commentaires</h2>   
<?php
        // FIXME: factoriser le code avec l'affichage ou non (1)du formulaire de commentaire (2) du bouton signaler (3) du reste de l'affichage des boutons / menus si loggé en admin / user / pas loggé
        if((isset($_COOKIE['login']) AND !empty($_COOKIE['login'])) OR (isset($_SESSION['username']) AND !empty($_SESSION['username'])))
        {           
        ?>    
            <form action="index.php?action=addComment&amp;id=<?= $post['id'] ?>#commentsAnchor" method="post">
            <div>
                <input type="text" id="author" name="author" required hidden value="<?php
                //FIXME : coder une solution plus propre / optimisée
                if((isset($_COOKIE['login']) AND !empty($_COOKIE['login']))){
                    echo $_COOKIE['login'];
                }
                else{
                    echo $_SESSION['username'];
                }
                
                ?>"  />
            </div>
            <div>
                <label for="comment">Commentaire</label><br />
                <textarea id="comment" name="comment" required></textarea>
            </div>
            <div>
                <input type="submit" />
            </div>
            </form>
        <?php
        }
        else{
        ?>
        <p><strong>Vous devez être connecté pour commenter ce chapitre.</strong></p>
        <?php
        }
        ?> 

<!-- displays the comments -->

<!-- Comments Pagination -->
<?php require('paginationCommentsFE.php') ?>

    <?php
    while ($comment = $comments->fetch())
    {
    //display reported comments with a red background
    if($comment['flag'] > 0)
    {
        echo '<div class="reportedComments">
              <p>Commentaire signalé <strong>' .$comment['flag'] . '</strong> fois En attente de modération.</p>';
    }else
    {
        echo '<div class="comments">';
    }
    ?>
        <!-- transmor non html links in comments into clickable links -->
        <?php $comment['comment'] = htmlspecialchars($comment['comment']);
        $comment['comment'] = preg_replace('#http[s]?://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', $comment['comment']); ?>

        <p><strong><?= htmlspecialchars($comment['author']) ?></strong> le <?= $comment['mod_comment_date'] ?></p>
        <p><?= nl2br($comment['comment']) ?></p>

        
        <?php
        // FIXME: factoriser le code avec l'affichage ou non (1)du formulaire de commentaire (2) du bouton signaler (3) du reste de l'affichage des boutons / menus si loggé en admin / user / pas loggé
        if((isset($_COOKIE['login']) AND !empty($_COOKIE['login'])) OR (isset($_SESSION['username']) AND !empty($_SESSION['username'])))
        {           
        ?>
        <button class="userBtns"><a href="index.php?action=reportComment&amp;id=<?= $post['id'] ?>&amp;commentId=<?= $comment['id'] ?>" onclick="return alert('Commentaire signalé')">Signaler</a></button>

        <?php
        }
        ?> 


        


    
            <?php
            // FIXME: factoriser le code avec l'affichage ou non (1)des boutons modifier / supprimer sur listPostsView et PostView (2) des boutons approuver / supprimer des com sur PostView (3) l'affichage du menu admin de template.php 
            if( (isset($_COOKIE['login']) AND $_COOKIE['login'] == 'Admin') OR  (isset($_SESSION['username']) AND $_SESSION['username'] == 'Admin'))
            {  
                //display approve button only if comment already reported
                    if($comment['flag'] > 0)
                {
                    //FIXME : change class of the approve button
                    echo '<button class="adminBtns"><a href="index.php?action=approveComment&amp;id=' . $post['id'] . '&amp;commentId='. $comment['id'] . '"  onclick="return alert(\'Commentaire approuvé\')" >Approuver</a></button>' ;
                }
                        
            ?>    

                    <!-- gets the commentId as a parameter in the URL of the comment to delete AND the post id to return on the same post after comment has been deleted-->
                    <button class="adminBtns"><a href="index.php?action=deleteComment&amp;id=<?= $post['id'] ?>&amp;commentId=<?= $comment['id'] ?>" onclick="return confirm('Etes vous sûr?')">Supprimer</a></button>
            <?php
            }
            ?>           
        </div>
        <?php
    }
    ?>
    
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>