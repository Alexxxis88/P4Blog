<?php

//AUTOLOAD
function classAutoLoad($class)
{
  require 'model/' . $class . '.php'; 
}

spl_autoload_register('classAutoLoad');


//POSTS
function listPostsAdmin()
{

    $postManager = new PostManager();

    //Pagination
    $totalPages = $postManager->getTotalPagesAdmin();
    $total=$totalPages['total_posts']; // total of posts in DB
    $messagesPerPage=5;
    $nbOfPages=ceil($total/$messagesPerPage);

    if(isset($_GET['page']))
    {
        $currentPage=intval($_GET['page']); //intval gets the integer ( 4.2 = 4) value of a variable
    
        if($currentPage>$nbOfPages) // if a user puts the value of a page that doesnt exist, it redirects to the last page ($nbOfPages)
        {
            $currentPage=$nbOfPages;
        }
    }
    else
    {
        $currentPage=1; 
    }

    $firstEntry=($currentPage-1)*$messagesPerPage; // first entry to read
 
//Display post depending on pagination parameters

    $postsAdmin = $postManager->getPostsAdmin($firstEntry, $messagesPerPage);
    require('view/backend/adminView.php');
}


function displayPublishView()
{
    require('view/backend/publishView.php');
}

function newPost($chapter, $title, $content)
{   
    $postManager = new PostManager();

    $newPost = $postManager->insertNewPost($chapter, $title, $content);
    header('Location: index.php?action=listPostsAdmin');
    exit;
}



function displayPostToEdit($postId)
{   
    $postManager = new PostManager();

    $displayedPostToEdit = $postManager->getPostToEdit($postId);
    require('view/backend/manageView.php');
}

function updatePost($chapter, $title, $content, $postId)
{
    $postManager = new PostManager();

    $updatedPost = $postManager->editPost($chapter, $title, $content, $postId);
    header('Location: index.php?action=post&id=' . $postId . '&page=1&sortBy=5');
    exit;
}



//USERS
function listAllUsers()
{
    $userManager = new UserManager();
    
    //Pagination
    $totalPages = $userManager->getTotalPagesUsers();
    $total=$totalPages['total_users']; // total of users in DB

    if(isset($_GET['sortBy'])){
        $usersPerPage = $_GET['sortBy'];
    }
    else
    {
        $usersPerPage = 10;
    }
    $nbOfPages=ceil($total/$usersPerPage);

    if(isset($_GET['page']))
    {
        $currentPage=intval($_GET['page']); //intval gets the integer ( 4.2 = 4) value of a variable
    
        if($currentPage>$nbOfPages) // if a user puts the value of a page that doesnt exist, it redirects to the last page ($nbOfPages)
        {
            $currentPage=$nbOfPages;
        }
    }
    else
    {
        $currentPage=1; 
    }

    $firstUser=($currentPage-1)*$usersPerPage; // first user to display
 

//Display user depending on pagination parameters

    $allUsers = $userManager->getAllUsers($firstUser, $usersPerPage);
    require('view/backend/usersView.php');
}



function deleteAllSelectedUsers($arrayUsersIDs){
    
    $userManager = new UserManager();

    $deleteAllSelectedUsers = $userManager->eraseAllSelectedUsers($arrayUsersIDs);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}


function deleteUser($userId)
{
    $userManager = new UserManager();

    $userDelete = $userManager->eraseUser($userId);
    header('Location: ' . $_SERVER['HTTP_REFERER']); //FIXME : SQL injection issue ? 
    exit;
} 


function updateUserRole($userRole, $userId)
{
    $userManager = new UserManager();

    $updateUserRole = $userManager->updateRole($userRole, $userId);
    header('Location: ' . $_SERVER['HTTP_REFERER']); //FIXME : SQL injection issue ? 
    exit;
}



//COMMENTS

//display reported and new comments
function listAllComments()
{
    $commentManager = new CommentManager();

    $reportedComments = $commentManager->getReportedComments();
    $newComments = $commentManager->getNewComments();
    require('view/backend/commentsView.php');
}


function deleteAllSelectedComments($arrayCommentsIDs)
{
    $commentManager = new CommentManager();
    
    $deleteAllSelectedComments = $commentManager->eraseAllSelectedComments($arrayCommentsIDs);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}


function approveAllSelectedComments($arrayCommentsIDs)
{
    $commentManager = new CommentManager();

    $approveAllSelectedComments = $commentManager->acceptAllSelectedComments($arrayCommentsIDs);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}




function nbOfReportedComments() // NOT WORKING : display number of comments to manage 
{   
    $commentManager = new CommentManager();

    $nbOfReportedComments = $commentManager->getNbOfReportedComments();

    // if($nbOfReportedComments>0){
    // ? >
    // <!-- displays an alert icon if comments to manage -->   
    //     <script>
    //             if ( !$.trim($('.reportedComments').html() ).length ) 
    //             {
    //                     $('.comAlert').css("display", "none");
    //             } else {
    //                     $('.comAlert').css("display", "block");
    //             }
    //    </script> 
    // <?php        
    // }
}


function approveComments($commentId){
    
    $commentManager = new CommentManager();

    $commentApproved =  $commentManager->approveComment($commentId);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}



//STATISTICS 

function displayStatsView()
{
    $statsManager = new StatsManager();

    // $allPostsStats = getPostStats(); // FIXME voir allPostsStats(statsView.php et M, a virer aussi)
    $usersStats = $statsManager->getUsersStats();
    $exec =  $statsManager->statsPosts();
    $rankingBestPost =  $statsManager->rankingBest();
    $rankingWorstPost =  $statsManager->rankingWorst();
    $oldestUserRegistered =  $statsManager->oldestUser();
    $newestUserRegistered =  $statsManager->newestUser();
    $bestContributor =  $statsManager->mostComUser();
    $worstContributor =  $statsManager->leastComUser();

    require('view/backend/statsView.php');
}



