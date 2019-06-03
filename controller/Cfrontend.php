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
