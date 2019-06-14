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





function post()
{

//Pagination for comments
$totalComments = getTotalComments($_GET['id']);
$totalCom=$totalComments['total_comments']; // total of posts in DB

if(isset($_GET['sortBy'])){
    $commentsPerPage = $_GET['sortBy'];
}
else
{
    $commentsPerPage = 5;
}
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

    //check if post exists in DB
    if($post == false)
    {
        throw new Exception('Ce chapitre n\'existe pas');
    }

    
    $comments = getComments($_GET['id'], $firstComment, $commentsPerPage);
    require('view/frontend/postView.php');
}






//-----------------------------------------------------------------------------------------


//SING IN, LOG IN, LOG OUT

// Update password
function displaychangePasswordView()
{
    require('view/frontend/changePassView.php');
}

function UpdatePassWord($newpass, $id)
{
    $UpdatePassWord = UpdatePass($newpass, $id); 
}


function currentPassInDB($currentPass){

    $currentPassInDB = currentPass($currentPass);

    // FIXME ; factoriser la verif de pass entre checklog (C) et action'] == 'UpdatePass (R)
    // Check is password matches the one registered in DB
    $isCurrentPasswordCorrect = password_verify($_POST['newPass'], $currentPassInDB['pass']);
    if (!$currentPassInDB)
    {
        return false;
    }
    else
    {   
        return true;
    }
}



function displaySingInView()
{
    require('view/frontend/singInView.php');
}

function addNewMember($username, $pass, $email)
{
    $newMember = insertMember($username, $pass, $email);

    //success2 needed to display the confirmation message
header('Location: index.php?success=1#header');
exit;
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

    // FIXME ; factoriser la verif de pass entre checklog (C) et action'] == 'UpdatePass (R)
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
            $userNameSession = $_SESSION['username']; //FIXME : USELESS ? 
            
            //if the autolog checkbox is selected COOKIES are created
            if(isset($_POST['autoLogIn']))
            {
                setcookie('id', $checkLogIn['id'], time() + 365*24*3600, null, null, false, true);
                setcookie('login', $_POST['username'], time() + 365*24*3600, null, null, false, true);
                setcookie('hash_pass', password_hash($_POST['pass'], PASSWORD_DEFAULT), time() + 365*24*3600, null, null, false, true);
            }
            
           //redirects on the right page depending on the user group (user / admin) 
           if($checkLogIn['group_id'] == 0){
            header('Location: index.php');
            exit;
           }

           elseif($checkLogIn['group_id'] == 1){
            header('Location: index.php?action=listPostsAdmin');
            exit;
           }

           

        }
        else {
            throw new Exception('Vérifiez vos identifiants de connexion');
        }

        
    }

}







//COMMENTS

function addComment($postId, $author, $comment, $postIdComCounts, $userIdComCounts)
{
    $affectedLines = postComment($postId, $author, $comment,$postIdComCounts, $userIdComCounts);

    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    }
    else {
        //success4 needed to display the confirmation message
        header('Location: index.php?action=post&id=' . $postId . '&success=4&page=1&sortBy=5#commentsAnchor');
        exit;
    }
}

function deleteComment($commentId,  $postIdComCounts, $userIdComCounts)
{
    $comDelete = eraseComment($commentId, $postIdComCounts, $userIdComCounts);
    header('Location: ' . $_SERVER['HTTP_REFERER']); //FIXME : SQL injection issue ? 
    exit;

} 

function reportComments($commentId){
    $commentReported = reportComment($commentId);
    header('Location: ' . $_SERVER['HTTP_REFERER'] . '#commentsAnchor'); //FIXME : SQL injection issue ? 
    exit;
}

function updateComment($comment, $commentId){
    $commentUpdated = updateCom($comment, $commentId);
    header('Location: index.php?action=post&id=' . $_GET['id'] . '&success=5&page=1&sortBy=99999999999999999999#' . $_GET['commentId'] .''); //FIXME : SQL injection issue ? 
    exit;
}



//add the reported comment in a new table called reported_comments that gathers the id of the member who reported it, the id of the reported comment and a flag set to 1
function reportCommentsCheck($memberId, $repComId){
    $newRepComPerUser = reportedCommentPerUser($memberId, $repComId);
   
}

//check when a member reports a comment if he already reported it once
function checkIfReported(){
    $ifReportedCom = checkIfAlreadyReportedCom();

    //we check wether the member is registered with COOKIE or SESSION
    if(isset($_COOKIE['id'])){
    $cookieOrSessionID = $_COOKIE['id'];
    }
    elseif(isset($_SESSION['id'])){
        $cookieOrSessionID = $_SESSION['id'];
    }

    //we have to make a loop to make sure to check all entries of the DB, not only the last added one
    while($datas = $ifReportedCom->fetch())
    {    
    //if the values of the reported comment matches the one in the reported_comment DB then he/she can't report again
    if($cookieOrSessionID == $datas['memberId'] && $_GET['commentId'] == $datas['repComId'] && $datas['flagRep'] == 1 )
                {
                    throw new Exception('Vous avez déja signalé ce commentaire');
                }
    }            
}






function deletePost($postId)
{
    $postDelete = erasePost($postId);
    header('Location: index.php');
    exit;
} 

//erase all the comments related to a post when "delete post" action is done
function deleteAllComments($postId)
{
    $AllcomsDelete = eraseAllComments($postId);
} 


// About
function displayAboutView()
{
    require('view/frontend/aboutView.php');
}


// Contact form
function displayContactView()
{
    require('view/frontend/contactView.php');
}

function sendMessage($firstName, $lastName, $contactEmail, $topic, $messageContent)
{
    $to  = 'alexisxgautier@gmail.com, jean-forteroche@jeanforteroche.com';
    $message = '
    <html>
        <body>
            <p>' .  $messageContent . '</p>
        </body>
    </html>
    ';

    // Headers Content-type must be defined to send an HTML email
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';

    
    // Additional headers
    $headers[] = 'To: Alexis <alexisxgautier@gmail.com>, Jean <jean-forteroche@jeanforteroche.com>';
    $headers[] = 'From: ' . $firstName . ' '. $lastName . '<'. $contactEmail . '>';

    mail($to, $topic, $message, implode("\r\n", $headers));


    //success3 needed to display the confirmation message
    header('Location: index.php?success=3#header');
    exit;  
}