<?php
require('model/Mfrontend.php');

function listPosts()
{
    $posts = getPosts();
    require('view/frontend/listPostsView.php');
}

function post()
{
    $post = getPost($_GET['id']);
    $comments = getComments($_GET['id']);
    require('view/frontend/postView.php');
}

function addComment($postId, $author, $comment)
{
    $affectedLines = postComment($postId, $author, $comment);

    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    }
    else {
        header('Location: index.php?action=post&id=' . $postId);
    }
}

function deleteComment($commentId)
{
    $comDelete = eraseComment($commentId);
    header('Location: index.php?action=post&id=' . $_GET['id'] . '#commentsAnchor'); //FIXME : SQL injection issue ? 

} 

function deletePost($postId)
{
    $postDelete = erasePost($postId);
    header('Location: ' . $_SERVER['HTTP_REFERER']); //FIXME problem = when delete button used on a specific post (BE), sends back to post that has just been deleted. + not good to use ? see : https://stackoverflow.com/questions/5285031/back-to-previous-page-with-header-location-in-php


//try 3 : not working
    
    // if($_GET['id'] !="")
    // {
    // header('Location: index.php');
    // }
    // else
    // {
    // header('Location: ' . $_SERVER['HTTP_REFERER']);
    // } 

//try 2 : not working
    // if('Location: index.php' OR 'Location: index.php?action=listPosts' ){ // FIXME (if elseif not working) problem = when delete button used on Admin page (BE), sends back to FE home page instead of BE Adminpage
    //     header('Location: index.php?action=listPosts'); 
    // }
    // elseif('Location: index.php?action=listostsAdmin'){
    //     header('Location: index.php?action=listPostsAdmin');
    // }
    

//try 1 : not working
    // //tryed the following code bug doesn't work because it brings conflicts between actions related to $_GET['action] defined here and in router index.php
    // // if($_GET['action'] == '' OR $_GET['action'] == 'listPosts'){ // FIXME (if elseif not working) problem = when delete button used on Admin page (BE), sends back to FE home page instead of BE Adminpage
    // //     header('Location: index.php?action=listPosts'); 
    // // }
    // // elseif($_GET['action'] == 'listPostsAdmin'){
    // //     header('Location: index.php?action=listPostsAdmin');
    // // }

} 
