<?php
$title = 'Gestion des commentaires';
ob_start();
?>
        <div class="container">
                <!-- REPORTED COMMENTS -->
                <section id="sectionReported">
                        <div class="row manageComBtns">
                                <div class="col-md-12">
                                <a class="manageComBtn js-scrollTo" href="#sectionNewCom"><span class="fas fa-anchor"></span> Voir les commentaires à publier</a>
                                </div>
                        </div>
                        <h2 class="titleManageCom">Commentaires signalés</h2>
                        <form action="index.php?action=manageAllSelectedComments" method="post">
                                <input type="checkbox" id="checkAllReported" checked>
                                <label for="checkAllReported"> Tout sélectionner / désélectionner </label>
                                <input type="submit" class="btn btn-danger btn-sm" name="deleteSelectedComments[]" value="Supprimer" onclick="return confirm('Supprimer tous ces commentaires ?')">
                                <input type="submit" class="btn btn-successs btn-sm" name="approveSelectedComments[]" value="Approuver" onclick="return confirm('Approuver tous ces commentaires ?')">

                                <?php
                                //arrayComments will stock every reported comment's id
                                $arrayComments = array();
                                if (!empty($reportedComments)) { //needed otherwise gives an error on the commentsView.php when no comments reported
                                        for ($i = 0 ; $i < sizeof($reportedComments) ; $i++) {
                                                $idComment = $reportedComments[$i]->id(); //gets the id of the post to use in buttons "View comment" & "View related post" urls
                                                $postId = $reportedComments[$i]->postId();
                                                $author = $reportedComments[$i]->author();
                                                $comment = $reportedComments[$i]->comment();
                                                $commentDate = $reportedComments[$i]->modCommentDate();
                                                $updateDate = $reportedComments[$i]->modUpdateDate();
                                                $flag = $reportedComments[$i]->flag(); ?>
                                                <div class="reportedComments">
                                                        <p class="commentHead"><input type="checkbox" id="commentID" name="selectComments[]" value="<?= $idComment?>" checked >
                                                        Le commentaire de <strong><?= htmlspecialchars($author) ?></strong> du <?= $commentDate ?>
                                                        a été signalé <strong> <?= $flag ?></strong> fois </p>

                                                        <!-- transform non html links in comments into clickable links-->
                                                        <p><?= nl2br($comment = preg_replace('#http[s]?://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', htmlspecialchars($comment))) ?></p>
                                                        <div class="manageComIcons">
                                                                <div class="viewComArticle">
                                                                        <p><a href="index.php?action=post&id=<?= $postId?>&page=1&sortBy=5"><span class="fas fa-eye"></span> Voir l'article associé</a>
                                                                        </p>

                                                                        <!-- sends straight to the right comment using the comment id as an anchor -->
                                                                        <p><a href="index.php?action=post&id=<?= $postId?>&page=1&sortBy=99999999999999999999#<?= $idComment?>"><span class="far fa-comment-dots"></span> Voir le commentaire</a> </p>
                                                                </div>
                                                                <div class="approvDelComs">
                                                                <a href="index.php?action=approveComment&amp;commentId=<?= $idComment ?>"  onclick="return confirm('Approuver ce commentaire ?')" ><span class="far fa-check-square"></span>  Approuver</a>

                                                                <a href="index.php?action=deleteComment&amp;id=<?= $postId ?>&amp;commentId=<?= $idComment ?>" onclick="return confirm('Supprimer ce commentaire ?')"><span class="far fa-trash-alt"></span> Supprimer</a>
                                                                </div>
                                                        </div>
                                                </div>
                                                <?php
                                                //for each comment, its id is added to $arrayComments
                                                array_push($arrayComments, $idComment);
                                        }
                                }
                                ?>
                        </form>
                        <!-- displays a message if no reported comments -->
                        <div class="noReportedComments">Il n'y a pas de commentaire signalé</div>
                </section>

                <!-- NEW COMMENTS -->
                <section id="sectionNewCom">
                        <div class="row manageComBtns">
                                <div class="col-md-12">
                                        <a class="manageComBtn js-scrollTo" href="#sectionReported"><span class="fas fa-anchor"></span> Voir les commentaires signalés</a>
                                </div>
                        </div>
                        <h2 class="titleManageCom">Commentaires à publier</h2>
                        <form action="index.php?action=publishAllSelectedComments" method="post">
                                <input type="checkbox" id="checkAllToPublish" checked>
                                <label for="checkAllToPublish"> Tout sélectionner / désélectionner </label>
                                <input type="submit" class="btn btn-danger btn-sm" name="deleteSelectedComments[]" value="Supprimer" onclick="return confirm('Supprimer tous ces commentaires ?')">
                                <input type="submit" class="btn btn-successs btn-sm" name="publishSelectedComments[]" value="Publier" onclick="return confirm('Approuver tous ces commentaires ?')">

                                <?php
                                //arrayPublish will stock every reported comment's id
                                $arrayPublish = array();
                                if (!empty($newComments)) { //needed otherwise gives an error on the commentsView.php when no new comments to manage
                                        for ($i2 = 0 ; $i2 < sizeof($newComments) ; $i2++) {
                                                $idComment = $newComments[$i2]->id(); //gets the id of the post to use in buttons "read more" & "comments" urls
                                                $postId = $newComments[$i2]->postId();
                                                $author = $newComments[$i2]->author();
                                                $comment = $newComments[$i2]->comment();
                                                $commentDate = $newComments[$i2]->modCommentDate(); ?>
                                                <div class="acceptDenyComments">
                                                        <p class="newCommentHead"> <input type="checkbox" id="commentPublishID" name="selectPublishComments[]" value="<?= $idComment?>" checked > <strong><?= htmlspecialchars($author) ?></strong> a posté le <?= $commentDate ?></p>

                                                        <!-- transform non html links in comments into clickable links-->
                                                        <p><?= nl2br($comment = preg_replace('#http[s]?://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', htmlspecialchars($comment))) ?></p>
                                                        <div class="manageComIcons">
                                                                <div class="viewComArticle">
                                                                        <p><a href="index.php?action=post&id=<?= $postId?>&page=1&sortBy=5"><span class="fas fa-eye"></span> Voir l'article associé</a> </p>
                                                                </div>
                                                                <div class="approvDelComs">
                                                                        <a href="index.php?action=approveComment&amp;commentId=<?= $idComment ?>"  onclick="return confirm('Publier ce commentaire ?')" ><span class="far fa-check-square"></span> Publier</a>

                                                                        <a href="index.php?action=deleteComment&amp;id=<?= $postId ?>&amp;commentId=<?= $idComment ?>" onclick="return confirm('Supprimer ce commentaire ?')"><span class="far fa-trash-alt"></span> Supprimer</a>
                                                                </div>
                                                        </div>
                                                </div>
                                                <?php
                                                //for each comment, its id is added to $arrayPublish
                                                array_push($arrayPublish, $idComment);
                                        }
                                }
                        ?>
                        </form>
                        <!-- displays a message if no new comments -->
                        <div class="noCommentsToManage">Il n'y a pas de commentaire à publier</div>
                </section>
        </div>
<?php
$content = ob_get_clean();
require('templates/base.php');
?>


