<?php
session_start();
require_once('src/controller/SessionController.php');
require_once('src/controller/PostController.php');
require_once('src/controller/CommentController.php');
require_once('src/controller/UserController.php');
require_once('src/controller/StatsController.php');
require_once('src/controller/GeneralController.php');
require_once('src/controller/FormController.php');



try {
    if (isset($_GET['action'])) {

        $sessionController = new SessionController();
        $cookieOrSessionID = $sessionController->checkSession();
    
    //POSTS
        //FRONTEND
        if ($_GET['action'] == 'listPosts' OR $_GET['action'] == '') {
            if (isset($_GET['page']) && $_GET['page'] <= 0) 
            {
                throw new Exception('Cette page n\'existe pas');
               
            }
            else {
                $postController = new PostController;
                $listPosts = $postController->listPosts();
            }    
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
                    $postController = new PostController;
                    $post = $postController->post();
                    
                }
                    
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }


        elseif ($_GET['action'] == 'deletePost') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $postController = new PostController;
                $commentController = new CommentController;

                $postId = $_GET['id']; // pas utile de factoriser ? 
                $deleteAllComments =  $commentController->deleteAllComments($postId); //delete all the comments related to the post we're deleting with deletePost()
                $deletePost = $postController->deletePost($postId);
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }

        //BACKEND
        elseif ($_GET['action'] == 'displayPublishView') {
            $postController = new PostController;
            $displayPublish = $postController->displayPublishView();
        }     

        elseif ($_GET['action'] == 'publishChapter') {
            $postController = new PostController;
            $newPost = $postController->newPost($_POST['chapter'], $_POST['title'], $_POST['postContent']);
        }

        elseif ($_GET['action'] == 'manageView') {
            $postController = new PostController;
            $displayPostToEdit = $postController->displayPostToEdit($_GET['id']); 
        }
    
        elseif ($_GET['action'] == 'updatePost') {
            $postController = new PostController;
            $updatePost = $postController->updatePost($_POST['chapter'], $_POST['title'], $_POST['postContent'], $_GET['id']);
        }


    //COMMENTS
        //FRONTEND
        elseif ($_GET['action'] == 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                //needed to update the user_com_counter in members table
                $sessionController = new SessionController();
                $cookieOrSessionID = $sessionController->checkSession();

                $commentController = new commentController();
                $commentController->addComment($_GET['id'], $_POST['author'], $_POST['comment'], $_GET['id'], $cookieOrSessionID);
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

                //needed to update the userComCounter in members table
                $sessionController = new SessionController();
                $cookieOrSessionID =  $sessionController->checkSession();

                $commentController = new CommentController;
                $deleteComment = $commentController->deleteComment($_GET['commentId'], $_GET['id'], $cookieOrSessionID);
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }

        elseif ($_GET['action'] == 'reportComment') {
            if (isset($_GET['commentId']) && $_GET['commentId'] > 0) {
                
                $commentController = new commentController();
                $sessionController = new sessionController();
                
                //checks in the controler if the member already reported the same comment
                $checkIfReported = $commentController->checkIfReported();
                //needed to checks in the controler if the member already reported the same comment
                $cookieOrSessionID = $sessionController->checkSession();
                $reportCommentsCheck = $commentController->reportCommentsCheck($cookieOrSessionID, $_GET['commentId']); //the reported comment is registered into reported_comments DB
                $reportComments = $commentController->reportComments($_GET['commentId']);    //the reported comment is actually reported in comments DB and BE
            }
            else {
                throw new Exception('Aucun identifiant de commentaire envoyé');
            }
        }
        
        //user can edit his own comment
        elseif ($_GET['action'] == 'updateComment') {
            if (isset($_GET['commentId']) && $_GET['commentId'] > 0) {

                $commentController = new commentController();
                $updateComment = $commentController->updateComment($_POST['comment'],$_GET['commentId']);
            }
            else {
                throw new Exception('Aucun identifiant de commentaire envoyé');
            }
        }

        //BACKEND

        elseif ($_GET['action'] == 'manageComments') {
            $commentController = new commentController();
            $commentController->listAllComments();
        }
        
        //to approve or delete all reported comments
        elseif ($_GET['action'] == 'manageAllSelectedComments') {
            if(isset($_POST['deleteSelectedComments'])){
                $commentController = new commentController();
                $commentController->deleteAllSelectedComments($_POST['selectComments']); // j'essaie de récupérer le tableau de commentsView.php 
            }
            elseif(isset($_POST['approveSelectedComments'])){
                $commentController = new commentController();
                $commentController->approveAllSelectedComments($_POST['selectComments']);
            }
            else{
                throw new Exception('Il y a une erreur');
            }  
        }

        //to publish or delete all new comments
        elseif ($_GET['action'] == 'publishAllSelectedComments') {
            if(isset($_POST['deleteSelectedComments'])){
                $commentController = new commentController();
                $commentController->deleteAllSelectedComments($_POST['selectPublishComments']); // j'essaie de récupérer le tableau de commentsView.php 
            }
            elseif(isset($_POST['publishSelectedComments'])){
                $commentController = new commentController();
                $commentController->approveAllSelectedComments($_POST['selectPublishComments']);
            }
            else{
                throw new Exception('Il y a une erreur');
            }  
        }
    
        elseif ($_GET['action'] == 'approveComment') {
            $commentController = new commentController();
            $commentController->approveComments($_GET['commentId']);
        }




    //SING IN, LOG IN, LOG OUT
        //SIGN IN
        elseif ($_GET['action'] == 'singIn') {
            $sessionController = new SessionController;
            $displaySingInView = $sessionController->displaySingInView();
        }

        elseif ($_GET['action'] == 'addNewMember') {
            //testing if all fields a filled
            if (isset($_POST['username']) && isset($_POST['pass']) && isset($_POST['passCheck']) && isset($_POST['email'])) {
                //to avoid problems with inputs
                $_POST['username'] = htmlspecialchars($_POST['username']);
                $_POST['pass'] = htmlspecialchars($_POST['pass']);
                $_POST['passCheck'] = htmlspecialchars($_POST['passCheck']);
                $_POST['email'] = htmlspecialchars($_POST['email']);
                $accentedCharacters = "àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ";
                
                //testing if username only has authorised caracters and length  
                if (preg_match("#^[a-z".$accentedCharacters ."0-9]{4,20}$#i",$_POST['username']))
                {
                    //testing if passwords is conform
                    if (preg_match("#^[a-z".$accentedCharacters ."0-9._!?-]{8,20}$#i",$_POST['pass']) ){
                        //testing if both passwords match
                        if($_POST['pass'] == $_POST['passCheck']){
                            
                            //testing if email is conform
                            if( preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#i", $_POST['email']))
                            {
                                //hash password (security feature)
                                $_POST['pass'] = password_hash($_POST['pass'], PASSWORD_DEFAULT);
                                //check if username of email are already taken

                                $sessionController = new SessionController;

                                if( $checkUsernameAvailability = $sessionController->checkUsernameAvailability($_POST['username']) == false){
                                    if($checkEmailAvailability = $sessionController->checkEmailAvailability($_POST['email']) == false){

                                       
                                        $addNewMember = $sessionController->addNewMember($_POST['username'], $_POST['pass'], $_POST['email']);
                                    }
                                    else
                                     {
                                         throw new Exception('Cette adresse email n\'est pas disponible'); 
                                     }
                                }
                                else
                                 {
                                     throw new Exception('Ce pseudo n\'est pas disponible'); 
                                 }
   
                            }
                            else{
                                throw new Exception('L\'adresse email n\'est pas conforme'); 
                            } 
                        }
                        else{
                            throw new Exception('Les deux mots de passe ne sont pas identiques');   
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

        //LOG IN
        elseif ($_GET['action'] == 'logInCheck') {
            if(isset($_POST['username']) && isset($_POST['pass'])){
                $sessionController = new SessionController;
                $checkLog = $sessionController->checkLog($_POST['username']);
                
                //if there is a session open, displays a message        
                if (isset($_SESSION['id']) AND isset($_SESSION['username']))
                {
                    require('templates/front/menu.php');
                }  
            }
            else{
                throw new Exception('Vérifiez vos identifiants de connexion');   
            }
        }

        //LOG OUT
        elseif ($_GET['action'] == 'logOutCheck') {
            if(isset($_SESSION['id']) AND isset($_SESSION['username'])){
                
                $sessionController = new SessionController;
                $killSession = $sessionController->killSession();
                
                header('Location: index.php');
                exit;
            }
            else{
                throw new Exception('Vous êtes déja déconnecté');   
            }
        }

        //UPDATE PASSWORD
        elseif ($_GET['action'] == 'changePasswordView') {
            if( (isset($_COOKIE['login']) AND $_COOKIE['login'] != '') OR  (isset($_SESSION['username']) AND $_SESSION['username'] != ''))
            {
                $sessionController = new SessionController;
                $displaychangePasswordView = $sessionController->displaychangePasswordView();
            }     
            else {
                throw new Exception('Vous devez être connecté pour accéder à cette page');
            }    
        }
        elseif ($_GET['action'] == 'UpdatePass') 
        {
            if( (isset($_COOKIE['login']) AND $_COOKIE['login'] != '') OR  (isset($_SESSION['username']) AND $_SESSION['username'] != ''))
            {
                //to avoid problems with inputs
                $_POST['currentPass'] = htmlspecialchars($_POST['currentPass']);
                $_POST['newPass'] = htmlspecialchars($_POST['newPass']);
               
                $accentedCharactersNewPass = "àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ";
                //needed to check the current pass in DB from the right user (id) 
                $sessionController = new SessionController();
                $cookieOrSessionID = $sessionController->checkSession();
                if($checkCurrentPass = $sessionController->checkCurrentPass($cookieOrSessionID) == true)   
                {
                    if(preg_match("#^[a-z".$accentedCharactersNewPass ."0-9._!?-]{8,20}$#i", $_POST['newPass']) )
                    {
                        //if the password is Correct check if current and new pass are the same
                        if($_POST['currentPass'] != $_POST['newPass'])
                        {
                            //hash password (security feature)
                            $_POST['newPass'] = password_hash($_POST['newPass'], PASSWORD_DEFAULT);
                
                            $sessionController = new SessionController;
                            $UpdatePassWord = $sessionController->UpdatePassWord($_POST['newPass'], $_POST['id']);
                            $killSession = $sessionController->killSession();
                            //success2 needed to display the confirmation message
                            header('Location: index.php?success=2#header');
                            exit;
                        }
                        else
                        {
                            throw new Exception('Votre nouveau password est le même que l\'actuel');
                        }
                    }
                    else
                    {
                        throw new Exception('Votre nouveau password n\'est pas conforme');
                    }                    
                }
                else {
                    throw new Exception('Votre password actuel n\'est pas le bon');
                } 
            }     
            else {
                throw new Exception('Vous devez être connecté pour accéder à cette page');
            }   
        }



    //USERS
        elseif ($_GET['action'] == 'manageUsers') {

            
            if(!isset($_GET['page']) OR !isset($_GET['sortBy']) OR $_GET['page']<1 OR $_GET['sortBy']<1)
            { 
                throw new Exception('Il manque le numéro de page ou le classement des utilisateurs');
            }
            else{
                $userController = new UserController;
                $listAllUsers = $userController->listAllUsers();
            }   
        }

        //to delete all selected users
        elseif ($_GET['action'] == 'manageAllSelectedUsers') {
            if(isset($_POST['deleteSelectedUsers'])){
                $userController = new UserController;
                $deleteAllSelectedUsers = $userController->deleteAllSelectedUsers($_POST['selectUsers']);  
            }
            else{
                throw new Exception('Il y a une erreur');
            }  
        }
        
        //to update role
        elseif ($_GET['action'] == 'updateRole') {
            if(isset($_GET['role'])){
                $userController = new UserController;
                $updateUserRole = $userController->updateUserRole($_GET['role'], $_GET['userID']);  
            }
            else{
                throw new Exception('Il y a une erreur');
            }  
        }

        elseif ($_GET['action'] == 'deleteUser') {
            if (isset($_GET['userID']) && $_GET['userID'] > 0) {
                $userController = new UserController;
                $deleteUser = $userController->deleteUser($_GET['userID']);
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }



    //STATISTICS
        elseif ($_GET['action'] == 'displayStatsView') {
            $statsController = new StatsController;
            $displayStatsView = $statsController->displayStatsView();
        }


    //ABOUT
        elseif ($_GET['action'] == 'about') {
            $generalController = new GeneralController;
            $generalController->displayAboutView();
        }
        
    //CONTACT
        elseif ($_GET['action'] == 'contact') {
            $formController = new FormController;
            $formController->displayContactView();
        }

        elseif ($_GET['action'] == 'sendMessage') {
   
            //testing if all fields a filled
            if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['contactEmail']) && isset($_POST['topic']) && isset($_POST['messageContent'])) 
            {
                //to avoid problems with inputs
                $_POST['firstName'] = htmlspecialchars($_POST['firstName']);
                $_POST['lastName'] = htmlspecialchars($_POST['lastName']);
                $_POST['contactEmail'] = htmlspecialchars($_POST['contactEmail']);
                $_POST['topic'] = htmlspecialchars($_POST['topic']);
                $_POST['messageContent'] = htmlspecialchars($_POST['messageContent']);
                $accentedCharacters = "àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ";
                
                //testing if firstName only has authorised caracters   
                if (preg_match("#^[a-z". $accentedCharacters ."]+[' -]?[a-z". $accentedCharacters ."]+$#i",$_POST['firstName']))
                {
                    //testing if lastName only has authorised caracters
                    if (preg_match("#^[a-z". $accentedCharacters ."]+[' -]?[a-z". $accentedCharacters ."]+$#i",$_POST['lastName']))
                    {
                        //testing if email is conform
                        if( preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#i", $_POST['contactEmail']))
                        { 
                            //testing if topic is conform
                            if (preg_match("#^[a-z". $accentedCharacters ."(' \-)*]+[a-z". $accentedCharacters ."]+$#i",$_POST['topic']))
                            {
                                $formController = new FormController;
                                $formController->sendMessage($_POST['firstName'], $_POST['lastName'], $_POST['contactEmail'], $_POST['topic'],  $_POST['messageContent']);
                            }
                            else{
                                throw new Exception('L\'intitulé n\'est pas conforme'); 
                            } 
                        }
                        else{
                            throw new Exception('L\'adresse email n\'est pas conforme');   
                        }
                    }
                    else{
                        throw new Exception('Le nom n\'est pas conforme.');
                    }    
                }
                else{
                    throw new Exception('Le prénom n\'est pas conforme.');
                }
            }
            else {
                throw new Exception('Il manque des informations.');
            }      
        }     

    }

//DEFAULT BEHAVIOR
    else {
        if (isset($_GET['page']) && $_GET['page'] <= 0) 
            {
                throw new Exception('Cette page n\'existe pas');
               
            }
            else {
                $postController = new PostController;
                $listPosts = $postController->listPosts();
            }   
    }
}

//ERROR BEHAVIOR
catch(Exception $e) {
    $errorMessage = $e->getMessage();
    require('templates/errorView.php');

}
?>
