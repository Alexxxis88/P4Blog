<?php

class UserController{

  public function listAllUsers()
  {
      $userManager = new UserManager();
      
   
      $allUsers = $userManager->getAllUsers();
      require('templates/admin/usersView.php');
  }
  
  public function deleteAllSelectedUsers($arrayUsersIDs){
    
      $userManager = new UserManager();
      $deleteAllSelectedUsers = $userManager->eraseAllSelectedUsers($arrayUsersIDs);
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
  }

  public function deleteUser($userId)
  {
      $userManager = new UserManager();
      $userDelete = $userManager->eraseUser($userId);
      header('Location: ' . $_SERVER['HTTP_REFERER']); //FIXME : SQL injection issue ? 
      exit;
  } 

  public function updateUserRole($userRole, $userId)
  {
      $userManager = new UserManager();
      $updateUserRole = $userManager->updateRole($userRole, $userId);
      header('Location: ' . $_SERVER['HTTP_REFERER']); //FIXME : SQL injection issue ? 
      exit;
  }



}
