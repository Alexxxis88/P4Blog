<?php
require('model/Mbackend.php');


function listPostsAdmin()
{
    $postsAdmin = getPostsAdmin();
    require('view/backend/adminView.php');
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