<?php
require('model/Mbackend.php');

function listPostsAdmin()
{

    //Pagination
    $totalPages = getTotalPagesAdmin();
    $total=$totalPages['total_posts']; // total of posts in DB
    $messagesPerPage=5;
    $nbOfPages=ceil($total/$messagesPerPage);

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

    $firstEntry=($currentPage-1)*$messagesPerPage; // first entry to read
 

//Display post depending on pagination parameters

    $postsAdmin = getPostsAdmin($firstEntry, $messagesPerPage);
    require('view/backend/adminView.php');
    

}

function listResportedComments()
{
    $reportedComments = getReportedComments();
    require('view/backend/commentsView.php');
}


function nbOfReportedComments() // NOT WORKING : display number of comments to manage 
{
    $nbOfReportedComments = getNbOfReportedComments();
    require('view/backend/backendTemplate.php');
}


function approveComments($commentId){
    $commentApproved = approveComment($commentId);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
function newPost($title, $content)
{
    $newPost = insertNewPost($title, $content);
    header('Location: index.php?action=listPostsAdmin');
    exit;
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
    exit;
}