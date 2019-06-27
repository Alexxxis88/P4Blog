<?php $title = 'Gestion des commentaires'; ?>

<?php ob_start(); ?>

<div class="container">
        <!-- REPORTED COMMENTS -->
        <section id="sectionReported">
                <div class="row manageComBtns">
                        <div class="col-md-12">
                               <a class="manageComBtn js-scrollTo" href="#sectionNewCom"><i class="fas fa-anchor"></i> Voir les commentaires à publier</a>
                        </div>        
                </div> 
                <h2 class="titleManageCom">Commentaires signalés</h2>
                <form action="index.php?action=manageAllSelectedComments" method="post"> 
                        <input type="checkbox" id="checkAllReported" checked>
                        <label for="checkAllReported"> Tout sélectionner / désélectionner </label>
                        <input type="submit" class="btn btn-danger btn-sm" name="deleteSelectedComments[]" value="Supprimer" onclick="return confirm('Supprimer tous ces commentaires ?')">
                        <input type="submit" class="btn btn-successs btn-sm" name="approveSelectedComments[]" value="Approuver" onclick="return confirm('Approuver tous ces commentaires ?')">
                <?php
                        //je déclare un tableau vide qui va me servir a stocker tous les ids des commentaires signalés
                        $arrayComments = array();
                if(!empty($reportedComments)) //needed otherwise gives an error on the commentsView.php when no comments reported
                {       
                for ($i = 0 ; $i < sizeof($reportedComments) ; $i++)
                {

                        $idComment = $reportedComments[$i]->id(); //gets the id of the post to use in buttons "read more" & "comments" urls
                        $postId = $reportedComments[$i]->postId();
                        $author = $reportedComments[$i]->author();
                        $comment = $reportedComments[$i]->comment();
                        $commentDate = $reportedComments[$i]->modCommentDate();
                        $updateDate = $reportedComments[$i]->modUpdateDate();
                        $flag = $reportedComments[$i]->flag();

                        
                ?>


                                <div class="reportedComments">
                                <p class="commentHead"><input type="checkbox" id="commentID" name="selectComments[]" value="<?= $idComment?>" checked >
                                        Le commentaire de <strong><?= htmlspecialchars($author) ?></strong> du <?= $commentDate ?>
                                        a été signalé <strong> <?= $flag ?></strong> fois </p>

                                        <!-- transform non html links in comments into clickable links--> 
                                        <p><?= nl2br($comment = preg_replace('#http[s]?://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', htmlspecialchars($comment))) ?></p>
                                        <div class="manageComIcons">
                                                <div class="viewComArticle">
                                                        <p><a href="index.php?action=post&id=<?= $postId?>&page=1&sortBy=5"><i class="fas fa-eye"></i> Voir l'article associé</a> 
                                                        </p>

                                                        <!-- sends straight to the right comment using the comment id as an anchor -->
                                                        <p><a href="index.php?action=post&id=<?= $postId?>&page=1&sortBy=99999999999999999999#<?= $idComment?>"><i class="far fa-comment-dots"></i> Voir le commentaire</a> </p>
                                                </div>
                                                
                                                <div class="approvDelComs">
                                                <a href="index.php?action=approveComment&amp;commentId=<?= $idComment ?>"  onclick="return confirm('Approuver ce commentaire ?')" ><i class="far fa-check-square"></i>  Approuver</a>

                                                <a href="index.php?action=deleteComment&amp;id=<?= $postId ?>&amp;commentId=<?= $idComment ?>" onclick="return confirm('Supprimer ce commentaire ?')"><i class="far fa-trash-alt"></i> Supprimer</a>
                                                </div>
                                        </div>
                                
                                </div>
                        <?php
                        
                        //pour chaque commentaire, je rajoute son id dans le tableau $arrayComments
                        array_push($arrayComments, $idComment);
                
                }
                }
                ?>        
                </form>

                <!-- Select / Deselect all checkboxes (for Reported comments)  -->   
                        <script>
                        $('#checkAllReported').change(function(){
                                $('input[type=checkbox][id=commentID]').prop('checked', $(this).prop('checked'))
                        })
                        </script>

                <!-- displays a message if no reported comments -->   
                <div class="noReportedComments">Il n'y a pas de commentaire signalé</div>
                        <script>
                                if ( !$.trim($('.reportedComments').html() ).length ) 
                                {
                                        $('.noReportedComments').css("display", "block");
                                } else {
                                        $('.noReportedComments').css("display", "none");
                                }
                </script>
        </section>
        
        <!-- NEW COMMENTS -->   
        <section id="sectionNewCom">
                <div class="row manageComBtns">
                        <div class="col-md-12">
                                <a class="manageComBtn js-scrollTo" href="#sectionReported"><i class="fas fa-anchor"></i> Voir les commentaires signalés</a>
                        </div>        
                </div>                      
                <h2 class="titleManageCom">Commentaires à publier</h2>
                <form action="index.php?action=publishAllSelectedComments" method="post"> 
                        <input type="checkbox" id="checkAllToPublish" checked>
                        <label for="checkAllToPublish"> Tout sélectionner / désélectionner </label>
                        <input type="submit" class="btn btn-danger btn-sm" name="deleteSelectedComments[]" value="Supprimer" onclick="return confirm('Supprimer tous ces commentaires ?')">
                        <input type="submit" class="btn btn-successs btn-sm" name="publishSelectedComments[]" value="Publier" onclick="return confirm('Approuver tous ces commentaires ?')">
                <?php
                //je déclare un tableau vide qui va me servir a stocker tous les ids des commentaires signalés
                $arrayPublish = array();

                if(!empty($newComments)) //needed otherwise gives an error on the commentsView.php when no new comments to manage
                {
                for ($i2 = 0 ; $i2 < sizeof($newComments) ; $i2++)
                { 
                        $idComment = $newComments[$i2]->id(); //gets the id of the post to use in buttons "read more" & "comments" urls
                        $postId = $newComments[$i2]->postId();
                        $author = $newComments[$i2]->author();
                        $comment = $newComments[$i2]->comment();
                        $commentDate = $newComments[$i2]->modCommentDate();
                ?>

                        
                <div class="acceptDenyComments">
                        <p class="newCommentHead"> <input type="checkbox" id="commentPublishID" name="selectPublishComments[]" value="<?= $idComment?>" checked > <strong><?= htmlspecialchars($author) ?></strong> a posté le <?= $commentDate ?>
                        
                        <!-- transform non html links in comments into clickable links--> 
                        <p><?= nl2br($comment = preg_replace('#http[s]?://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', htmlspecialchars($comment))) ?></p>
                        <div class="manageComIcons">
                                <div class="viewComArticle">
                                        <p><a href="index.php?action=post&id=<?= $postId?>&page=1&sortBy=5"><i class="fas fa-eye"></i> Voir l'article associé</a> </p>
                                </div>                
                                
                                <div class="approvDelComs">
                                        <a href="index.php?action=approveComment&amp;commentId=<?= $idComment ?>"  onclick="return confirm('Publier ce commentaire ?')" ><i class="far fa-check-square"></i> Publier</a>

                                        <a href="index.php?action=deleteComment&amp;id=<?= $postId ?>&amp;commentId=<?= $idComment ?>" onclick="return confirm('Supprimer ce commentaire ?')"><i class="far fa-trash-alt"></i> Supprimer</a>
                                </div>
                        </div>
                </div>
        <?php
                        
        //pour chaque commentaire à publier, je rajoute son id dans le tableau $arrayPublish
        array_push($arrayPublish, $idComment);

        }
        }    
        ?>           
                </form>
        <!-- Select / Deselect all checkboxes (for Reported comments)  -->   
        <script>
                $('#checkAllToPublish').change(function(){
                        $('input[type=checkbox][id=commentPublishID]').prop('checked', $(this).prop('checked'))
                })
                </script>

        <!-- displays a message if no new comments -->   
        <div class="noCommentsToManage">Il n'y a pas de commentaire à publier</div>
                <script>
                        if ( !$.trim($('.acceptDenyComments').html() ).length ) 
                        {
                                $('.noCommentsToManage').css("display", "block");
                        } else {
                                $('.noCommentsToManage').css("display", "none");
                        }
        </script>          

        </section>
</div>

        

         

          
        


 <!-- displays a message if no new comments -->   
        <script>
                if ( !$.trim($('.reportedComments, .acceptDenyComments').html() ).length ) 
                {
                        $('.comAlert').css("display", "none");
                } else {
                        $('.comAlert').css("display", "block");
                }
       </script>    

        <script>
        //Smooth Scroling
        $(document).ready(function() {
        $(".js-scrollTo").on("click", function() {
                let section = $(this).attr("href");
                let speed = 750;
                $("html").animate( { scrollTop: $(section).offset().top }, speed );
                return ;
        });
        });
        </script>
   
<?php $content = ob_get_clean(); ?>

<?php require('templates/base.php'); ?>


