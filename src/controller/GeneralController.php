<?php

class GeneralController{

    public function displayAboutView()
    {   
        $sessionController = new SessionController;
        $checkUserRole = $sessionController->checkUserRole();
        require('templates/front/aboutView.php');
    }

    public function displayLegalNoticeView()
    {   
        $sessionController = new SessionController;
        $checkUserRole = $sessionController->checkUserRole();
        require('templates/front/legalNoticeView.php');
    }

}
