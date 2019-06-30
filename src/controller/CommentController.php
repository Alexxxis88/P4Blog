<?php
class CommentController
{
    public function addComment($postId, $author, $comment, $postIdComCounts, $userIdComCounts)
    {
        $commentManager = new CommentManager();
        $affectedLines = $commentManager->postComment($postId, htmlspecialchars($author), htmlspecialchars($comment), $postIdComCounts, $userIdComCounts);
        if ($affectedLines === false) {
            throw new Exception('Impossible d\'ajouter le commentaire !');
        } else {

            header('Location: index.php?action=post&id=' . $postId . '&success=4&page=1&sortBy=5#commentsAnchor');
            exit;
        }
    }

    public function approveComments($commentId)
    {
        $commentManager = new CommentManager();
        $commentApproved =  $commentManager->approveComment($commentId);
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '&success=6');
        exit;
    }

    public function deleteComment($commentId, $postIdComCounts, $userIdComCounts)
    {
        $commentManager = new CommentManager();
        $comDelete = $commentManager->eraseComment($commentId, $postIdComCounts, $userIdComCounts);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function reportComments($commentId)
    {
        $commentManager = new CommentManager();
        $commentReported = $commentManager->reportComment($commentId);
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '#commentsAnchor');
        exit;
    }

    public function updateComment($comment, $commentId)
    {
        $commentManager = new CommentManager();
        $commentUpdated = $commentManager->updateCom(htmlspecialchars($comment), $commentId);
        header('Location: index.php?action=post&id=' . $_GET['id'] . '&success=5&page=1&sortBy=99999999999999999999#' . $_GET['commentId'] .'');
        exit;
    }

    //add the reported comment in a new table called reported_comments that gathers the id of the member who reported it, the id of the reported comment and a flag set to 1
    public function reportCommentsCheck($memberId, $repComId)
    {
        $commentManager = new CommentManager();
        $newRepComPerUser = $commentManager->reportedCommentPerUser($memberId, $repComId);
    }

    //check when a member reports a comment if he already reported it once
    public function checkIfReported()
    {
        $commentManager = new CommentManager();
        $sessionController = new sessionController();
        $ifReportedCom = $commentManager->checkIfAlreadyReportedCom();
        $cookieOrSessionID = $sessionController->checkSession();
        //we have to make a loop to make sure to check all entries of the DB, not only the last added one
        while ($datas = $ifReportedCom->fetch()) {
            //if the values of the reported comment matches the one in the reported_comment DB then he/she can't report again
            if ($cookieOrSessionID == $datas['memberId'] && $_GET['commentId'] == $datas['repComId'] && $datas['flagRep'] == 1) {
                throw new Exception('Vous avez déja signalé ce commentaire');
            }
        }
    }

    //erase all the comments related to a post when "delete post" action is done
    public function deleteAllComments($postId)
    {
        $commentManager = new CommentManager();
        $AllcomsDelete = $commentManager->eraseAllComments($postId);
    }


    //display reported and new comments
    public function listAllComments()
    {
        //comments to manage red icon
        $commentManager = new CommentManager();
        $nbOfReportedComments = $commentManager->getNbOfReportedComments();

        //check the role of the logged in user to display or not Admin features
        $sessionController = new SessionController;
        $checkUserRole = $sessionController->checkUserRole();
        if ($checkUserRole['groupId'] != 1) {
            throw new Exception('Vous n\'avez pas accès à cette page');
        }

        $commentManager = new CommentManager();
        $reportedComments = $commentManager->getReportedComments();
        $newComments = $commentManager->getNewComments();
        require('templates/admin/commentsView.php');
    }

    public function deleteAllSelectedComments($arrayCommentsIDs)
    {
        $commentManager = new CommentManager();
        $deleteAllSelectedComments = $commentManager->eraseAllSelectedComments($arrayCommentsIDs);
        header('Location: index.php?action=manageComments');
        exit;
    }

    public function approveAllSelectedComments($arrayCommentsIDs)
    {
        $commentManager = new CommentManager();
        $approveAllSelectedComments = $commentManager->acceptAllSelectedComments($arrayCommentsIDs);
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '&success=6');
        exit;
    }
}
