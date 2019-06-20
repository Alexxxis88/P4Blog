<?php
session_start();
require('src/controller/PostController.php');

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
