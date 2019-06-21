<?php

class CommentController{

    function addComment($postId, $author, $comment, $postIdComCounts, $userIdComCounts)
    {   
        $commentManager = new CommentManager();
        $affectedLines = $commentManager->postComment($postId, $author, $comment,$postIdComCounts, $userIdComCounts);
        if ($affectedLines === false) {
            throw new Exception('Impossible d\'ajouter le commentaire !');
        }
        else {
            //success4 needed to display the confirmation message
            header('Location: index.php?action=post&id=' . $postId . '&success=4&page=1&sortBy=5#commentsAnchor');
            exit;
        }
    }

    function deleteComment($commentId,  $postIdComCounts
    //, $userIdComCounts
    )
    {   
        $commentManager = new CommentManager();
        $comDelete = $commentManager->eraseComment($commentId, $postIdComCounts
        //, $userIdComCounts
        );
        header('Location: ' . $_SERVER['HTTP_REFERER']); //FIXME : SQL injection issue ? 
        exit;
    } 

    function reportComments($commentId){
        $commentManager = new CommentManager();
        $commentReported = $commentManager->reportComment($commentId);
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '#commentsAnchor'); //FIXME : SQL injection issue ? 
        exit;
    }

    function updateComment($comment, $commentId){
        $commentManager = new CommentManager();
        $commentUpdated = $commentManager->updateCom($comment, $commentId);
        header('Location: index.php?action=post&id=' . $_GET['id'] . '&success=5&page=1&sortBy=99999999999999999999#' . $_GET['commentId'] .''); //FIXME : SQL injection issue ? 
        exit;
    }

    //add the reported comment in a new table called reported_comments that gathers the id of the member who reported it, the id of the reported comment and a flag set to 1
    function reportCommentsCheck($memberId, $repComId){
        $commentManager = new CommentManager();
        $newRepComPerUser = $commentManager->reportedCommentPerUser($memberId, $repComId);
       
    }

    //check when a member reports a comment if he already reported it once
    function checkIfReported(){
        $commentManager = new CommentManager();
        $sessionManager = new SessionManager();
        $ifReportedCom = $commentManager->checkIfAlreadyReportedCom();
        $cookieOrSessionID = $sessionManager->checkSession();
        //we have to make a loop to make sure to check all entries of the DB, not only the last added one
        while($datas = $ifReportedCom->fetch())
        {    
        //if the values of the reported comment matches the one in the reported_comment DB then he/she can't report again
        if($cookieOrSessionID == $datas['memberId'] && $_GET['commentId'] == $datas['repComId'] && $datas['flagRep'] == 1 )
                    {
                        throw new Exception('Vous avez déja signalé ce commentaire');
                    }
        }            
    }

    //erase all the comments related to a post when "delete post" action is done
    function deleteAllComments($postId)
    {   
        $commentManager = new CommentManager();
        $AllcomsDelete = $commentManager->eraseAllComments($postId);
    } 
    

   




}
