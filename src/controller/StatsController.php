<?php

class StatsController
{
    public function displayStatsView()
    {
        $sessionController = new SessionController;
        $checkUserRole = $sessionController->checkUserRole();
        if ($checkUserRole['groupId'] != 1) {
            throw new Exception('Vous n\'avez pas accès à cette page');
        }

        //comments to manage red icon
        $commentManager = new CommentManager();
        $nbOfReportedComments = $commentManager->getNbOfReportedComments();

        $statsManager = new StatsManager();
        $usersStats = $statsManager->getUsersStats();
        $chartStats =  $statsManager->statsPosts();
        $rankingBestPost =  $statsManager->rankingBest();
        $rankingWorstPost =  $statsManager->rankingWorst();
        $oldestUserRegistered =  $statsManager->oldestUser();
        $newestUserRegistered =  $statsManager->newestUser();
        $bestContributor =  $statsManager->mostComUser();
        $worstContributor =  $statsManager->leastComUser();
        require('templates/admin/statsView.php');
    }
}
