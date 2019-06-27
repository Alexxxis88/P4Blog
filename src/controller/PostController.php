<?php
    



class PostController{

  //gets all the post to display in listPostsView. 
    public function listPosts()
    {   

    //change color of the menu comment icon in red if comments to manage FIXME : factoriser ? au lieu de copier plein de fois ? 
        $commentManager = new CommentManager();
        $nbOfReportedComments = $commentManager->getNbOfReportedComments();

        $postManager = new PostManager();
    
    //Pagitation     
        $totalPages = $postManager->getTotalPages();
        $total = $totalPages['total_posts']; // total of posts in DB
        $messagesPerPage = 6;
        $nbOfPages = ceil($total/$messagesPerPage);
        if(isset($_GET['page']))
        {
            $currentPage = intval($_GET['page']); //intval gets the integer ( 4.2 = 4) value of a variable
        
            if($currentPage>$nbOfPages) // if a user puts the value of a page that doesnt exist, it redirects to the last page ($nbOfPages)
            {
                $currentPage=$nbOfPages;
            }
        }
        else
        {
            $currentPage = 1; 
        }
        $firstEntry = ($currentPage-1)*$messagesPerPage; // first entry to read
        
        $currentView = "listPost"; //to display the correct Pagination View
        
  //Display post depending on pagination parameters
        $posts = $postManager->getPosts($firstEntry, $messagesPerPage);


    //check the role of the logged in user to display or not Admin features
        $sessionController = new SessionController;
        $checkUserRole = $sessionController->checkUserRole();
        
        require('templates/front/listPostsView.php');
    }


    public function post()
    {   

        //change color of the menu comment icon in red if comments to manage FIXME : factoriser ? au lieu de copier plein de fois ? 
        $commentManager = new CommentManager();
        $nbOfReportedComments = $commentManager->getNbOfReportedComments();

        $sessionController = new SessionController;
        $checkUserRole = $sessionController->checkUserRole();

        $postManager = new PostManager();
        $commentManager = new CommentManager();

    //Pagination for comments
        $totalComments = $commentManager->getTotalComments($_GET['id']);
        $totalCom=$totalComments['total_comments']; // total of posts in DB

        if(isset($_GET['sortBy'])){
            $messagesPerPage = $_GET['sortBy'];
        }
        else
        {
            $messagesPerPage = 5;
        }
        $nbOfPages=ceil($totalCom/$messagesPerPage);
        if(isset($_GET['page']))
        {
            $currentPage=intval($_GET['page']); //intval gets the integer ( 4.2 = 4) value of a variable
            if($currentPage>$nbOfPages) // if a user puts the value of a page that doesnt exist, it redirects to the last page ($nbOfPages)
            {
                $currentPage=$nbOfPages;
            }
        }
        else
        {
            $currentPage=1; 
        }
        $firstEntry=($currentPage-1)*$messagesPerPage; // first comment to read
        $comments = $commentManager->getComments($_GET['id'], $firstEntry, $messagesPerPage);

        $currentView = "comments";

        
        $post = $postManager->getPost($_GET['id']);
        //check if post exists in DB
        if($post == false)
        {
            throw new Exception('Ce chapitre n\'existe pas');
        }

        $lastPosts = $postManager->getPosts(0,3); // 0,3 = the last 3 posts published

        require('templates/front/postView.php');
    }


    public function displayPublishView()
    {   

        //change color of the menu comment icon in red if comments to manage FIXME : factoriser ? au lieu de copier plein de fois ? 
        $commentManager = new CommentManager();
        $nbOfReportedComments = $commentManager->getNbOfReportedComments();
        
        $sessionController = new SessionController;
        $checkUserRole = $sessionController->checkUserRole();
        if($checkUserRole['groupId'] != 1)
        {
            throw new Exception('Vous n\'avez pas accès à cette page');
        }
        require('templates/admin/publishView.php');
    }


    public function newPost($chapter, $title, $content)
    {   
        $postManager = new PostManager();
        $newPost = $postManager->insertNewPost($chapter, $title, $content);
        header('Location: index.php?action=listPosts');
        exit;
    }


    public function deletePost($postId)
    {   
        $postManager = new PostManager();
        $postDelete = $postManager->erasePost($postId);
        header('Location: index.php');
        exit;
    } 


    public function displayPostToEdit($postId)
    {   
        $sessionController = new SessionController;
        $checkUserRole = $sessionController->checkUserRole();
        if($checkUserRole['groupId'] != 1)
        {
            throw new Exception('Vous n\'avez pas accès à cette page');
        }
        
        //change color of the menu comment icon in red if comments to manage FIXME : factoriser ? au lieu de copier plein de fois ? 
        $commentManager = new CommentManager();
        $nbOfReportedComments = $commentManager->getNbOfReportedComments();
        
        $postManager = new PostManager();
        $displayedPostToEdit = $postManager->getPost($postId);
        require('templates/admin/manageView.php');
    }

    public function updatePost($chapter, $title, $content, $postId)
    {
        $postManager = new PostManager();
        $updatedPost = $postManager->editPost($chapter, $title, $content, $postId);
        header('Location: index.php?action=post&id=' . $postId . '&page=1&sortBy=5');
        exit;
}




}
