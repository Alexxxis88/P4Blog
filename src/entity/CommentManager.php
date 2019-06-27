<?php
class CommentManager extends Manager
{

    //FRONTEND
    public function getComments($postId, $firstEntry, $messagesPerPage)
    {
        $req = $this->_db->prepare('SELECT id, author, comment, DATE_FORMAT(commentDate, \'%d/%m/%Y à %Hh%imin%ss\') AS modCommentDate, DATE_FORMAT(updateDate, \'%d/%m/%Y à %Hh%imin%ss\') AS modUpdateDate, flag FROM comments WHERE postId = ? ORDER BY commentDate LIMIT ?,?');
        $req->bindValue(1, $postId, PDO::PARAM_INT);
        $req->bindValue(2, $firstEntry, PDO::PARAM_INT);
        $req->bindValue(3, $messagesPerPage, PDO::PARAM_INT);
        $req->execute();

        while ($datasComments = $req->fetch(PDO::FETCH_ASSOC))
        {           
            $comments[] = new Comment($datasComments);
        }
        if(!empty($comments)) //needed otherwise gives an error on the postView.php when no comments on the related post
        {
            return $comments;
        } 
    }

    //Pagination comments
        //AND NOT flag = 9999 added otherwise the number of page will include the comments to moderate before publish even if they are not displayed
    public function getTotalComments($postId)
    {
        $getTotalComments = $this->_db->prepare('SELECT COUNT(*) AS total_comments FROM comments WHERE postId = ? AND NOT flag = 9999');
        $getTotalComments->bindValue(1, $postId, PDO::PARAM_INT);
        $getTotalComments->execute();
        $returnTotalComments= $getTotalComments->fetch();
        return $returnTotalComments;
    }

    public function postComment($postId, $author, $comment,$postIdComCounts, $userIdComCounts)
    {
        $comments = $this->_db->prepare('INSERT INTO comments(postId, author, comment, commentDate, updateDate) VALUES(?, ?, ?, NOW(), NOW())');
        $affectedLines = $comments->execute(array($postId, $author, $comment));
        //updates the comment counter +1 to know how much comments have been posted on a post
        $commentCount =$this->_db->prepare('UPDATE posts SET commentCount = commentCount + 1 WHERE id = ?');
        $commentCount ->execute(array($postIdComCounts));
        //updates the user comment counter +1 to know how much comments the user has posted
        $userCommentCount =$this->_db->prepare('UPDATE members SET userComCount = userComCount + 1 WHERE id = ?');
        $userCommentCount ->execute(array($userIdComCounts));
        return $affectedLines;
    }

    public function eraseComment($commentId, $postIdComCounts, $userIdComCounts)
    {
        $comDelete = $this->_db->prepare('DELETE FROM comments WHERE id = ?');
        $comDelete->execute(array($commentId));
        //updates the comment counter +1 to know how much comments have been posted on a post
        $commentCount = $this->_db->prepare('UPDATE posts SET commentCount = commentCount - 1 WHERE id = ?');
        $commentCount ->execute(array($postIdComCounts));

        // //updates the user comment counter +1 to know how much comments the user has posted
        $userCommentCount = $this->_db->prepare('UPDATE members SET userComCount = userComCount - 1 WHERE id = ?');
        $userCommentCount ->execute(array($userIdComCounts));
    }

    public function reportComment($commentId)
    {
        $commentReport = $this->_db->prepare('UPDATE comments SET flag = flag + 1 WHERE id = ?');
        $commentReport->execute(array($commentId));
    }

    //add the reported comment in a new table called reported_comments that gathers the id of the member who reported it, the id of the reported comment and a flag set to 1
    public function reportedCommentPerUser($memberId, $repComId)
    {
        $newRepCom = $this->_db->prepare('INSERT INTO reported_comments( memberId, repComId, flagRep) VALUES(?, ?, 1)');
        $newRepCom->execute(array($memberId, $repComId));
    }

    //check when a member reports a comment if he already reported it once
    public function checkIfAlreadyReportedCom()
    {
        $alreadyRep = $this->_db->query('SELECT memberId, repComId, flagRep FROM reported_comments');
        
        return $alreadyRep;
    }

    public function updateCom($comment, $commentId)
    {
        $updateCom = $this->_db->prepare('UPDATE comments SET comment = ?, updateDate = NOW()  WHERE id = ?');
        $updateCom->execute(array($comment, $commentId));
    }
   
    //erase all the comments related to a post when "delete post" action is done
    public function eraseAllComments($postId)
    {
        $allComDelete = $this->_db->prepare('DELETE FROM comments WHERE postId = ?');
        $allComDelete->execute(array($postId));
    }

    public function approveComment($commentId)
    {
        $commentApprove = $this->_db->prepare('UPDATE comments SET flag = 0 WHERE id = ?');
        $commentApprove->execute(array($commentId));
    }
    



   
    //BACKEND
    //gets the Reported comments (where flag >0 and sort them by number of time reported OR by date showing older first if reported the same nb of times)
    public function getReportedComments()
    {
        $req = $this->_db->query('SELECT id, postId, author, comment, DATE_FORMAT(commentDate, \'%d/%m/%Y à %Hh%imin%ss\') AS modCommentDate, flag FROM comments WHERE flag > 0 AND flag < 9999 ORDER BY flag DESC, commentDate');
        while ($datasReportedComments = $req->fetch(PDO::FETCH_ASSOC))
        {           
            $reportedComments[] = new Comment($datasReportedComments);
        }
        if(!empty($reportedComments)) //needed otherwise gives an error on the commentsView.php when no comments reported
        {
            return $reportedComments;
        } 
    }

    //get new comments (flag value = 9999 by default)
    public function getNewComments()
    {
        $req = $this->_db->query('SELECT id, postId, author, comment, DATE_FORMAT(commentDate, \'%d/%m/%Y à %Hh%imin%ss\') AS modCommentDate, flag FROM comments WHERE flag = 9999 ORDER BY commentDate');
        while ($datasNewComments = $req->fetch(PDO::FETCH_ASSOC))
        {           
            $newComments[] = new Comment($datasNewComments);
        }

        if(!empty($newComments)) //needed otherwise gives an error on the commentsView.php when no new comments to manage
        {
            return $newComments;
        } 
    }

    //must receive an array of ids to delete all the comments at once. (?) = my array, see here https://www.tutorialspoint.com/mysql/mysql-in-clause.htm
    public function eraseAllSelectedComments($arrayCommentsIDs) 
    {
        //on compte la longueur du tableau pour arrêter la boucle for au bon moment
        $arrayLength = count($arrayCommentsIDs, COUNT_NORMAL);
        
        //on fait une boucle pour injecter la VALEUR ENTIERE de chaque entrée du tableau $arrayCommentsIDs en tant que paramètre ? de (IN)
        for( $i = 0; $i < $arrayLength; $i++){
            $id = $arrayCommentsIDs[$i];
            $eraseAllSelectedComments = $this->_db->prepare('DELETE FROM comments WHERE id IN (?)'); // je veux que ? soit les valeurs successives d'un tableau donc je dois faire une boucle
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
            $acceptAllSelectedComments = $this->_db->prepare('UPDATE comments SET flag = 0 WHERE id IN (?)'); // je veux que ? soit les valeurs successives d'un tableau donc je dois faire une boucle
            $acceptAllSelectedComments->execute(array($id));
        }
        
    }

    public function getNbOfReportedComments() // display number of comments to manage 
    {
        $req = $this->_db->query('SELECT SUM(flag) AS flagTotal FROM comments');
        $reportedCommentNb= $req->fetch();
        return $reportedCommentNb;
    }

}