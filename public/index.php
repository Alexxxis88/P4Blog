<?php
session_start();
require_once('src/controller/SessionController.php');
require_once('src/controller/PostController.php');
require_once('src/controller/CommentController.php');
require_once('src/controller/UserController.php');
require_once('src/controller/StatsController.php');
require_once('src/controller/GeneralController.php');
require_once('src/controller/FormController.php');

//AUTOLOAD
function classAutoLoad($class)
{
    require 'src/entity/' . $class . '.php';
}
spl_autoload_register('classAutoLoad');


try {
    if (isset($_GET['action'])) {
        $sessionController = new SessionController();
        $sessionController->checkSession();

        //POSTS
        //FRONTEND
        if ($_GET['action'] == 'listPosts' or $_GET['action'] == '') {
            if (isset($_GET['page']) && $_GET['page'] <= 0) {
                throw new Exception('Cette page n\'existe pas');
            } else {
                $postController = new PostController;
                $postController->listPosts();
            }
        }
        elseif ($_GET['action'] == 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (!isset($_GET['page']) or !isset($_GET['id']) or !isset($_GET['sortBy']) or $_GET['page']<1 or $_GET['id']<1 or $_GET['sortBy']<1) {
                    throw new Exception('Il manque le numéro de page, du billet ou la classement des commentaires');
                } else {
                    $postController = new PostController;
                    $postController->post();
                }

                //Confirmation message when posting a comment
                if (isset($_GET['success']) and $_GET['success'] == 4) {
                    include('templates/success-messages/success4.html');
                }

                //Confirmation message when updating a comment
                if (isset($_GET['success']) and $_GET['success'] == 5) {
                    include('templates/success-messages/success5.html');
                }
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }
        elseif ($_GET['action'] == 'deletePost') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $postController = new PostController;
                $commentController = new CommentController;

                $commentController->deleteAllComments($_GET['id']); //delete all the comments related to the post we're deleting with deletePost
                $postController->deletePost($_GET['id']);
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }

        //BACKEND
        elseif ($_GET['action'] == 'displayPublishView') {
            $postController = new PostController;
            $postController->displayPublishView();
        }
        elseif ($_GET['action'] == 'publishChapter') {
            $postController = new PostController;
            $postController->newPost($_POST['chapter'], $_POST['title'], $_POST['postContent']);
        }
        elseif ($_GET['action'] == 'manageView') {
            $postController = new PostController;
            $postController->displayPostToEdit($_GET['id']);
        }
        elseif ($_GET['action'] == 'updatePost') {
            $postController = new PostController;
            $postController->updatePost($_POST['chapter'], $_POST['title'], $_POST['postContent'], $_GET['id']);
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
                } else {
                    throw new Exception('Tous les champs ne sont pas remplis !');
                }
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }
        elseif ($_GET['action'] == 'deleteComment') {
            if (isset($_GET['commentId']) && $_GET['commentId'] > 0) {

                //needed to update the userComCounter in members table
                $sessionController = new SessionController();
                $sessionController->checkSession();

                $commentController = new CommentController;
                $commentController->deleteComment($_GET['commentId'], $_GET['id'], $cookieOrSessionID);
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }
        elseif ($_GET['action'] == 'reportComment') {
            if (isset($_GET['commentId']) && $_GET['commentId'] > 0) {
                $sessionController = new sessionController();
                $commentController = new commentController();

                //checks in the controler if the member already reported the same comment
                $cookieOrSessionID = $sessionController->checkSession();
                $commentController->checkIfReported();
                //needed to checks in the controler if the member already reported the same comment
                $commentController->reportCommentsCheck($cookieOrSessionID, $_GET['commentId']); //the reported comment is registered into reported_comments DB
                $commentController->reportComments($_GET['commentId']);    //the reported comment is actually reported in comments DB and BE
            } else {
                throw new Exception('Aucun identifiant de commentaire envoyé');
            }
        }
        //user can edit his own comment
        elseif ($_GET['action'] == 'updateComment') {
            if (isset($_GET['commentId']) && $_GET['commentId'] > 0) {
                $commentController = new commentController();
                $commentController->updateComment($_POST['comment'], $_GET['commentId']);
            } else {
                throw new Exception('Aucun identifiant de commentaire envoyé');
            }
        }

        //BACKEND
        elseif ($_GET['action'] == 'manageComments') {
            $commentController = new commentController();
            $commentController->listAllComments();

            //Confirmation message when posting a comment
            if (isset($_GET['success']) and $_GET['success'] == 6) {
                include('templates/success-messages/success6.html');
            }
        }

        //to approve or delete all reported comments
        elseif ($_GET['action'] == 'manageAllSelectedComments') {
            if (isset($_POST['deleteSelectedComments'])) {
                $commentController = new commentController();
                $commentController->deleteAllSelectedComments($_POST['selectComments']);
            } elseif (isset($_POST['approveSelectedComments'])) {
                $commentController = new commentController();
                $commentController->approveAllSelectedComments($_POST['selectComments']);
            } else {
                throw new Exception('Il y a une erreur');
            }
        }

        //to publish or delete all new comments
        elseif ($_GET['action'] == 'publishAllSelectedComments') {
            if (isset($_POST['deleteSelectedComments'])) {
                $commentController = new commentController();
                $commentController->deleteAllSelectedComments($_POST['selectPublishComments']);
            } elseif (isset($_POST['publishSelectedComments'])) {
                $commentController = new commentController();
                $commentController->approveAllSelectedComments($_POST['selectPublishComments']);
            } else {
                throw new Exception('Il y a une erreur');
            }
        }
        elseif ($_GET['action'] == 'approveComment') {
            $commentController = new commentController();
            $commentController->approveComments($_GET['commentId']);
        }


        //SING IN, LOG IN, LOG OUT
        elseif ($_GET['action'] == 'addNewMember') {
            //testing if all fields a filled
            if (isset($_POST['username']) && isset($_POST['pass']) && isset($_POST['passCheck']) && isset($_POST['email'])) {

                $accentedCharacters = "àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ";

                //testing if username only has authorised caracters and length
                if (preg_match("#^[a-z".$accentedCharacters ."0-9]{4,20}$#i", $_POST['username'])) {
                    //testing if passwords is conform
                    if (preg_match("#^[a-z".$accentedCharacters ."0-9._!?-]{8,20}$#i", $_POST['pass'])) {
                        //testing if both passwords match
                        if ($_POST['pass'] == $_POST['passCheck']) {

                            //testing if email is conform
                            if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#i", $_POST['email'])) {
                                //hash password (security feature)
                                $_POST['pass'] = password_hash($_POST['pass'], PASSWORD_DEFAULT);
                                //check if username of email are already taken

                                $sessionController = new SessionController;
                                if ($sessionController->checkUsernameAvailability($_POST['username']) == false) {
                                    if ($sessionController->checkEmailAvailability($_POST['email']) == false) {
                                        $sessionController->addNewMember($_POST['username'], $_POST['pass'], $_POST['email']);
                                    } else {
                                        throw new Exception('Cette adresse email n\'est pas disponible');
                                    }
                                } else {
                                    throw new Exception('Ce pseudo n\'est pas disponible');
                                }
                            } else {
                                throw new Exception('L\'adresse email n\'est pas conforme');
                            }
                        } else {
                            throw new Exception('Les deux mots de passe ne sont pas identiques');
                        }
                    } else {
                        throw new Exception('Le mot de passe n\'est pas conforme.');
                    }
                } else {
                    throw new Exception('Le pseudo n\'est pas conforme.');
                }
            } else {
                throw new Exception('Il manque des informations.');
            }
        }

        //LOG IN
        elseif ($_GET['action'] == 'logInCheck') {
            if (isset($_POST['username']) && isset($_POST['pass'])) {
                $sessionController = new SessionController;
                $sessionController->checkLog($_POST['username']);

                //if there is a session open, displays a message
                if (isset($_SESSION['id']) and isset($_SESSION['username'])) {
                    require('templates/front/menu.php');
                }
            } else {
                throw new Exception('Vérifiez vos identifiants de connexion');
            }
        }

        //LOG OUT
        elseif ($_GET['action'] == 'logOutCheck') {
            if (isset($_SESSION['id']) and isset($_SESSION['username'])) {
                $sessionController = new SessionController;
                $sessionController->killSession();

                header('Location: index.php');
                exit;
            } else {
                throw new Exception('Vous êtes déja déconnecté');
            }
        }

        //UPDATE PASSWORD
        elseif ($_GET['action'] == 'UpdatePass') {
            if ((isset($_COOKIE['login']) and $_COOKIE['login'] != '') or  (isset($_SESSION['username']) and $_SESSION['username'] != '')) {

                $accentedCharactersNewPass = "àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ";

                //needed to check the current pass in DB from the right user (id)
                $sessionController = new SessionController();
                $cookieOrSessionID = $sessionController->checkSession();

                if ($sessionController->checkCurrentPass($cookieOrSessionID) == true) {
                    if (preg_match("#^[a-z".$accentedCharactersNewPass ."0-9._!?-]{8,20}$#i", $_POST['newPass'])) {
                        //if the password is Correct check if current and new pass are the same
                        if ($_POST['currentPass'] != $_POST['newPass']) {
                            //hash password (security feature)
                            $_POST['newPass'] = password_hash($_POST['newPass'], PASSWORD_DEFAULT);
                            $sessionController = new SessionController;
                            $sessionController->UpdatePassWord($_POST['newPass'], $_POST['idNewPass']);
                            $sessionController->killSession();
                            //success2 needed to display the confirmation message
                            header('Location: index.php?success=2#header');
                            exit;
                        } else {
                            throw new Exception('Votre nouveau password est le même que l\'actuel');
                        }
                    } else {
                        throw new Exception('Votre nouveau password n\'est pas conforme');
                    }
                } else {
                    throw new Exception('Votre password actuel n\'est pas le bon');
                }
            } else {
                throw new Exception('Vous devez être connecté pour accéder à cette page');
            }
        }

        //USERS
        elseif ($_GET['action'] == 'manageUsers') {
            if (!isset($_GET['page']) or !isset($_GET['sortBy']) or $_GET['page']<1 or $_GET['sortBy']<1) {
                throw new Exception('Il manque le numéro de page ou le classement des utilisateurs');
            } else {
                $userController = new UserController;
                $userController->listAllUsers();
            }
        }

        //to delete all selected users
        elseif ($_GET['action'] == 'manageAllSelectedUsers') {
            if (isset($_POST['deleteSelectedUsers'])) {
                $userController = new UserController;
                $userController->deleteAllSelectedUsers($_POST['selectUsers']);
            } else {
                throw new Exception('Il y a une erreur');
            }
        }

        //to update role
        elseif ($_GET['action'] == 'updateRole') {
            if (isset($_GET['role'])) {
                $userController = new UserController;
                $userController->updateUserRole($_GET['role'], $_GET['userID']);
            } else {
                throw new Exception('Il y a une erreur');
            }
        } elseif ($_GET['action'] == 'deleteUser') {
            if (isset($_GET['userID']) && $_GET['userID'] > 0) {
                $userController = new UserController;
                $userController->deleteUser($_GET['userID']);
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }

        //STATISTICS
        elseif ($_GET['action'] == 'displayStatsView') {
            $statsController = new StatsController;
            $statsController->displayStatsView();
        }

        //ABOUT
        elseif ($_GET['action'] == 'about') {
            $generalController = new GeneralController;
            $generalController->displayAboutView();
        }

        //LEGAL NOTICE
        elseif ($_GET['action'] == 'legalNotice') {
            $generalController = new GeneralController;
            $generalController->displayLegalNoticeView();
        }

        //CONTACT
        elseif ($_GET['action'] == 'sendMessage') {
            //testing if all fields a filled
            if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['contactEmail']) && isset($_POST['topic']) && isset($_POST['messageContent'])) {

                $accentedCharacters = "àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ";

                //testing if firstName only has authorised caracters
                if (preg_match("#^[a-z". $accentedCharacters ."]+[' -]?[a-z". $accentedCharacters ."]+$#i", $_POST['firstName'])) {
                    //testing if lastName only has authorised caracters
                    if (preg_match("#^[a-z". $accentedCharacters ."]+[' -]?[a-z". $accentedCharacters ."]+$#i", $_POST['lastName'])) {
                        //testing if email is conform
                        if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#i", $_POST['contactEmail'])) {
                            //testing if topic is conform
                            if (preg_match("#^[a-z". $accentedCharacters ."(' \-)*]+[a-z". $accentedCharacters ."]+$#i", $_POST['topic'])) {
                                $formController = new FormController;
                                $formController->sendMessage($_POST['firstName'], $_POST['lastName'], $_POST['contactEmail'], $_POST['topic'], $_POST['messageContent']);
                            } else {
                                throw new Exception('L\'intitulé n\'est pas conforme');
                            }
                        } else {
                            throw new Exception('L\'adresse email n\'est pas conforme');
                        }
                    } else {
                        throw new Exception('Le nom n\'est pas conforme.');
                    }
                } else {
                    throw new Exception('Le prénom n\'est pas conforme.');
                }
            } else {
                throw new Exception('Il manque des informations.');
            }
        }
    }

    //DEFAULT BEHAVIOR
    else {
        if (isset($_GET['page']) && $_GET['page'] <= 0) {
            throw new Exception('Cette page n\'existe pas');
        } else {
            $postController = new PostController;
            $postController->listPosts();

            //Confirmation message when singin in
            if (isset($_GET['success']) and $_GET['success'] == 1) {
                include('templates/success-messages/success1.html');
            }

            //Confirmation message when password updated
            if (isset($_GET['success']) and $_GET['success'] == 2) {
                include('templates/success-messages/success2.html');
            }

            //Confirmation message when message sent through contact page
            if (isset($_GET['success']) and $_GET['success'] == 3) {
                include('templates/success-messages/success3.html');
            }
        }
    }
}

//ERROR BEHAVIOR
catch (Exception $e) {
    $errorMessage = $e->getMessage();
    require('templates/errorView.php');
}
