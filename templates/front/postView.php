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
        if($post->modPublishDate() ==  $post->modEditDate() )
        {
           echo '<p>Publié le '. $post->modPublishDate() . '</p>';
        }
        else
        {
            echo '<p>Edité le '. $post->modEditDate() . '</p>';
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


    <!-- displays the last 3 posts -->
    <div class="lastPosts">
    <h3>Les derniers chapitres publiés</h3>


        <?php
        for ($i = 0 ; $i < 3 ; $i++)
        {
            $id = $lastPosts[$i]->id(); //gets the id of the post to use in buttons "read more" & "comments" urls

        ?>       
            <h4><?= htmlspecialchars($lastPosts[$i]->chapterNb()) ?> : <?= htmlspecialchars($lastPosts[$i]->title()) ?></h4>
            
            <?php //FIXME duplicate content (except $data instead of $post) with PostsView. Worth factoring into a function ? 
            if($lastPosts[$i]->modPublishDate() ==  $lastPosts[$i]->modEditDate() )
            {
            echo '<p>Publié le '. $lastPosts[$i]->modPublishDate() . '</p>';
            }
            else
            {
                echo '<p>Edité le '. $lastPosts[$i]->modEditDate() . '</p>';
            }
            
        ?>    
                <p class="lastPostsP">
                    <?= substr($lastPosts[$i]->content(), 0, 200) . "..." ?><br/>
                    <button class="regularBtns"><a href="index.php?action=post&id=<?=$id?>&page=1&sortBy=5">Lire la suite</a></button>      
                </p>
                    
        <?php
        }  
        ?>
        </div>     
</section>



<h2 id="commentsAnchor">Commentaires</h2>
<p><strong>Cet article a été commenté <?= $totalCom ?> fois.</strong></p>   
<?php
        // FIXME: factoriser le code avec l'affichage ou non (1)du formulaire de commentaire (2) du bouton signaler (3) du reste de l'affichage des boutons / menus si loggé en admin / user / pas loggé
        if((isset($_COOKIE['login']) AND !empty($_COOKIE['login'])) OR (isset($_SESSION['username']) AND !empty($_SESSION['username'])))
        {           
        ?>    
            <form action="index.php?action=addComment&amp;id=<?= $post['id'] ?>" method="post">
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
                <label for="comment">Commentaire (700 carac. max)</label><br />
                <textarea id="comment" name="comment" cols="80" rows="5" maxlength="700" required onkeyup="textCounter(this,'counter',700);"></textarea>
            </div>

            <!-- Used to count how many characters there is left -->
            <input disabled  maxlength="3" size="3" value="700" id="counter">

            <div>
            <input type="submit" onclick="return confirm('Poster ce commentaire?')" value="Commenter"/>
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
<!-- < ?php require('paginationCommentsFE.php') ?> -->
<p>Afficher par <button><a href="index.php?action=post&page=<?= $_GET['page'] ?>&id=<?= $_GET['id'] ?>&sortBy=5#commentsAnchor">5</a></button> <button><a href="index.php?action=post&page=<?= $_GET['page'] ?>&id=<?= $_GET['id'] ?>&sortBy=15#commentsAnchor">15</a></button> <button><a href="index.php?action=post&page=<?= $_GET['page'] ?>&id=<?= $_GET['id'] ?>&sortBy=99999999999999999999#commentsAnchor">Tous</a></button></p>  
    <?php
    for ($i = 0 ; $i < sizeof($comments) ; $i++)
    {
        if($comments[$i]->flag() < 9999)
        {
            
            //display reported comments with a red background
            if($comments[$i]->flag() > 0)
            {
                echo '<div class="reportedComments">
                    <p>Commentaire signalé <strong>' .$comments[$i]->flag() . '</strong> fois En attente de modération.</p>';
            }else
            {
                echo '<div class="comments">';
            }
            ?>
                <!-- transform non html links in comments into clickable links FIXME : NOT WORKING--> 
                <!-- < ?php $comments[$i]->comment() = htmlspecialchars($comments[$i]->comment()); 
                $comments[$i]->comment() = preg_replace('#http[s]?://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', $comments[$i]->comment()); ?>-->

                <!-- id= $comment['id'] used to create an anchor on the comment position to be able to display the right comment directly when selected in manageCommentsView.php (be)-->
                <p id="<?= $comments[$i]->id() ?>"><strong><?= htmlspecialchars($comments[$i]->author()) ?></strong> publié le <?= $comments[$i]->modCommentDate() ?>

                <?php
                //also display update_date if comment has been updated by author
                if ($comments[$i]->modCommentDate() != $comments[$i]->modUpdateDate())
                { echo ' et modifié le ' . $comments[$i]->modUpdateDate();
                }  ?></p> <p><?= nl2br(htmlspecialchars($comments[$i]->comment())) ?></p>
                <p>Id du commentaire: <?= $comments[$i]->id() ?></p>

                
                <?php
                // FIXME: factoriser le code avec l'affichage ou non (1)du formulaire de commentaire (2) du bouton signaler (3) du reste de l'affichage des boutons / menus si loggé en admin / user / pas loggé
                if($comments[$i]->flag() == 0)
                {
                    if((isset($_COOKIE['login']) AND !empty($_COOKIE['login'])) OR (isset($_SESSION['username']) AND !empty($_SESSION['username'])))
                    {           
                    ?>
                    <button class="userBtns"><a href="index.php?action=reportComment&amp;id=<?= $post->id() ?>&amp;commentId=<?= $comments[$i]->id() ?>" onclick="return confirm('Voulez vous vraiment signaler ce commentaire?')">Signaler</a></button>

                    <?php
                    }
                    ?> 


                    <?php
                    // allows the author to edit / delete his comments only if it has not been reported and pending for management
                    if(isset($_COOKIE['login'])){
                        $cookieOrSessionUserNAme = $_COOKIE['login'];
                        }
                        elseif(isset($_SESSION['username'])){
                            $cookieOrSessionUserNAme = $_SESSION['username'];
                        }
                        
                    if(isset($cookieOrSessionUserNAme) AND !empty($cookieOrSessionUserNAme) AND  $cookieOrSessionUserNAme == $comments[$i]->author())
                    {           
                    ?>
                    <!-- form only displayed and used to edit an existing comment -->
                    <!-- i add the $comment['id'] in the class name to display only the form on the selected comment -->
                    <div class="editCommentForm<?=$comments[$i]->id() ?>">
                        <form action="index.php?action=updateComment&amp;id=<?= $post->id() ?>&amp;commentId=<?= $comments[$i]->id() ?>" method="post">
                                <!-- <div>
                                <input type="text" id="author" name="author" required hidden value="< ?php $cookieOrSessionUserNAme ?>"/> 
                            </div> -->
                            <div>
                                <label for="comment">Commentaire (700 carac. max)</label><br />
                                <textarea id="comment" name="comment" cols="80" rows="5" maxlength="700" required onkeyup="textCounter(this,'counter',700);"><?= $comments[$i]->comment() ?> </textarea>
                            </div>

                            <!-- Used to count how many characters there is left -->
                            <input disabled  maxlength="3" size="3" value="700" id="counter">

                            <div>
                            <input type="submit" class="editBtns" value="Sauvegarder mon commentaire"/>
                            </div>
                        </form>
                    </div> 

                    <button class="editBtns"><a href="index.php?action=deleteComment&amp;id=<?= $post->id() ?>&amp;commentId=<?= $comments[$i]->id() ?>" onclick="return confirm('Etes-vous sûr?')">Supprimer mon commentaire</a></button>
                    
                    <button class="editBtns<?=$comments[$i]->id() ?> editCommentBtn<?=$comments[$i]->id() ?>">Modifier mon commentaire</button>
                    <script>
                    $(".editBtns<?=$comments[$i]->id() ?>").on("click", function(){
                        $(".editCommentForm<?=$comments[$i]->id()?>, .editCommentBtn<?=$comments[$i]->id() ?>").toggle("slow")
                    })
                    </script>
                    <?php
                    }
                }
                ?> 

                    <?php
                    // FIXME: factoriser le code avec l'affichage ou non (1)des boutons modifier / supprimer sur listPostsView et PostView (2) des boutons approuver / supprimer des com sur PostView (3) l'affichage du menu admin de template.php 
                    if( (isset($_COOKIE['login']) AND $_COOKIE['login'] == 'Admin') OR  (isset($_SESSION['username']) AND $_SESSION['username'] == 'Admin'))
                    {  
                        //display approve button only if comment already reported
                            if($comments[$i]->flag() > 0)
                        {
                            //FIXME : change class of the approve button
                            echo '<button class="adminBtns"><a href="index.php?action=approveComment&amp;id=' . $post->id . '&amp;commentId='. $comments[$i]->id() . '"  onclick="return alert(\'Commentaire approuvé\')" >Approuver</a></button>' ;
                        }
                                
                    ?>    
                        <!-- gets the commentId as a parameter in the URL of the comment to delete AND the post id to return on the same post after comment has been deleted-->
                        <button class="adminBtns"><a href="index.php?action=deleteComment&amp;id=<?= $post->id ?>&amp;commentId=<?= $comments[$i]->id() ?>" onclick="return confirm('Etes-vous sûr?')">Supprimer</a></button>
                    <?php
                    }
                    ?>           
                </div>
                <?php
        }
    }
    ?>
    
<?php $content = ob_get_clean(); ?>
<!-- < ?php var_dump($lastPosts) //FIXME remove me?>  -->

<?php require('templates/base.php'); ?>