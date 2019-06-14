<?php


//POSTS

//gets the last X posts to display in listPostsView. X depends on $messagesPerPage
function getPosts($firstEntry, $messagesPerPage)
{
    $db = dbConnect();
    $req = $db->prepare('SELECT id, chapter_nb, title, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_publish_date, DATE_FORMAT(edit_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_edit_date FROM posts ORDER BY publish_date DESC LIMIT ?, ?');
    $req->bindValue(1, $firstEntry, PDO::PARAM_INT);
    $req->bindValue(2, $messagesPerPage, PDO::PARAM_INT);
    $req->execute();
    return $req;
}


//Pagination
function getTotalPages(){
    $db = dbConnect();
    $getTotalPages = $db->query('SELECT COUNT(*) AS total_posts FROM posts');
    $returnTotalPages= $getTotalPages->fetch();

    return $returnTotalPages;
}


//gets last 3 posts to display in postView aside. 
function getLastPosts()
{
    $db = dbConnect();
    $lastPost = $db->query('SELECT id, chapter_nb, title, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_publish_date, DATE_FORMAT(edit_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_edit_date FROM posts ORDER BY publish_date DESC LIMIT 0, 3');

    return $lastPost;
}


function getPost($postId)
{
    $db = dbConnect();
    $req = $db->prepare('SELECT id, chapter_nb, title, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_publish_date, DATE_FORMAT(edit_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_edit_date FROM posts WHERE id = ?');
    $req->execute(array($postId));
    $post = $req->fetch();

    return $post;
}




//-----------------------------------------------------------------------------------------
// NOT WORKING : show more / less comments
// function getComments($postId, $commentsLimit)
// {
//     $db = dbConnect();
//     $comments = $db->prepare('SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_comment_date, flag FROM comments WHERE post_id = ? ORDER BY comment_date LIMIT 0, ?');
//     $comments->bindValue(1, $postId, PDO::PARAM_INT);
//     $comments->bindValue(2, $commentsLimit, PDO::PARAM_INT);
//     $comments->execute();

//     return $comments;


// }




//COMMENTS


//original code to display comments before pagination for comments
// function getComments($postId)
// {
//     $db = dbConnect();
//     $comments = $db->prepare('SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_comment_date, flag FROM comments WHERE post_id = ? ORDER BY comment_date');
//     $comments->execute(array($postId));

//     return $comments;
// }



//WORKING : gets the last X comments to display in listPostsView. X depends on $messagesPerPage
function getComments($postId, $firstComment, $commentsPerPage)
{
    $db = dbConnect();
    $comments = $db->prepare('SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_comment_date, DATE_FORMAT(update_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_update_date, flag FROM comments WHERE post_id = ? ORDER BY comment_date LIMIT ?, ?');
    $comments->bindValue(1, $postId, PDO::PARAM_INT);
    $comments->bindValue(2, $firstComment, PDO::PARAM_INT);
    $comments->bindValue(3, $commentsPerPage, PDO::PARAM_INT);
    $comments->execute();
    return $comments;
}

//-----------------------------------------------------------------------------------------

//Pagination comments
    //AND NOT flag = 9999 added otherwise the number of page will include the comments to moderate before publish even if they are not displayed
function getTotalComments($postId){
    $db = dbConnect();
    $getTotalComments = $db->prepare('SELECT COUNT(*) AS total_comments FROM comments WHERE post_id = ? AND NOT flag = 9999');
    $getTotalComments->bindValue(1, $postId, PDO::PARAM_INT);
    $getTotalComments->execute();

    $returnTotalComments= $getTotalComments->fetch();

    return $returnTotalComments;
}






function postComment($postId, $author, $comment,$postIdComCounts, $userIdComCounts)
{
    $db = dbConnect();
    $comments = $db->prepare('INSERT INTO comments(post_id, author, comment, comment_date, update_date) VALUES(?, ?, ?, NOW(), NOW())');
    $affectedLines = $comments->execute(array($postId, $author, $comment));

    //updates the comment counter +1 to know how much comments have been posted on a post
    $db = dbConnect();
    $commentCount = $db->prepare('UPDATE posts SET comment_count = comment_count + 1 WHERE id = ?');
    $commentCount ->execute(array($postIdComCounts));

    //updates the user comment counter +1 to know how much comments the user has posted
    $db = dbConnect();
    $userCommentCount = $db->prepare('UPDATE members SET user_com_count = user_com_count + 1 WHERE id = ?');
    $userCommentCount ->execute(array($userIdComCounts));

    return $affectedLines;
}


