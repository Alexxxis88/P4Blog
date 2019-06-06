<?php

//gets all the post to display in listPostsView. duplicatede code with getLastPosts (except LIMIT values)
function getPosts()
{
    $db = dbConnect();
    $req = $db->query('SELECT id, title, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_publish_date, DATE_FORMAT(edit_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_edit_date FROM posts ORDER BY publish_date DESC LIMIT 0, 10');

    return $req;
}


//gets last 3 posts to display in postView aside. duplicatede code with getLastPosts (except LIMIT values)
function getLastPosts()
{
    $db = dbConnect();
    $lastPost = $db->query('SELECT id, title, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_publish_date, DATE_FORMAT(edit_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_edit_date FROM posts ORDER BY publish_date DESC LIMIT 0, 3');

    return $lastPost;
}


function getPost($postId)
{
    $db = dbConnect();
    $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_publish_date, DATE_FORMAT(edit_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_edit_date FROM posts WHERE id = ?');
    $req->execute(array($postId));
    $post = $req->fetch();

    return $post;
}

function getComments($postId)
{
    $db = dbConnect();
    $comments = $db->prepare('SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_comment_date, flag FROM comments WHERE post_id = ? ORDER BY comment_date');
    $comments->execute(array($postId));

    return $comments;
}


function postComment($postId, $author, $comment)
{
    $db = dbConnect();
    $comments = $db->prepare('INSERT INTO comments(post_id, author, comment, comment_date) VALUES(?, ?, ?, NOW())');
    $affectedLines = $comments->execute(array($postId, $author, $comment));

    return $affectedLines;
}


function eraseComment($commentId)
{
    $db = dbConnect();
    $comDelete = $db->prepare('DELETE FROM comments WHERE id = ?');
    $comDelete->execute(array($commentId));
}


function reportComment($commentId)
{
    $db = dbConnect();
    $commentReport = $db->prepare('UPDATE comments SET flag = 1 WHERE id = ?');
    $commentReport->execute(array($commentId));
}


function erasePost($postId) // est ce que ce $postId est le même que celui de postComment ? 
{
    $db = dbConnect();
    $postDelete = $db->prepare('DELETE FROM posts WHERE id = ?');
    $postDelete->execute(array($postId));
}

//erase all the comments related to a post when "delete post" action is done
function eraseAllComments($postId)
{
    $db = dbConnect();
    $allComDelete = $db->prepare('DELETE FROM comments WHERE post_id = ?');
    $allComDelete->execute(array($postId));
}


// General function to connect to database
function dbConnect()
{
    $db = new PDO('mysql:host=localhost;dbname=p4blog;charset=utf8', 'root', '');
    return $db;
}