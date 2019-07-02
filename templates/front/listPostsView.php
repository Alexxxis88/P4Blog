<?php $title = 'Billet simple pour l\'Alaska'; ?>
<?php ob_start(); ?>
    <div class ="masthead">
        <div class="container ">
            <div class="row h-100 align-items-center">
                <div class="col-12 text-center">
                    <h1 class="font-weight-light">Billet simple pour l'Alaska</h1>
                    <p class="lead">Bienvenue sur le blog de Jean Forteroche</p>
                </div>
            </div>
        </div>
    </div>

<?php require('templates/pagination.php'); ?>

<!-- Display all posts -->
<div class="section section-grey">
    <div class="container">
        <div class="row">
            <?php
            if (!empty($posts)) { //needed otherwise gives an error on the listPostsView.php when no posts in DB
                for ($i = 0 ; $i < sizeof($posts) ; $i++) {
                    $id = $posts[$i]->id(); //gets the id of the post to use in buttons "read more" & "comments" urls
                    $chapter = $posts[$i]->chapterNb();
                    $content = $posts[$i]->content();
                    $postTitle = $posts[$i]->title();
                    $editDate = $posts[$i]->modEditDate();
                    $publishDate = $posts[$i]->modPublishDate(); ?>

                    <!-- post -->
                    <div class="col-md-4">
                        <div class="post">
                            <a class="post-img" href="index.php?action=post&id=<?=$id?>&page=1&sortBy=5"><img src="./public/img/post-<?= $id?>.jpg" alt="<?= $postTitle ?>"></a>
                            <div class="post-body">
                                <div class="post-meta">
                                    <div class="post-date">
                                    <?php
                                        if ($publishDate ==  $editDate) {
                                            echo '<p>Publié le '.  $publishDate . '</p>';
                                        } else {
                                            echo '<p>Edité le '. $editDate . '</p>';
                                        } ?>
                                    </div>
                                </div>
                                <a href="index.php?action=post&id=<?=$id?>&page=1&sortBy=5"><em><?= $chapter ?></em> : <?= $postTitle ?></a>
                                <p class="postIndex"><?= substr($content, 0, 600) . "..." ?></p><br>
                                <a class="readMoreAndCommentsIcons" href="index.php?action=post&id=<?=$id?>&page=1&sortBy=5"><span class="fas fa-book"></span>&nbsp;Lire la suite</a>
                                <a class="readMoreAndCommentsIcons" href="index.php?action=post&id=<?=$id?>&page=1&sortBy=5#commentsAnchor"><span class="far fa-comments"></span>   Commentaires</a>

                                <!-- display edit / delete button for Admin -->
                                <?php
                                if ((isset($_COOKIE['login']) and $_COOKIE['login'] == 'Admin') or  (isset($_SESSION['username']) and $_SESSION['username'] == 'Admin')) {
                                    ?>
                                    <div class="listPostIcons">
                                        <a href="index.php?action=manageView&id=<?=$id?>"><span class="far fa-edit"></span></a>
                                        <a href="index.php?action=deletePost&amp;id=<?= $id?>" onclick="return confirm('Etes-vous sûr?')"><span class="far fa-trash-alt"></span></a>
                                    </div>
                                <?php
                                } ?>
                            </div>
                        </div>
                    </div>
                <?php
                }
            }
            ?>
        </div>
    </div>
</div>

<?php
require('templates/pagination.php');
$content = ob_get_clean();
require('templates/base.php');
?>