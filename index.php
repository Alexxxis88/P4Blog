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

                // NOT WORKING : show more / less comments
            //    if (isset($_GET['showComments'])){ 
            //     post($_GET['showComments']);
            //    }
            //    else{
            //     post(2); 
            //    }
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
        
        //SING IN, LOG IN, LOG OUT

        elseif ($_GET['action'] == 'singIn') {
            
            displaySingInView();
        }

        elseif ($_GET['action'] == 'addNewMember') {

           
            //testing if all fields a filled
            if (isset($_POST['username']) && isset($_POST['pass'])&& isset($_POST['passCheck']) && isset($_POST['email'])) {

                //to avoid problems with inputs
                $_POST['username'] = htmlspecialchars($_POST['username']);
                $_POST['pass'] = htmlspecialchars($_POST['pass']);
                $_POST['passCheck'] = htmlspecialchars($_POST['passCheck']);
                $_POST['email'] = htmlspecialchars($_POST['email']);

    
                //testing if username only has authorised caracters   
                if (preg_match("#^[a-z0-9]{4,}$#",$_POST['username']))
                {
                    //testing if passwords is conform
                    if (preg_match("#^[a-z0-9._!?-]{8,}$#",$_POST['pass']) ){

                        //testing if both passwords match
                        if($_POST['pass'] == $_POST['passCheck']){
                            
                            //testing if email is conform
                            if( preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email']))
                            {

                                addNewMember($_POST['username'], $_POST['pass'], $_POST['email']);
                            }
                            else{
                                throw new Exception('L\'adresse email n\'est pas conforme'); 
                            } 
                        }
                        else{
                            throw new Exception('Les deux mots de pass ne sont pas identiques');   
                        }
                    }
                    else{
                        throw new Exception('Le mot de passe n\'est pas conforme.');
                    }    
                }
                else{
                    throw new Exception('Le pseudo n\'est pas conforme.');
                }
            }
            else {
                throw new Exception('Il manque des informations.');
            }   
            
        }

        


        //Backend
        elseif ($_GET['action'] == 'listPostsAdmin') {
            listPostsAdmin();
            // nbOfReportedComments(); NOT WORKING : display number of comments working
        }

        elseif ($_GET['action'] == 'manageComments') {
            
            listResportedComments();
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