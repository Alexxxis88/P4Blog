<?php

require_once("model/Manager.php");

class CommentManager extends Manager
{   
    //FRONTEND
    public function getComments($postId, $firstComment, $commentsPerPage)
    {
        $db = $this->dbConnect();
        $comments = $db->prepare('SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_comment_date, DATE_FORMAT(update_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_update_date, flag FROM comments WHERE post_id = ? ORDER BY comment_date LIMIT ?, ?');
        $comments->bindValue(1, $postId, PDO::PARAM_INT);
        $comments->bindValue(2, $firstComment, PDO::PARAM_INT);
        $comments->bindValue(3, $commentsPerPage, PDO::PARAM_INT);
        $comments->execute();
        return $comments;
    }

    //Pagination comments
        //AND NOT flag = 9999 added otherwise the number of page will include the comments to moderate before publish even if they are not displayed
    public function getTotalComments($postId)
    {
        $db = $this->dbConnect();
        $getTotalComments = $db->prepare('SELECT COUNT(*) AS total_comments FROM comments WHERE post_id = ? AND NOT flag = 9999');
        $getTotalComments->bindValue(1, $postId, PDO::PARAM_INT);
        $getTotalComments->execute();

        $returnTotalComments= $getTotalComments->fetch();

        return $returnTotalComments;
    }



    public function postComment($postId, $author, $comment,$postIdComCounts, $userIdComCounts)
    {
        $db = $this->dbConnect();
        $comments = $db->prepare('INSERT INTO comments(post_id, author, comment, comment_date, update_date) VALUES(?, ?, ?, NOW(), NOW())');
        $affectedLines = $comments->execute(array($postId, $author, $comment));

        //updates the comment counter +1 to know how much comments have been posted on a post
        $commentCount = $db->prepare('UPDATE posts SET comment_count = comment_count + 1 WHERE id = ?');
        $commentCount ->execute(array($postIdComCounts));

        //updates the user comment counter +1 to know how much comments the user has posted
        $userCommentCount = $db->prepare('UPDATE members SET user_com_count = user_com_count + 1 WHERE id = ?');
        $userCommentCount ->execute(array($userIdComCounts));

        return $affectedLines;
    }


    public function eraseComment($commentId, $postIdComCounts, $userIdComCounts)
    {
        $db = $this->dbConnect();
        $comDelete = $db->prepare('DELETE FROM comments WHERE id = ?');
        $comDelete->execute(array($commentId));

        //updates the comment counter +1 to know how much comments have been posted on a post
        $commentCount = $db->prepare('UPDATE posts SET comment_count = comment_count - 1 WHERE id = ?');
        $commentCount ->execute(array($postIdComCounts));

        //updates the user comment counter +1 to know how much comments the user has posted
        $userCommentCount = $db->prepare('UPDATE members SET user_com_count = user_com_count - 1 WHERE id = ?');
        $userCommentCount ->execute(array($userIdComCounts));
    }


    public function reportComment($commentId)
    {
        $db = $this->dbConnect();
        $commentReport = $db->prepare('UPDATE comments SET flag = flag + 1 WHERE id = ?');
        $commentReport->execute(array($commentId));
    }


    //add the reported comment in a new table called reported_comments that gathers the id of the member who reported it, the id of the reported comment and a flag set to 1
    public function reportedCommentPerUser($memberId, $repComId)
    {
        $db = $this->dbConnect();
        $newRepCom = $db->prepare('INSERT INTO reported_comments( memberId, repComId, flagRep) VALUES(?, ?, 1)');
        $newRepCom->execute(array($memberId, $repComId));
    }


    //check when a member reports a comment if he already reported it once
    public function checkIfAlreadyReportedCom()
    {
        $db = $this->dbConnect();
        $alreadyRep = $db->query('SELECT memberId, repComId, flagRep FROM reported_comments');
        
        return $alreadyRep;

    }

    public function updateCom($comment, $commentId)
    {
        $db = $this->dbConnect();
        $updateCom = $db->prepare('UPDATE comments SET comment = ?, update_date = NOW()  WHERE id = ?');
        $updateCom->execute(array($comment, $commentId));
    }


   

    //erase all the comments related to a post when "delete post" action is done
    public function eraseAllComments($postId)
    {
        $db = $this->dbConnect();
        $allComDelete = $db->prepare('DELETE FROM comments WHERE post_id = ?');
        $allComDelete->execute(array($postId));
    }


    //BACKEND

    //gets the Reported comments (where flag >0 and sort them by number of time reported OR by date showing older first if reported the same nb of times)
    public function getReportedComments()
    {
        $db = $this->dbConnect();
        $reportedComment = $db->query('SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_comment_date, flag FROM comments WHERE flag > 0 AND flag < 9999 ORDER BY flag DESC, comment_date');

        return $reportedComment;
    }

    //get new comments (flag value = 9999 by default)
    public function getNewComments()
    {
        $db = $this->dbConnect();
        $newComment = $db->query('SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_comment_date, flag FROM comments WHERE flag = 9999 ORDER BY comment_date');

        return $newComment;
    }

    //must receive an array of ids to delete all the comments at once. (?) = my array, see here https://www.tutorialspoint.com/mysql/mysql-in-clause.htm
    public function eraseAllSelectedComments($arrayCommentsIDs) //NOT WORKING :
    {
        //on compte la longueur du tableau pour arrêter la boucle for au bon moment
        $arrayLength = count($arrayCommentsIDs, COUNT_NORMAL);
        
        //on fait une boucle pour injecter la VALEUR ENTIERE de chaque entrée du tableau $arrayCommentsIDs en tant que paramètre ? de (IN)
        for( $i = 0; $i < $arrayLength; $i++){
            $id = $arrayCommentsIDs[$i];
            $db = $this->dbConnect();
            $eraseAllSelectedComments = $db->prepare('DELETE FROM comments WHERE id IN (?)'); // je veux que ? soit les valeurs successives d'un tableau donc je dois faire une boucle
            $eraseAllSelectedComments->execute(array($id));
        }
        
    }

    //accept all the selected reported comments
    public function acceptAllSelectedComments($arrayCommentsIDs) 
    {
        //on compte la longueur du tableau pour arrêter la boucle for au bon moment
        $arrayLength = count($arrayCommentsIDs, COUNT_NORMAL);
        
        //on fait une boucle pour injecter la VALEUR ENTIERE de chaque entrée du tableau $arrayCommentsIDs en tant que paramètre ? de (IN)
        for( $i = 0; $i < $arrayLength; $i++){
            $id = $arrayCommentsIDs[$i];
            $db = $this->dbConnect();
            $acceptAllSelectedComments = $db->prepare('UPDATE comments SET flag = 0 WHERE id IN (?)'); // je veux que ? soit les valeurs successives d'un tableau donc je dois faire une boucle
            $acceptAllSelectedComments->execute(array($id));
        }
        
    }


    public function getNbOfReportedComments() // display number of comments to manage 
    {
        $db = $this->dbConnect();
        $reportedCommentNb = $db->query('SELECT SUM(flag) AS flag_total FROM comments');

        return $reportedCommentNb;
    }


    public function approveComment($commentId)
    {
        $db = $this->dbConnect();
        $commentApprove = $db->prepare('UPDATE comments SET flag = 0 WHERE id = ?');
        $commentApprove->execute(array($commentId));
    }
}