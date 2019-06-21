<?php
session_start();
require('src/controller/PostController.php');
require('src/controller/UserController.php');
require('src/controller/StatsController.php');



try {
    if (isset($_GET['action'])) {
    //FRONTEND
    
        //POSTS
        if ($_GET['action'] == 'listPosts' OR $_GET['action'] == '') {
            $PostController = new PostController;
            $listPosts = $PostController->listPosts();
        }

        elseif ($_GET['action'] == 'post') 
        {
            if (isset($_GET['id']) && $_GET['id'] > 0) 
            {
                if(!isset($_GET['page']) OR !isset($_GET['id']) OR !isset($_GET['sortBy']) OR $_GET['page']<1 OR $_GET['id']<1 OR $_GET['sortBy']<1)
                    { 
                        throw new Exception('Il manque le numéro de page, du billet ou la classement des commentaires');
                    }
                    else{
                        $PostController = new PostController;
                        $post = $PostController->post();
                    }
                    
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }


        elseif ($_GET['action'] == 'deletePost') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $PostController = new PostController;

                $postId = $_GET['id']; // pas utile de factoriser ? 
                // deleteAllComments($postId); //delete all the comments related to the post we're deleting with deletePost()
                $deletePost = $PostController->deletePost($postId);
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }



     //BACKEND
        //POSTS
        elseif ($_GET['action'] == 'displayPublishView') {
            $PostController = new PostController;
            $displayPublish = $PostController->displayPublishView();
        }     

        elseif ($_GET['action'] == 'publishChapter') {
            $PostController = new PostController;
            $newPost = $PostController->newPost($_POST['chapter'], $_POST['title'], $_POST['postContent']);
        }

        elseif ($_GET['action'] == 'manageView') {
            $PostController = new PostController;
            $displayPostToEdit = $PostController->displayPostToEdit($_GET['id']); 
        }
    
        elseif ($_GET['action'] == 'updatePost') {
            $PostController = new PostController;
            $updatePost = $PostController->updatePost($_POST['chapter'], $_POST['title'], $_POST['postContent'], $_GET['id']);
        }



        //USERS
        elseif ($_GET['action'] == 'manageUsers') {
            if(!isset($_GET['page']) OR !isset($_GET['sortBy']) OR $_GET['page']<1 OR $_GET['sortBy']<1)
            { 
                throw new Exception('Il manque le numéro de page ou le classement des utilisateurs');
            }
            else{
                $UserController = new UserController;
                $listAllUsers = $UserController->listAllUsers();
            }   
        }

        //to delete all selected users
        elseif ($_GET['action'] == 'manageAllSelectedUsers') {
            if(isset($_POST['deleteSelectedUsers'])){
                $UserController = new UserController;
                $deleteAllSelectedUsers = $UserController->deleteAllSelectedUsers($_POST['selectUsers']);  
            }
            else{
                throw new Exception('Il y a une erreur');
            }  
        }
        //to update role
        elseif ($_GET['action'] == 'updateRole') {
            if(isset($_GET['role'])){
                $UserController = new UserController;
                $updateUserRole = $UserController->updateUserRole($_GET['role'], $_GET['userID']);  
            }
            else{
                throw new Exception('Il y a une erreur');
            }  
        }
        elseif ($_GET['action'] == 'deleteUser') {
            if (isset($_GET['userID']) && $_GET['userID'] > 0) {
                $UserController = new UserController;
                $deleteUser = $UserController->deleteUser($_GET['userID']);
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }

        //STATISTICS
        elseif ($_GET['action'] == 'displayStatsView') {
            $StatsController = new StatsController;
            $displayStatsView = $StatsController->displayStatsView();
        }

    }    
    //DEFAULT BEHAVIOR
    else {
        $PostController = new PostController;
        $listPosts = $PostController->listPosts();

        



    }
}

//ERROR BEHAVIOR
catch(Exception $e) {
    $errorMessage = $e->getMessage();
    require('templates/errorView.php');

}
?>