function eraseComment($commentId, $postIdComCounts, $userIdComCounts)
{
    $db = dbConnect();
    $comDelete = $db->prepare('DELETE FROM comments WHERE id = ?');
    $comDelete->execute(array($commentId));

    //updates the comment counter +1 to know how much comments have been posted on a post
    $db = dbConnect();
    $commentCount = $db->prepare('UPDATE posts SET comment_count = comment_count - 1 WHERE id = ?');
    $commentCount ->execute(array($postIdComCounts));

    //updates the user comment counter +1 to know how much comments the user has posted
    $db = dbConnect();
    $userCommentCount = $db->prepare('UPDATE members SET user_com_count = user_com_count - 1 WHERE id = ?');
    $userCommentCount ->execute(array($userIdComCounts));

}


function reportComment($commentId)
{
    $db = dbConnect();
    $commentReport = $db->prepare('UPDATE comments SET flag = flag + 1 WHERE id = ?');
    $commentReport->execute(array($commentId));
}


//add the reported comment in a new table called reported_comments that gathers the id of the member who reported it, the id of the reported comment and a flag set to 1
function reportedCommentPerUser($memberId, $repComId)
{
    $db = dbConnect();
    $newRepCom = $db->prepare('INSERT INTO reported_comments( memberId, repComId, flagRep) VALUES(?, ?, 1)');
    $newRepCom->execute(array($memberId, $repComId));
}


//check when a member reports a comment if he already reported it once
function checkIfAlreadyReportedCom()
{
    $db = dbConnect();
    $alreadyRep = $db->query('SELECT memberId, repComId, flagRep FROM reported_comments');
    
    return $alreadyRep;

}

function updateCom($comment, $commentId)
{
    $db = dbConnect();
    $updateCom = $db->prepare('UPDATE comments SET comment = ?, update_date = NOW()  WHERE id = ?');
    $updateCom->execute(array($comment, $commentId));
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



//SING IN, LOG IN, LOG OUT
function insertMember($username, $pass, $email)
{
    $db = dbConnect();
    $newMember = $db->prepare('INSERT INTO members( username, pass, email, registration_date) VALUES(?, ?, ?, NOW())');
    $newMember->execute(array($username, $pass, $email));
}

function UpdatePass($newpass, $id)
{
    $db = dbConnect();
    $UpdatePass = $db->prepare('UPDATE members SET pass = ? WHERE id = ?');
    $UpdatePass->execute(array($newpass,$id));
}


function checkLogIn($userName)
{
    $db = dbConnect();
    $check = $db->prepare('SELECT id, pass, group_id FROM members WHERE username = ?');
    $check->execute(array($userName));
    $checkLogIn = $check->fetch();

    return $checkLogIn;
}

//FIXME : factoriser avec la fonction checkLogIn ? 
function checkUsername($userName)
{
    $db = dbConnect();
    $check = $db->prepare('SELECT username FROM members WHERE username = ?');
    $check->execute(array($userName));
    $checkUsername = $check->fetch();

    return $checkUsername;
}

//FIXME : factoriser avec la fonction checkLogIn ? 
function checkEmail($email)
{
    $db = dbConnect();
    $check = $db->prepare('SELECT email FROM members WHERE email = ?');
    $check->execute(array($email));
    $checkEmail = $check->fetch();

    return $checkEmail;
}

function currentPass($currentPass)
{
    $db = dbConnect();
    $check = $db->prepare('SELECT pass FROM members WHERE pass = ?');
    $check->execute(array($currentPass));
    $currentPass = $check->fetch();

    return $currentPass;
}



// General function to connect to database
function dbConnect()
{
    $db = new PDO('mysql:host=localhost;dbname=p4blog;charset=utf8', 'root', '');
    return $db;
}