<?php
    //AUTOLOAD
    function classAutoLoad($class)
    {
      require 'src/entity/' . $class . '.php'; 
    }
    spl_autoload_register('classAutoLoad');



class PostController{

  //gets all the post to display in listPostsView. 
    public function listPosts()
    {
        $postManager = new PostManager();
  
  //Display post depending on pagination parameters
        $posts = $postManager->getPosts();
        require('templates/front/listPostsView.php');
    }


    public function post()
    {
        $postManager = new PostManager();
    
        $post = $postManager->getPost($_GET['id']);
        //check if post exists in DB
        if($post == false)
        {
            throw new Exception('Ce chapitre n\'existe pas');
        }

        $lastPosts = $postManager->getPosts(); // passer en paramètre à cette méthodes le nombre de post que je veux display sur le coté
        require('templates/front/postView.php');
    }


    public function displayPublishView()
    {
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
