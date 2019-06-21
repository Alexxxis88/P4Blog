<?php
class StatsManager extends Manager
{
    //gets the number of comments per post
    public function nbComPerPost($postId){
        $totalComPerPosts = $this->_db->prepare(
            'SELECT COUNT(*) AS nb_com, p.id
                FROM posts p 
                INNER JOIN comments c 
                ON c.postId = p.id
                WHERE p.id = ?
                ');
        $totalComPerPosts->execute(array($postId));
        return $totalComPerPosts;
    }
 
    
    public function statsPosts() 
    {
        $db = mysqli_connect('localhost','root','','p4blog'); // passer en PDO / objet
        $query = "SELECT * from posts ORDER BY id";
        $exec = mysqli_query($db,$query);
        return $exec;
    }
    public function ranking()
    {
        $req = $this->_db->query('SELECT id, chapterNb, title, content, DATE_FORMAT(publishDate, \'%d/%m/%Y à %Hh%imin%ss\') AS modPublishDate, DATE_FORMAT(editDate, \'%d/%m/%Y à %Hh%imin%ss\') AS modEditDate, commentCount FROM posts ORDER BY 
        CASE WHEN commentCount= (SELECT MAX(commentCount)FROM posts) THEN commentCount END DESC,
        CASE WHEN commentCount= (SELECT MIN(commentCount)FROM posts)  THEN commentCount END ASC  LIMIT 1 ');
        // $req->execute(array($position));
        $ranking = $req->fetch();
        return $ranking;
    }


    // public function ranking($position)
    // {

    //     $req = "SELECT * FROM posts ORDER BY";
    //     If ($position == "ASC") {
    //     $req .= "commentCount END ASC";
    //     } elseif ($position == "DESC") {
    //     $req .= "commentCount END DESC";
    //     }
    //     $this->_db->prepare($req);
        
    //     // $req = $this->_db->prepare(' SELECT * FROM posts ORDER BY 
    //     // CASE WHEN @position = "ASC" THEN commentCount END ASC ,
    //     // CASE WHEN @position = "DESC" THEN commentCount END DESC, LIMIT 1');
    //     $req->execute(array($position));
    //     $ranking = $req->fetch();
    //     return $ranking;
    // }


    
    //gets all the users to display them in stats view
    public function getUsersStats()
    {
        $usersStats = $this->_db->query('SELECT id, username, DATE_FORMAT(registrationDate, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_registrationDate, userComCount FROM members ORDER BY userComCount DESC LIMIT 0, 10 ');
        
        return $usersStats;
    }

    public function oldestUser()
    {
        $req = $this->_db->query('SELECT id, username, DATE_FORMAT(registrationDate, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_registrationDate FROM members ORDER BY registrationDate  LIMIT 1 ');
        $oldestUser = $req->fetch();
        return $oldestUser;
    }

    public function newestUser()
    {
        $req = $this->_db->query('SELECT id, username, DATE_FORMAT(registrationDate, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_registrationDate FROM members ORDER BY registrationDate DESC  LIMIT 1 ');
        $newestUser = $req->fetch();
        return $newestUser;
    }

    public function mostComUser()
    {
        $req = $this->_db->query('SELECT id, username, userComCount, DATE_FORMAT(registrationDate, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_registrationDate FROM members ORDER BY userComCount DESC, registrationDate DESC  LIMIT 1 ');
        $mostComUser = $req->fetch();
        return $mostComUser;
    }

    public function leastComUser()
    {
        $req = $this->_db->query('SELECT id, username, userComCount, DATE_FORMAT(registrationDate, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_registrationDate FROM members ORDER BY userComCount, registrationDate LIMIT 1 ');
        $leastComUser = $req->fetch();
        return $leastComUser;
    }
}