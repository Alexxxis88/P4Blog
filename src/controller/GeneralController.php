<?php

class GeneralController{

    public function displayAboutView()
    {   
        //change color of the menu comment icon in red if comments to manage FIXME : factoriser ? au lieu de copier plein de fois ? 
        $commentManager = new CommentManager();
        $nbOfReportedComments = $commentManager->getNbOfReportedComments();

        $sessionController = new SessionController;
        $checkUserRole = $sessionController->checkUserRole();
        require('templates/front/aboutView.php');
    }

    public function displayLegalNoticeView()
    {   
        //change color of the menu comment icon in red if comments to manage FIXME : factoriser ? au lieu de copier plein de fois ? 
        $commentManager = new CommentManager();
        $nbOfReportedComments = $commentManager->getNbOfReportedComments();
        
        $sessionController = new SessionController;
        $checkUserRole = $sessionController->checkUserRole();
        require('templates/front/legalNoticeView.php');
    }

}
