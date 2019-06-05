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
    header('Location: ' . $_SERVER['HTTP_REFERER']); //FIXME : SQL injection issue ? 

} 

function reportComments($commentId){
    $commentReported = reportComment($commentId);
    header('Location: index.php?action=post&id=' . $_GET['id'] . '#commentsAnchor'); //FIXME : SQL injection issue ? 
}



function deletePost($postId)
{
    $postDelete = erasePost($postId);
    header('Location: ' . $_SERVER['HTTP_REFERER']); //FIXME problem = when delete button used on a specific post (BE), sends back to post that has just been deleted. + not good to use ? see : https://stackoverflow.com/questions/5285031/back-to-previous-page-with-header-location-in-php
} 

//erase all the comments related to a post when "delete post" action is done
function deleteAllComments($postId)
{
    $AllcomsDelete = eraseAllComments($postId);
    header('Location: ' . $_SERVER['HTTP_REFERER']); //FIXME problem = when delete button used on a specific post (BE), sends back to post that has just been deleted.
} 
