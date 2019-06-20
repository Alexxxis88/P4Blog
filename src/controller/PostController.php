<?php
    //AUTOLOAD
    function classAutoLoad($class)
    {
      require 'src/entity/' . $class . '.php'; 
    }
    spl_autoload_register('classAutoLoad');

class PostController{

  //POSTS
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
      
      require('templates/front/postView.php');
  }




}
