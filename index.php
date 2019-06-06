<?php
require('controller/Cfrontend.php');
require('controller/Cbackend.php');

try {
    if (isset($_GET['action'])) {
    //Frontend    
        if ($_GET['action'] == 'listPosts') {
            listPosts();
        }
        elseif ($_GET['action'] == 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                post();
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }
        elseif ($_GET['action'] == 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                    addComment($_GET['id'], $_POST['author'], $_POST['comment']);
                }
                else {
                    throw new Exception('Tous les champs ne sont pas remplis !');
                }
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }


        elseif ($_GET['action'] == 'deleteComment') {
            if (isset($_GET['commentId']) && $_GET['commentId'] > 0) {
                deleteComment($_GET['commentId']);
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }


        elseif ($_GET['action'] == 'reportComment') {
            if (isset($_GET['commentId']) && $_GET['commentId'] > 0) {
                reportComments($_GET['commentId']);
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }



        elseif ($_GET['action'] == 'deletePost') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                deletePost($_GET['id']);
                deleteAllComments($_GET['id']); //delete all the comments related to the post we're deleting with deletePost()
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }
        


        //Backend
        elseif ($_GET['action'] == 'listPostsAdmin') {
            listPostsAdmin();
        }




        elseif ($_GET['action'] == 'deleteAllSelectedComments') {
            deleteAllSelectedComments(implode(",",$_POST["supprimer"]));
            echo $_POST["supprimer"];
        }




        elseif ($_GET['action'] == 'manageComments') {
            listAllComments();
        }

        elseif ($_GET['action'] == 'approveComment') {
            approveComments($_GET['commentId']);
        }
        elseif ($_GET['action'] == 'publishChapter') {
            newPost($_POST['title'], $_POST['postContent']);
        }

        elseif ($_GET['action'] == 'displayPublishView') {
            displayPublishView();
        }

        elseif ($_GET['action'] == 'manageView') {
            displayPostToEdit($_GET['id']);
        }
        
        elseif ($_GET['action'] == 'updatePost') {
            updatePost($_POST['title'], $_POST['postContent'], $_GET['id']);
        }

    }


    //Default behavior
    else {
        listPosts();
    }
}
catch(Exception $e) {
    $errorMessage = $e->getMessage();
    require('view/errorView.php');

}