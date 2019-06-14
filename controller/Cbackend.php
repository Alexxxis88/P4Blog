<?php
require('model/Mbackend.php');

function listPostsAdmin()
{

    //Pagination
    $totalPages = getTotalPagesAdmin();
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

    $postsAdmin = getPostsAdmin($firstEntry, $messagesPerPage);
    require('view/backend/adminView.php');
    

}

// function listResportedComments() // FIXME : a supprimer quand manage comments marchera
// {
//     $reportedComments = getReportedComments();
//     require('view/backend/commentsView.php');
// }






function listAllUsers()
{

    //Pagination
    $totalPages = getTotalPagesUsers();
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

    $allUsers = getAllUsers($firstUser, $usersPerPage);
    require('view/backend/usersView.php');
    

}






function deleteAllSelectedUsers($arrayUsersIDs){
    
    // $arrayCommentsIDs = array(161, 162, 163, 164); //working FIXME : a supprimer
    $deleteAllSelectedUsers = eraseAllSelectedUsers($arrayUsersIDs);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}


function deleteUser($userId)
{
    $userDelete = eraseUser($userId);
    header('Location: ' . $_SERVER['HTTP_REFERER']); //FIXME : SQL injection issue ? 
    exit;

} 


function updateUserRole($userRole, $userId)
{
    $updateUserRole = updateRole($userRole, $userId);
    header('Location: ' . $_SERVER['HTTP_REFERER']); //FIXME : SQL injection issue ? 
    exit;
}




//display reported and new comments
function listAllComments()
{
    $reportedComments = getReportedComments();
    $newComments = getNewComments();
    require('view/backend/commentsView.php');
}


function deleteAllSelectedComments($arrayCommentsIDs){
    
    // $arrayCommentsIDs = array(161, 162, 163, 164); //working FIXME : a supprimer
    $deleteAllSelectedComments = eraseAllSelectedComments($arrayCommentsIDs);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}


function approveAllSelectedComments($arrayCommentsIDs){
    
    $approveAllSelectedComments = acceptAllSelectedComments($arrayCommentsIDs);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}




function nbOfReportedComments() // NOT WORKING : display number of comments to manage 
{
    $nbOfReportedComments = getNbOfReportedComments();

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
    $commentApproved = approveComment($commentId);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
function newPost($chapter, $title, $content)
{
    $newPost = insertNewPost($chapter, $title, $content);
    header('Location: index.php?action=listPostsAdmin');
    exit;
}

function displayPublishView()
{
    require('view/backend/publishView.php');
}


function displayPostToEdit($postId)
{
    $displayedPostToEdit = getPostToEdit($postId);
    require('view/backend/manageView.php');
}

function updatePost($chapter, $title, $content, $postId){
    $updatedPost = editPost($chapter, $title, $content, $postId);
    header('Location: index.php?action=post&id=' . $postId . '&page=1&sortBy=5');
    exit;
}



//Statistics 

function displayStatsView()
{


    
    $allPostsStats = getPostStats();
    //gets the number of comments per post 
    // $comsPerPost = nbComPerPost($_GET['id']); //NOT WORKING

    
    // $totalComments = getTotalComments($_GET['id']);
    // $totalCom=$totalComments['total_comments']; //NOT WORKING

    $exec = statsPosts();
    $rankingBestPost = rankingBest();
    $rankingWorstPost = rankingWorst();
    $oldestUserRegistered = oldestUser();
    $newestUserRegistered = newestUser();
    $bestContributor = mostComUser();
    $worstContributor = leastComUser();
    require('view/backend/statsView.php');
}



