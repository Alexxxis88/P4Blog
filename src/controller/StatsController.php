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

    $statsManager = new StatsManager();
    $usersStats = $statsManager->getUsersStats();
    $exec =  $statsManager->statsPosts();
    $rankingBestPost =  $statsManager->ranking("DESC"); //FIXME:not working
    $rankingWorstPost =  $statsManager->ranking("ASC"); //FIXME:not working
    $oldestUserRegistered =  $statsManager->oldestUser();
    $newestUserRegistered =  $statsManager->newestUser();
    $bestContributor =  $statsManager->mostComUser();
    $worstContributor =  $statsManager->leastComUser();
    require('templates/admin/statsView.php');
    }
  


}
