<?php
require('model/Mbackend.php');

function listPostsAdmin()
{
    $postsAdmin = getPostsAdmin();
    require('view/backend/adminView.php');
}

function listResportedComments()
{
    $reportedComments = getReportedComments();
    require('view/backend/commentsView.php');
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
