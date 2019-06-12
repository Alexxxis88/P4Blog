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

function addComment($postId, $author, $comment)
{
    $affectedLines = postComment($postId, $author, $comment);

    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    }
    else {
        //success4 needed to display the confirmation message
        header('Location: index.php?action=post&id=' . $postId . '&success=4#commentsAnchor');
        exit;
    }
}

function deleteComment($commentId)
{
    $comDelete = eraseComment($commentId);
    header('Location: ' . $_SERVER['HTTP_REFERER']); //FIXME : SQL injection issue ? 
    exit;

} 

function reportComments($commentId){
    $commentReported = reportComment($commentId);
    header('Location: index.php?action=post&id=' . $_GET['id'] . '#commentsAnchor'); //FIXME : SQL injection issue ? 
    exit;
}



function deletePost($postId)
{
    $postDelete = erasePost($postId);
    header('Location: ' . $_SERVER['HTTP_REFERER']); //FIXME problem = when delete button used on a specific post (BE), sends back to post that has just been deleted. + not good to use ? see : https://stackoverflow.com/questions/5285031/back-to-previous-page-with-header-location-in-php
    exit;
} 

//erase all the comments related to a post when "delete post" action is done
function deleteAllComments($postId)
{
    $AllcomsDelete = eraseAllComments($postId);
    header('Location: ' . $_SERVER['HTTP_REFERER']); //FIXME problem = when delete button used on a specific post (BE), sends back to post that has just been deleted.
    exit;
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