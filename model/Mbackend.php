<?php

//gets the last X posts to display in adminView. X depends on $messagesPerPage
function getPostsAdmin($firstEntry, $messagesPerPage)
{
    $db = dbConnectAdmin();
    $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_publish_date, DATE_FORMAT(edit_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_edit_date FROM posts ORDER BY publish_date DESC LIMIT ?, ?');
    $req->bindValue(1, $firstEntry, PDO::PARAM_INT);
    $req->bindValue(2, $messagesPerPage, PDO::PARAM_INT);
    $req->execute();
    return $req;
}


//Pagination
function getTotalPagesAdmin(){
    $db = dbConnect();
    $getTotalPagesAdmin = $db->query('SELECT COUNT(*) AS total_posts FROM posts');
    $returnTotalPagesAdmin= $getTotalPagesAdmin->fetch();

    return $returnTotalPagesAdmin;
}


//gets the Reported comments (where flag >0 and sort them by number of time reported OR by date showing older first if reported the same nb of times)
function getReportedComments()
{
    $db = dbConnectAdmin();
    $reportedComment = $db->query('SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_comment_date, flag FROM comments WHERE flag > 0 ORDER BY flag DESC, comment_date');

    return $reportedComment;
}

function getNbOfReportedComments() // NOT WORKING : display number of comments to manage 
{
    $db = dbConnectAdmin();
    $reportedCommentNb = $db->query('SELECT SUM(flag) AS flag_total FROM comments');

    return $reportedCommentNb;

}


function approveComment($commentId){
    $db = dbConnectAdmin();
    $commentApprove = $db->prepare('UPDATE comments SET flag = 0 WHERE id = ?');
    $commentApprove->execute(array($commentId));
}
 
function insertNewPost($title, $content)
{
    $db = dbConnectAdmin();
    $newPostDb = $db->prepare('INSERT INTO posts( title, content, publish_date, edit_date) VALUES(?, ?, NOW(), NOW())');
    $newPostDb->execute(array($title, $content));
}

function getPostToEdit($postId)
{
    $db = dbConnectAdmin();
    $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_publish_date, DATE_FORMAT(edit_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_edit_date FROM posts WHERE id = ?');
    $req->execute(array($postId));
    $postToEdit = $req->fetch();

    return $postToEdit;
}

function editPost($title, $content, $postId)
{
    $db = dbConnectAdmin();
    $editedPost = $db->prepare('UPDATE posts SET title = ?, content = ?, edit_date = NOW() WHERE id = ?');
    $editedPost->execute(array($title, $content, $postId));

}


// General function to connect to database
function dbConnectAdmin()
{
    $db = new PDO('mysql:host=localhost;dbname=p4blog;charset=utf8', 'root', '');

    return $db;
}