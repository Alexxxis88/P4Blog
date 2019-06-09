<?php
require('model/Mfrontend.php');


//gets all the post to display in listPostsView. 
function listPosts()
{
//Pagination
    $totalPages = getTotalPages();
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
    $posts = getPosts($firstEntry, $messagesPerPage);

    require('view/frontend/listPostsView.php');
}




//-----------------------------------------------------------------------------------------
// NOT WORKING : show more / less comments
// function post($commentsLimit)
// {
//     $lastPosts = getLastPosts();
//     $post = getPost($_GET['id']);
//     $comments = getComments($_GET['id'], $commentsLimit);
//     require('view/frontend/postView.php');
// }


//WORKING
function post()
{

//Pagination for comments
$totalComments = getTotalComments($_GET['id']);
$totalCom=$totalComments['total_comments']; // total of posts in DB
$commentsPerPage=4;
$nbOfCommentsPages=ceil($totalCom/$commentsPerPage);

if(isset($_GET['page']))
{
    $currentCommentPage=intval($_GET['page']); //intval gets the integer ( 4.2 = 4) value of a variable

    if($currentCommentPage>$nbOfCommentsPages) // if a user puts the value of a page that doesnt exist, it redirects to the last page ($nbOfCommentsPages)
    {
        $currentCommentPage=$nbOfCommentsPages;
    }
}
else
{
    $currentCommentPage=1; 
}

$firstComment=($currentCommentPage-1)*$commentsPerPage; // first comment to read

    $lastPosts = getLastPosts();
    $post = getPost($_GET['id']);
    $comments = getComments($_GET['id'], $firstComment, $commentsPerPage);
    require('view/frontend/postView.php');
}

//-----------------------------------------------------------------------------------------


//SING IN, LOG IN, LOG OUT
function displaySingInView()
{
    require('view/frontend/singInView.php');
}

function addNewMember($username, $pass, $email)
{
    $newMember = insertMember($username, $pass, $email);

    //success1 needed to display the confirmation message
header('Location: index.php?success=1#header');
}


function checkUsernameAvailability($userName)
{
    $checkUsername = checkUsername($userName);
    if($checkUsername)
        {
            return true;
        }
        else
        {
            return false;
        }
}

function checkEmailAvailability($email)
{
    $checkEmail = checkEmail($email);
    if($checkEmail)
        {
            return true;
        }
        else
        {
            return false;
        }
}

function checkLog($userName)
{
    $checkLogIn = checkLogIn($userName);


    // Check is password matches the one registered in DB
    $isPasswordCorrect = password_verify($_POST['pass'], $checkLogIn['pass']);
    if (!$checkLogIn)
    {
        throw new Exception('Vérifiez vos identifiants de connexion');
    }
    else
    {   //if the password is Correct SESSION variables are created
        if ($isPasswordCorrect) {
            $_SESSION['id'] = $checkLogIn['id'];
            $_SESSION['username'] = $userName;
            $userNameSession = $_SESSION['username'];
            
            //if the autolog checkbox is selected COOKIES are created
            if(isset($_POST['autoLogIn']))
            {
                setcookie('login', $_POST['username'], time() + 365*24*3600, null, null, false, true);
                setcookie('hash_pass', password_hash($_POST['pass'], PASSWORD_DEFAULT), time() + 365*24*3600, null, null, false, true);
            }
            
           //redirects on the right page depending on the user group (user / admin) 
           if($checkLogIn['group_id'] == 0){
            header('Location: index.php');
           }

           elseif($checkLogIn['group_id'] == 1){
            header('Location: index.php?action=listPostsAdmin');
           }

           

        }
        else {
            throw new Exception('Vérifiez vos identifiants de connexion');
        }

        
    }

}







//COMMENTS

function addComment($postId, $author, $comment)
{
    $affectedLines = postComment($postId, $author, $comment);

    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    }
    else {
        header('Location: index.php?action=post&id=' . $postId);
    }
}

function deleteComment($commentId)
{
    $comDelete = eraseComment($commentId);
    header('Location: ' . $_SERVER['HTTP_REFERER']); //FIXME : SQL injection issue ? 

} 

function reportComments($commentId){
    $commentReported = reportComment($commentId);
    header('Location: index.php?action=post&id=' . $_GET['id'] . '#commentsAnchor'); //FIXME : SQL injection issue ? 
}



function deletePost($postId)
{
    $postDelete = erasePost($postId);
    header('Location: ' . $_SERVER['HTTP_REFERER']); //FIXME problem = when delete button used on a specific post (BE), sends back to post that has just been deleted. + not good to use ? see : https://stackoverflow.com/questions/5285031/back-to-previous-page-with-header-location-in-php
} 

//erase all the comments related to a post when "delete post" action is done
function deleteAllComments($postId)
{
    $AllcomsDelete = eraseAllComments($postId);
    header('Location: ' . $_SERVER['HTTP_REFERER']); //FIXME problem = when delete button used on a specific post (BE), sends back to post that has just been deleted.
} 
