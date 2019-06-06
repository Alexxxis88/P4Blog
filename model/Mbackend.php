<?php
function getPostsAdmin()
{
    $db = dbConnectAdmin();
    $req = $db->query('SELECT id, title, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_publish_date, DATE_FORMAT(edit_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_edit_date FROM posts ORDER BY publish_date DESC LIMIT 0, 5');

    return $req;
}

//gets the Reported comments (where 0<flag<9999 and sort them by number of time reported OR by date showing older first if reported the same nb of times)
function getReportedComments()
{
    $db = dbConnectAdmin();
    $reportedComment = $db->query('SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_comment_date, flag FROM comments WHERE flag > 0 AND flag < 9999 ORDER BY flag DESC, comment_date');

    return $reportedComment;
}

//get new comments (flag value = 9999 by default)
function getNewComments()
{
    $db = dbConnectAdmin();
    $newComment = $db->query('SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_comment_date, flag FROM comments WHERE flag = 9999 ORDER BY comment_date');

    return $newComment;
}


//must receive an array of ids to delete all the comments at once. (?) = my array, see here https://www.tutorialspoint.com/mysql/mysql-in-clause.htm
function eraseAllSelectedComments($arrayCommentsIDs) //NOT WORKING :
{
    $db = dbConnectAdmin();
    $eraseAllSelectedComments = $db->prepare('DELETE FROM comments WHERE id IN (?)');
    $eraseAllSelectedComments->execute(array($arrayCommentsIDs));
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