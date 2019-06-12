<?php
require('model/Mbackend.php');

function listPostsAdmin()
{
    $postsAdmin = getPostsAdmin();
    require('view/backend/adminView.php');
}









// function ManageComments($arrayCommentsIDs){
//     $reportedComments = getReportedComments();
//     $newComments = getNewComments();
    
    
//     if(isset($arrayCommentsIDs) && !empty($arrayCommentsIDs)){
//         $deleteAllSelectedComments = eraseAllSelectedComments($arrayCommentsIDs);
//     }
    
//     require('view/backend/commentsView.php');

// }









//old code before grouping listAllComments and deleteAllSelectedComments in ManageComments()
//display reported and new comments
function listAllComments()
{
    $reportedComments = getReportedComments();
    $newComments = getNewComments();
    require('view/backend/commentsView.php');
}


function deleteAllSelectedComments($arrayCommentsIDs){
    
    // $arrayCommentsIDs = array(161, 162, 163, 164); //working FIXME : a supprimer
    $deleteAllSelectedComments = eraseAllSelectedComments($arrayCommentsIDs);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}


function approveAllSelectedComments($arrayCommentsIDs){
    
    $approveAllSelectedComments = acceptAllSelectedComments($arrayCommentsIDs);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

// FIXME a supprimer si ça fonctionne bien avec approveAllSelectedComments
// function publishAllSelectedComments($arrayPublish){
    
//     $publishAllSelectedComments = postAllSelectedComments($arrayPublish);
//     header('Location: ' . $_SERVER['HTTP_REFERER']);
// }    


// function deleteAllSelectedCommentsTEST(){ // working
//     $deleteAllSelectedCommentsTEST = eraseAllSelectedCommentsTEST();
    
//     // header('Location: ' . $_SERVER['HTTP_REFERER']);
// }


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