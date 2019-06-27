<!DOCTYPE html>
<html>
    <head>
<!-- Favico -->
        <link rel="apple-touch-icon" sizes="57x57" href="./public/img/favico/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="./public/img/favico/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="./public/img/favico/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="./public/img/favico/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="./public/img/favico/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="./public/img/favico/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="./public/img/favico/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="./public/img/favico/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="./public/img/favico/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="./public/img/favico/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="./public/img/favico/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="./public/img/favico/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="./public/img/favico/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
    </head>

<?php $title = 'Billet simple pour l\'Alaska'; ?>


<!-- Full Page Image Header with Vertically Centered Content -->
<header class="masthead">
  <div class="container">
    <div class="row h-100 align-items-center">
      <div class="col-12 text-center">
        <h1 class="font-weight-light">Billet simple pour l'Alaska</h1>
        <p class="lead">Bienvenue sur le blog de Jean Forteroche</p>
      </div>
    </div>
  </div>
</header>


<?php ob_start(); ?>

<!-- Pagination -->
<?php require('templates/pagination.php'); ?>

<!-- Display all posts -->
<div class="section section-grey">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <?php 
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
                    <!-- post -->
                    <div class="col-md-4">
                        <div class="post">
                            <a class="post-img" href="index.php?action=post&id=<?=$id?>&page=1&sortBy=5"><img src="./public/img/post-<?= $id?>.jpg" alt=""></a>
                            <div class="post-body">
                                <div class="post-meta">
                                    <span class="post-date">
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
                                    </span>
                                </div>
                                <a href="index.php?action=post&id=<?=$id?>&page=1&sortBy=5"><em><?= htmlspecialchars($chapter) ?></em> : <?= htmlspecialchars($postTitle) ?></a>
                                <p class="postIndex"><?= substr($content, 0, 600) . "..." ?><br/></p>
                                <a class="readMoreAndCommentsIcons" href="index.php?action=post&id=<?=$id?>&page=1&sortBy=5"><i class="fas fa-book"></i>&nbsp;Lire la suite</a>
                                <a class="readMoreAndCommentsIcons" href="index.php?action=post&id=<?=$id?>&page=1&sortBy=5#commentsAnchor"><i class="far fa-comments"></i>   Commentaires</a>
                                
                                <!-- display edit / delete button for Admin -->
                                <?php
                                if( (isset($_COOKIE['login']) AND $_COOKIE['login'] == 'Admin') OR  (isset($_SESSION['username']) AND $_SESSION['username'] == 'Admin'))
                                { 
                                ?> 
                                    <div class="listPostIcons">  
                                        <a href="index.php?action=manageView&id=<?=$id?>"><i class="far fa-edit"></i></a>
                                        <a href="index.php?action=deletePost&amp;id=<?= $id?>" onclick="return confirm('Etes-vous sûr?')"><i class="far fa-trash-alt"></i></a>
                                    </div>    
                                <?php
                                }  
                                ?>     
                            </div>
                        </div>
                    </div>
                    <!-- /post -->       
                    <?php
                }
            }
            ?>
        </div>
		<!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /section -->

<!-- Pagination -->
<?php require('templates/pagination.php'); ?>

<?php $content = ob_get_clean(); ?>
<?php require('templates/base.php'); ?>

</html>