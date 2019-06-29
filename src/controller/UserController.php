<?php

class UserController
{
    public function listAllUsers()
    {
        $sessionController = new SessionController;
        $checkUserRole = $sessionController->checkUserRole();
        if ($checkUserRole['groupId'] != 1) {
            throw new Exception('Vous n\'avez pas accès à cette page');
        }

        //comments to manage red icon
        $commentManager = new CommentManager();
        $nbOfReportedComments = $commentManager->getNbOfReportedComments();

        $userManager = new UserManager();

        //Pagination
        $totalPages = $userManager->getTotalPagesUsers();
        $total = $totalPages['total_users']; // total of users in DB

        if (isset($_GET['sortBy'])) {
            $usersPerPage = $_GET['sortBy'];
        } else {
            $usersPerPage = 10;
        }

        $nbOfPages = ceil($total/$usersPerPage);

        if (isset($_GET['page'])) {
            $currentPage = intval($_GET['page']);

            if ($currentPage>$nbOfPages) { // if a user puts the value of a page that doesnt exist, it redirects to the last page ($nbOfPages)
                $currentPage=$nbOfPages;
            }
        } else {
            $currentPage = 1;
        }
        $firstUser = ($currentPage-1)*$usersPerPage; // first user to display
        $currentView = "users"; //to display the correct Pagination View
        $allUsers = $userManager->getAllUsers($firstUser, $usersPerPage);
        require('templates/admin/usersView.php');
    }

    public function deleteAllSelectedUsers($arrayUsersIDs)
    {
        $userManager = new UserManager();
        $deleteAllSelectedUsers = $userManager->eraseAllSelectedUsers($arrayUsersIDs);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function deleteUser($userId)
    {
        $userManager = new UserManager();
        $userDelete = $userManager->eraseUser($userId);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function updateUserRole($userRole, $userId)
    {
        $userManager = new UserManager();
        $updateUserRole = $userManager->updateRole($userRole, $userId);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
