<?php 
$id = $post->id(); //gets the id of the post to use in buttons "read more" & "comments" urls
$chapter = $post->chapterNb();
$content = $post->content();
$postTitle = $post->title();
$editDate = $post->modEditDate();
$publishDate = $post->modPublishDate(); 



$title = $postTitle;

ob_start(); ?>

			<!-- Page Header -->
			<div id="post-header" class="page-header">
				<div class="background-img" style="background-image: url('public/img/post-<?= $id?>.jpg');"></div>
				<div class="container">
					<div class="row">
						<div class="col-md-10">
							<h1><?= htmlspecialchars($postTitle) ?></h1>
						</div>
					</div>
				</div>
			</div>
			<!-- /Page Header -->
		</header>
		<!-- /Header -->
           
		<!-- section -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- Post content -->
					<div class="col-md-8">
						<div class="section-row sticky-container">
							<div class="main-post">
							<div class="post-meta">
								<span class="post-date">
								<?php 
								if($publishDate ==  $editDate )
								{
								echo '<p>Publié le '. $publishDate . '</p>';
								}
								else
								{
									echo '<p>Edité le '. $editDate . '</p>';
								}
								?>
								</span>
							</div>
								<h3><?= htmlspecialchars($chapter) ?></h3>
								<p><?= nl2br($content) ?></p>
								<figure class="figure-img">
									<img class="img-responsive" src="./public/img/post-<?= $id?>.jpg" alt="">
								</figure>
								<?php
								// FIXME: factoriser le code avec l'affichage ou non (1)des boutons modifier / supprimer sur listPostsView et PostView (2) des boutons approuver / supprimer des com sur PostView (3) l'affichage du menu admin de template.php
								if(isset($checkUserRole['groupId']) && $checkUserRole['groupId'] == 1)
								{ 
								?>       
									<a class="adminIcon" href="index.php?action=manageView&id=<?=$post->id()?>"><i class="far fa-edit editBtns"></i></a>
									<a class="adminIcon" href="index.php?action=deletePost&amp;id=<?= $post->id() ?>" onclick="return confirm('Etes-vous sûr?')"><i class="far fa-trash-alt"></i></a>
								<?php
								}  
								?>   	
							</div>
							
						</div>

						<!-- comments -->
						<div class="section-row">
							<div class="section-title">
								<h2 id="commentsAnchor"><?= $totalCom ?> commentaires</h2>
							</div>
							<!-- Comments Pagination -->
							
							<p>Afficher par  
								<a href="index.php?action=post&page=<?= $_GET['page'] ?>&id=<?= $_GET['id'] ?>&sortBy=5#commentsAnchor"><button class="btn btn-info btn-sm"><strong>5</strong></button></a> 
								<a href="index.php?action=post&page=<?= $_GET['page'] ?>&id=<?= $_GET['id'] ?>&sortBy=15#commentsAnchor"><button class="btn btn-info btn-sm"><strong>15</strong></button></a>
								<a href="index.php?action=post&page=<?= $_GET['page'] ?>&id=<?= $_GET['id'] ?>&sortBy=99999999999999999999#commentsAnchor"><button class="btn btn-info btn-sm"><strong>Tous</strong></button></a>
							</p>
							<div class="paginationBlock">
							<?php require('templates/pagination.php'); ?>
							</div>	
							<!-- displays the comments -->
				<?php
				if(!empty($comments)) //needed otherwise gives an error on the postView.php when no comments on the related post
				{   
					for ($i = 0 ; $i < sizeof($comments) ; $i++)
					{
						$idComment = $comments[$i]->id(); //gets the id of the post to use in buttons "read more" & "comments" urls
						$author = $comments[$i]->author();
						$comment = $comments[$i]->comment();
						$commentDate = $comments[$i]->modCommentDate();
						$updateDate = $comments[$i]->modUpdateDate();
						$flag = $comments[$i]->flag();

						if($flag < 9999)
						{
						?>	
							
							<div class="post-comments">
								<div class="media">
									<div class="media-left">
										<img class="media-object" src="./public/img/avatar.png" alt="">
									</div>
									<?php			
												//display reported comments with a red background
										if($flag > 0)
										{
											echo '<div class="media-body reportedComments">
												<p>Commentaire signalé <strong>' . $flag . '</strong> fois.<em> En attente de modération.</em></p>';
										}else
										{
											echo '<div class="media-body">';
										}
										?>
									
														<div class="media-heading">
															<h4><?= htmlspecialchars($author) ?></h4>
															<!-- id= $comment['id'] used to create an anchor on the comment position to be able to display the right comment directly when selected in manageCommentsView.php (be)-->
															<span class="time" id="<?= $id ?>">publié le <?= $commentDate ?>
																<?php
																//also display update_date if comment has been updated by author
																if ($commentDate != $updateDate)
																{ echo ' et modifié le ' . $updateDate;
																}  
																?>
															</span>
															<p></p>
														</div>
														<!-- transform non html links in comments into clickable links-->
														<p><?= nl2br($comment = preg_replace('#http[s]?://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', htmlspecialchars($comment))) ?></p>
												</div>
								</div>


<div class="commentsBtn">
				<?php
                // FIXME: factoriser le code avec l'affichage ou non (1)du formulaire de commentaire (2) du bouton signaler (3) du reste de l'affichage des boutons / menus si loggé en admin / user / pas loggé


				if($flag == 0)
                {
                    if((isset($_COOKIE['login']) AND !empty($_COOKIE['login'])) OR (isset($_SESSION['username']) AND !empty($_SESSION['username'])))
                    {           
                    ?>
                    <a class="reportBtn" href="index.php?action=reportComment&amp;id=<?= $post->id() ?>&amp;commentId=<?= $comments[$i]->id() ?>" onclick="return confirm('Voulez vous vraiment signaler ce commentaire?')"><i class="fas fa-exclamation-triangle"></i></a>

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
                        
                    if(isset($cookieOrSessionUserNAme) AND !empty($cookieOrSessionUserNAme) AND  $cookieOrSessionUserNAme == $author)
                    {           
                    ?>
                    <!-- form only displayed and used to edit an existing comment -->
                    <!-- i add the $comment['id'] in the class name to display only the form on the selected comment -->
                    <div class="editCommentForm<?=$idComment ?>">
                        <form action="index.php?action=updateComment&amp;id=<?= $post->id() ?>&amp;commentId=<?= $idComment ?>" method="post">
                                <!-- <div>
                                <input type="text" id="author" name="author" required hidden value="< ?php $cookieOrSessionUserNAme ?>"/> 
                            </div> -->
                            <div>
                                <label for="comment">Commentaire (700 carac. max)</label><br />
                                <textarea id="comment" name="comment" cols="80" rows="5" maxlength="700" required><?= $comment ?> </textarea>
                            </div>

                            <div>
                            <input type="submit" class="btn-success" value="Sauvegarder mon commentaire"/>
                            </div>
                        </form>
                    </div> 

                    <a href="index.php?action=deleteComment&amp;id=<?= $post->id() ?>&amp;commentId=<?= $idComment ?>" onclick="return confirm('Etes-vous sûr?')"><i class="far fa-trash-alt"></i></a>
                    
                    <button class="far fa-edit editBtns<?=$idComment ?> editCommentBtn<?=$idComment ?>"></button>
                    <script>
                    $(".editBtns<?=$idComment ?>").on("click", function(){
                        $(".editCommentForm<?=$idComment?>, .editCommentBtn<?=$idComment ?>").toggle("slow")
                    })
					</script>
					
                    <?php
                    }
                }
                ?> 

                    <?php
                    // FIXME: factoriser le code avec l'affichage ou non (1)des boutons modifier / supprimer sur listPostsView et PostView (2) des boutons approuver / supprimer des com sur PostView (3) l'affichage du menu admin de template.php 
                    if(isset($checkUserRole['groupId']) && $checkUserRole['groupId'] == 1)
                    {  
                        //display approve button only if comment already reported
                            if($flag > 0)
                        {
                            echo '<a href="index.php?action=approveComment&amp;id=' . $post->id() . '&amp;commentId='. $idComment . '"  onclick="return confirm(\'Approuver ce commentaire ?\')" ><i class="far fa-check-circle"></i></a>' ;
                        }
                                
                    ?>    
                        <!-- gets the commentId as a parameter in the URL of the comment to delete AND the post id to return on the same post after comment has been deleted-->
                        <a href="index.php?action=deleteComment&amp;id=<?= $post->id() ?>&amp;commentId=<?= $idComment ?>" onclick="return confirm('Supprimer ce commentaire ?')"><i class="fas fa-trash"></i></a>
                    <?php
                    }
                    ?> 
</div>								<!-- /comment -->
							</div>
							<?php
						}
					}
				}			
					?>
						</div>
						<!-- /comments -->
					
						<!-- reply -->
						<div class="section-row">
							<div class="section-title">
								<h2>Commenter</h2>
							</div>
							<?php
							// FIXME: factoriser le code avec l'affichage ou non (1)du formulaire de commentaire (2) du bouton signaler (3) du reste de l'affichage des boutons / menus si loggé en admin / user / pas loggé
							if((isset($_COOKIE['login']) AND !empty($_COOKIE['login'])) OR (isset($_SESSION['username']) AND !empty($_SESSION['username'])))
							{           
							?>    
							<form class="post-reply" action="index.php?action=addComment&amp;id=<?= $post->id() ?>" method="post">
								<div class="row">
									<input type="text" id="author" name="author" required hidden value="<?php
									//FIXME : coder une solution plus propre / optimisée
									if((isset($_COOKIE['login']) AND !empty($_COOKIE['login']))){
										echo $_COOKIE['login'];
									}
									else{
										echo $_SESSION['username'];
									}
									
									?>"  />
									
									<div class="col-md-12">
										<div class="form-group">
										<label for="comment">Commentaire (700 carac. max)</label><br />
                						<textarea id="comment" name="comment"  required onkeyup="textCounter(this,'counterPost',700);"></textarea>
										</div>
									</div>
									<!-- Used to count how many characters there is left -->
									<input disabled  maxlength="3" size="3" value="700" id="counterPost">
									<div>
									<input class="primary-button" id="submitComBtn" type="submit" onclick="return confirm('Poster ce commentaire?')" value="Commenter"/>
									</div>
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
						</div>
						<!-- /reply -->
					</div>
					<!-- /Post content -->

					<!-- aside -->
					<div class="col-md-4">
						<!-- post widget -->
						<div class="aside-widget">
							<div class="section-title">
								<h2>Les derniers chapitres</h2>
							</div>

							<?php
        for ($i = 0 ; $i < sizeof($lastPosts) ; $i++)
        {
            $id = $lastPosts[$i]->id(); //gets the id of the post to use in buttons "read more" & "comments" urls
            $chapter = $lastPosts[$i]->chapterNb();
            $content = $lastPosts[$i]->content();
            $lastPostTitle = $lastPosts[$i]->title();
            $editDate = $lastPosts[$i]->modEditDate();
            $publishDate = $lastPosts[$i]->modPublishDate();
        ?>       
							<div class="post post-widget">
								<a class="post-img" href="index.php?action=post&id=<?=$id?>&page=1&sortBy=5"><img src="./public/img/post-<?=$id?>.jpg" alt=""></a>
								<div class="post-body">
									<a href="index.php?action=post&id=<?=$id?>&page=1&sortBy=5"><em class="post-title"><?= htmlspecialchars($chapter) ?></em><br/><p>  <?= htmlspecialchars($lastPostTitle)?></p></a>
									
								<p>
                    <?= substr($content, 0, 300) . "..." ?><br/>
                    <a href="index.php?action=post&id=<?=$id?>&page=1&sortBy=5"><i class="fas fa-book"></i>   Lire la suite</a> 
                </p>  	
								</div>
							</div>
							<?php
							}  
							?>	
						</div>
						<!-- /post widget -->
					</div>
					<!-- /aside -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /section -->

		

		<!-- jQuery Plugins -->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/main.js"></script>

		<?php $content = ob_get_clean(); ?>

<?php require('templates/base.php'); ?>
