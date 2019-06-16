<?php





//gets the last X posts to display in adminView. X depends on $messagesPerPage
function getPostsAdmin($firstEntry, $messagesPerPage)
{
    $db = dbConnectAdmin();
    $req = $db->prepare('SELECT id, chapter_nb, title, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_publish_date, DATE_FORMAT(edit_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_edit_date FROM posts ORDER BY publish_date DESC LIMIT ?, ?');
    $req->bindValue(1, $firstEntry, PDO::PARAM_INT);
    $req->bindValue(2, $messagesPerPage, PDO::PARAM_INT);
    $req->execute();
    return $req;
}


//Pagination
function getTotalPagesAdmin(){
    $db = dbConnect();
    $getTotalPagesAdmin = $db->query('SELECT COUNT(*) AS total_posts FROM posts');
    $returnTotalPagesAdmin= $getTotalPagesAdmin->fetch();

    return $returnTotalPagesAdmin;
}






//gets all the users
function getAllUsers($firstUser, $usersPerPage)
{
    $db = dbConnectAdmin();
    $allUsers = $db->prepare('SELECT id, username, email, DATE_FORMAT(registration_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_registration_date, group_id FROM members ORDER BY username LIMIT ?, ?');
    $allUsers->bindValue(1, $firstUser, PDO::PARAM_INT);
    $allUsers->bindValue(2, $usersPerPage, PDO::PARAM_INT);
    $allUsers->execute();
    return $allUsers;
}



//Pagination
function getTotalPagesUsers(){
    $db = dbConnect();
    $getTotalPagesUsers = $db->query('SELECT COUNT(*) AS total_users FROM members');
    $returnTotalPagesUsers= $getTotalPagesUsers->fetch();

    return $returnTotalPagesUsers;
}





//must receive an array of ids to delete all the users at once. (?) = my array, see here https://www.tutorialspoint.com/mysql/mysql-in-clause.htm
function eraseAllSelectedUsers($arrayUsersIDs) //NOT WORKING :
{
    //on compte la longueur du tableau pour arrêter la boucle for au bon moment
    $arrayLength = count($arrayUsersIDs, COUNT_NORMAL);
    
    //on fait une boucle pour injecter la VALEUR ENTIERE de chaque entrée du tableau $arrayUsersIDs en tant que paramètre ? de (IN)
    for( $i = 0; $i < $arrayLength; $i++){
        $id = $arrayUsersIDs[$i];
        $db = dbConnectAdmin();
        $eraseAllSelectedUsers = $db->prepare('DELETE FROM members WHERE id IN (?)'); // je veux que ? soit les valeurs successives d'un tableau donc je dois faire une boucle
        $eraseAllSelectedUsers->execute(array($id));
    }
    
}


function eraseUser($userId)
{
    $db = dbConnect();
    $useDelete = $db->prepare('DELETE FROM members WHERE id = ?');
    $useDelete->execute(array($userId));
}


function updateRole($userRole, $userId)
{
    $db = dbConnect();
    $userUpdate = $db->prepare('UPDATE members SET group_id = ? WHERE id = ?');
    $userUpdate->execute(array($userRole, $userId));
}







//gets the Reported comments (where flag >0 and sort them by number of time reported OR by date showing older first if reported the same nb of times)
function getReportedComments()
{
    $db = dbConnectAdmin();
    $reportedComment = $db->query('SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_comment_date, flag FROM comments WHERE flag > 0 AND flag < 9999 ORDER BY flag DESC, comment_date');

    return $reportedComment;
}

//get new comments (flag value = 9999 by default)
function getNewComments()
{
    $db = dbConnectAdmin();
    $newComment = $db->query('SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_comment_date, flag FROM comments WHERE flag = 9999 ORDER BY comment_date');

    return $newComment;
}

//must receive an array of ids to delete all the comments at once. (?) = my array, see here https://www.tutorialspoint.com/mysql/mysql-in-clause.htm
function eraseAllSelectedComments($arrayCommentsIDs) //NOT WORKING :
{
    //on compte la longueur du tableau pour arrêter la boucle for au bon moment
    $arrayLength = count($arrayCommentsIDs, COUNT_NORMAL);
    
    //on fait une boucle pour injecter la VALEUR ENTIERE de chaque entrée du tableau $arrayCommentsIDs en tant que paramètre ? de (IN)
    for( $i = 0; $i < $arrayLength; $i++){
        $id = $arrayCommentsIDs[$i];
        $db = dbConnectAdmin();
        $eraseAllSelectedComments = $db->prepare('DELETE FROM comments WHERE id IN (?)'); // je veux que ? soit les valeurs successives d'un tableau donc je dois faire une boucle
        $eraseAllSelectedComments->execute(array($id));
    }
    
}

//accept all the selected reported comments
function acceptAllSelectedComments($arrayCommentsIDs) 
{
    //on compte la longueur du tableau pour arrêter la boucle for au bon moment
    $arrayLength = count($arrayCommentsIDs, COUNT_NORMAL);
    
    //on fait une boucle pour injecter la VALEUR ENTIERE de chaque entrée du tableau $arrayCommentsIDs en tant que paramètre ? de (IN)
    for( $i = 0; $i < $arrayLength; $i++){
        $id = $arrayCommentsIDs[$i];
        $db = dbConnectAdmin();
        $acceptAllSelectedComments = $db->prepare('UPDATE comments SET flag = 0 WHERE id IN (?)'); // je veux que ? soit les valeurs successives d'un tableau donc je dois faire une boucle
        $acceptAllSelectedComments->execute(array($id));
    }
    
}








