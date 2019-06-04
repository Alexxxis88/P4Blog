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