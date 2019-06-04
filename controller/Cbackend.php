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
    header('Location: index.php?action=manageComments');
}
