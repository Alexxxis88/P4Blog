<?php
require('model/Mbackend.php');

function listPostsAdmin()
{
    $postsAdmin = getPostsAdmin();
    require('view/backend/adminView.php');
}

//display reported and new comments
function listAllComments()
{
    $reportedComments = getReportedComments();
    $newComments = getNewComments();
    require('view/backend/commentsView.php');
}


function deleteAllSelectedComments($arrayCommentsIDs){ // NOT WORKING : display number of comments to manage 
    $deleteAllSelectedComments = eraseAllSelectedComments($arrayCommentsIDs);
    // header('Location: ' . $_SERVER['HTTP_REFERER']);
}


function approveComments($commentId){
    $commentApproved = approveComment($commentId);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
function newPost($title, $content)
{
    $newPost = insertNewPost($title, $content);
    header('Location: index.php?action=listPostsAdmin');
}

function displayPublishView()
{
    require('view/backend/publishView.php');
}


function displayPostToEdit($postId)
{
    $displayedPostToEdit = getPostToEdit($postId);
    require('view/backend/manageView.php');
}

function updatePost($title, $content, $postId){
    $updatedPost = editPost($title, $content, $postId);
    header('Location: index.php?action=post&id=' . $postId);
}