function getNbOfReportedComments() // display number of comments to manage 
{
    $db = dbConnectAdmin();
    $reportedCommentNb = $db->query('SELECT SUM(flag) AS flag_total FROM comments');

    return $reportedCommentNb;
}








function approveComment($commentId){
    $db = dbConnectAdmin();
    $commentApprove = $db->prepare('UPDATE comments SET flag = 0 WHERE id = ?');
    $commentApprove->execute(array($commentId));
}
 
function insertNewPost($chapter, $title, $content)
{
    $db = dbConnectAdmin();
    $newPostDb = $db->prepare('INSERT INTO posts( chapter_nb, title, content, publish_date, edit_date) VALUES(?, ?, ?, NOW(), NOW())');
    $newPostDb->execute(array($chapter, $title, $content));
}

function getPostToEdit($postId)
{
    $db = dbConnectAdmin();
    $req = $db->prepare('SELECT id, chapter_nb, title, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_publish_date, DATE_FORMAT(edit_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_edit_date FROM posts WHERE id = ?');
    $req->execute(array($postId));
    $postToEdit = $req->fetch();

    return $postToEdit;
}

function editPost($chapter, $title, $content, $postId)
{
    $db = dbConnectAdmin();
    $editedPost = $db->prepare('UPDATE posts SET chapter_nb = ?, title = ?, content = ?, edit_date = NOW() WHERE id = ?');
    $editedPost->execute(array($chapter, $title, $content, $postId));

}



//Statistics 

//gets the number of comments per post
function nbComPerPost($postId){
    $db = dbConnectAdmin();
    $totalComPerPosts = $db->prepare(
        'SELECT COUNT(*) AS nb_com, p.id
            FROM posts p 
            INNER JOIN comments c 
            ON c.post_id = p.id
            WHERE p.id = ?
            ');
    $totalComPerPosts->execute(array($postId));

    return $totalComPerPosts;
}

// //gets all the posts to display them in stats view

// function getPostStats() //FIXME : remove this function in favor of the next one ? voir allPostsStats(statsView.php et C, a virer aussi)
// {
//     $db = dbConnectAdmin();
//     $postsStats = $db->query('SELECT id, chapter_nb, title, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_publish_date, DATE_FORMAT(edit_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_edit_date, comment_count FROM posts ORDER BY publish_date DESC ');
    
//     return $postsStats;
// }

function statsPosts() 
{
    $db = mysqli_connect('localhost','root','','p4blog');
    $query = "SELECT * from posts";
    $exec = mysqli_query($db,$query);

    return $exec;
}


function rankingBest(){

    $db = dbConnectAdmin();
    $req = $db->query('SELECT id, chapter_nb, title, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_publish_date, comment_count FROM posts ORDER BY comment_count DESC, publish_date DESC  LIMIT 1 ');
    $rankingBest = $req->fetch();
    return $rankingBest;
}

function rankingWorst(){

    $db = dbConnectAdmin();
    $req = $db->query('SELECT id, chapter_nb, title, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_publish_date, comment_count FROM posts ORDER BY comment_count, publish_date LIMIT 1 ');
    $rankingWorst = $req->fetch();
    return $rankingWorst;
}



//gets all the users to display them in stats view
function getUsersStats()
{
    $db = dbConnectAdmin();
    $usersStats = $db->query('SELECT id, username, DATE_FORMAT(registration_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_registration_date, user_com_count FROM members ORDER BY user_com_count DESC LIMIT 0, 10 ');
    
    return $usersStats;
}

function oldestUser(){

    $db = dbConnectAdmin();
    $req = $db->query('SELECT id, username, DATE_FORMAT(registration_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_registration_date FROM members ORDER BY registration_date  LIMIT 1 ');
    $oldestUser = $req->fetch();
    return $oldestUser;
}

function newestUser(){

    $db = dbConnectAdmin();
    $req = $db->query('SELECT id, username, DATE_FORMAT(registration_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_registration_date FROM members ORDER BY registration_date DESC  LIMIT 1 ');
    $newestUser = $req->fetch();
    return $newestUser;
}

function mostComUser(){

    $db = dbConnectAdmin();
    $req = $db->query('SELECT id, username, user_com_count, DATE_FORMAT(registration_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_registration_date FROM members ORDER BY user_com_count DESC, registration_date DESC  LIMIT 1 ');
    $mostComUser = $req->fetch();
    return $mostComUser;
}

function leastComUser(){

    $db = dbConnectAdmin();
    $req = $db->query('SELECT id, username, user_com_count, DATE_FORMAT(registration_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_registration_date FROM members ORDER BY user_com_count, registration_date LIMIT 1 ');
    $leastComUser = $req->fetch();
    return $leastComUser;
}



//me ressort le nombre max de com
// SELECT MAX(bestPost) 
// FROM (SELECT post_id,COUNT(*) bestPost 
// FROM comments 
// GROUP BY post_id) AS c;	


// SELECT MAX (mycount) 
// FROM (SELECT agent_code,COUNT(agent_code) mycount 
// FROM orders 
// GROUP BY agent_code);

// General function to connect to database
function dbConnectAdmin()
{
    $db = new PDO('mysql:host=localhost;dbname=p4blog;charset=utf8', 'root', '');

    return $db;
}