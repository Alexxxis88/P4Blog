<?php $title = $post['title'] ; ?>

<?php ob_start(); ?>
    <p><a href="index.php">Retour à la page d'accueil</a></p>
 
<section class="postAndlastPosts">

<!-- displays the post -->
    <div class="postsPostView"> <!-- edit class because div and <p> have same class name -->
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
        <p class="posts"> <!-- edit class because div and <p> have same class name -->
            <?= nl2br(htmlspecialchars($post['content'])) ?>
            
        </p>
        <button class="adminBtns"><a href="index.php?action=manageView&id=<?=$post['id']?>">Modifier</a></button>
        <button class="adminBtns"><a href="index.php?action=deletePost&amp;id=<?= $post['id'] ?>" onclick="return confirm('Etes vous sûr?')" >Supprimer</a></button>
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
                    <p class="lastPostsP"><!-- edit class because div and <p> have same class name -->
                        <?= substr($datas['content'], 0, 200) . "..." ?><br/>
                        <button class="regularBtns"><a href="index.php?action=post&id=<?=$id?>">Lire la suite</a></button>      
                    </p>
                    
        <?php
        }  
        $lastPosts->closeCursor();
        ?>
        </div>     
</section>


<!-- displays the comment form -->
    <h2 id="commentsAnchor">Commentaires</h2>

    <form action="index.php?action=addComment&amp;id=<?= $post['id'] ?>#commentsAnchor" method="post">
    <div>
        <label for="author">Auteur</label><br />
        <input type="text" id="author" name="author" required/>
    </div>
    <div>
        <label for="comment">Commentaire</label><br />
        <textarea id="comment" name="comment" required></textarea>
    </div>
    <div>
        <input type="submit" />
    </div>
</form>


<!-- displays the comments -->
    <?php
    while ($comment = $comments->fetch())
    {
    //display reported comments with a red background
    if($comment['flag'] == 1)
    {
        echo '<div class="reportedComments">
              <p>Commentaire signalé. En attente de modération.</p>';
    }elseif($comment['flag'] == 0)
    {
        echo '<div>';
    }
    ?>
     
        <p><strong><?= htmlspecialchars($comment['author']) ?></strong> le <?= $comment['mod_comment_date'] ?></p>
        <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>

    <?php 
    //display report button only if comment not already reported
    if($comment['flag'] == 0)
    {
        echo '<button class="userBtns"><a href="index.php?action=reportComment&amp;id=' . $post['id'] . '&amp;commentId='. $comment['id'] . '"  onclick="return alert(\'Commentaire signalé\')" >Signaler</a></button>' ;
    }
    else{//FIXME : change class of the approve button
        echo '<button class="userBtns"><a href="index.php?action=approveComment&amp;id=' . $post['id'] . '&amp;commentId='. $comment['id'] . '"  onclick="return alert(\'Commentaire approuvé\')" >Approuver</a></button>' ;
    }   
    ?>    

        <!-- gets the commentId as a parameter in the URL of the comment to delete AND the post id to return on the same post after comment has been deleted-->
        <button class="adminBtns"><a href="index.php?action=deleteComment&amp;id=<?= $post['id'] ?>&amp;commentId=<?= $comment['id'] ?>" onclick="return confirm('Etes vous sûr?')">Supprimer</a></button>
    </div>
    <?php
    }
    ?>
    
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>