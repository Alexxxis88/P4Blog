<?php

class GeneralController
{
    public function displayAboutView()
    {
        //comments to manage red icon
        $commentManager = new CommentManager();
        $nbOfReportedComments = $commentManager->getNbOfReportedComments();

        $sessionController = new SessionController;
        $checkUserRole = $sessionController->checkUserRole();
        require('templates/front/aboutView.php');
    }

    public function displayLegalNoticeView()
    {
        //comments to manage red icon
        $commentManager = new CommentManager();
        $nbOfReportedComments = $commentManager->getNbOfReportedComments();
        
        $sessionController = new SessionController;
        $checkUserRole = $sessionController->checkUserRole();
        require('templates/front/legalNoticeView.php');
    }
}
