<?php

class StatsController{
  
    public function displayStatsView()
    {
    $sessionController = new SessionController;
    $checkUserRole = $sessionController->checkUserRole();
    if($checkUserRole['groupId'] != 1)
    {
        throw new Exception('Vous n\'avez pas accès à cette page');
    }

    //change color of the menu comment icon in red if comments to manage FIXME : factoriser ? au lieu de copier plein de fois ? 
    $commentManager = new CommentManager();
    $nbOfReportedComments = $commentManager->getNbOfReportedComments();
    
    $statsManager = new StatsManager();
    $usersStats = $statsManager->getUsersStats();
    $exec =  $statsManager->statsPosts();
    $rankingBestPost =  $statsManager->rankingBest();
    $rankingWorstPost =  $statsManager->rankingWorst();
    $oldestUserRegistered =  $statsManager->oldestUser();
    $newestUserRegistered =  $statsManager->newestUser();
    $bestContributor =  $statsManager->mostComUser();
    $worstContributor =  $statsManager->leastComUser();
    require('templates/admin/statsView.php');
    }
  


}
