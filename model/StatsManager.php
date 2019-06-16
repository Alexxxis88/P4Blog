<?php
class StatsManager
{
    //gets the number of comments per post
    public function nbComPerPost($postId){
        $db = $this->dbConnect();
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

    public function statsPosts() 
    {
        $db = mysqli_connect('localhost','root','','p4blog');
        $query = "SELECT * from posts ORDER BY id";
        $exec = mysqli_query($db,$query);

        return $exec;
    }


    public function rankingBest(){

       $db = $this->dbConnect();
        $req = $db->query('SELECT id, chapter_nb, title, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_publish_date, comment_count FROM posts ORDER BY comment_count DESC, publish_date DESC  LIMIT 1 ');
        $rankingBest = $req->fetch();
        return $rankingBest;
    }

    public function rankingWorst(){

        $db = $this->dbConnect();
        $req = $db->query('SELECT id, chapter_nb, title, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_publish_date, comment_count FROM posts ORDER BY comment_count, publish_date LIMIT 1 ');
        $rankingWorst = $req->fetch();
        return $rankingWorst;
    }



    //gets all the users to display them in stats view
    public function getUsersStats()
    {
        $db = $this->dbConnect();
        $usersStats = $db->query('SELECT id, username, DATE_FORMAT(registration_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_registration_date, user_com_count FROM members ORDER BY user_com_count DESC LIMIT 0, 10 ');
        
        return $usersStats;
    }

    public function oldestUser(){

        $db = $this->dbConnect();
        $req = $db->query('SELECT id, username, DATE_FORMAT(registration_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_registration_date FROM members ORDER BY registration_date  LIMIT 1 ');
        $oldestUser = $req->fetch();
        return $oldestUser;
    }

    public function newestUser(){

        $db = $this->dbConnect();
        $req = $db->query('SELECT id, username, DATE_FORMAT(registration_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_registration_date FROM members ORDER BY registration_date DESC  LIMIT 1 ');
        $newestUser = $req->fetch();
        return $newestUser;
    }

    public function mostComUser(){

        $db = $this->dbConnect();
        $req = $db->query('SELECT id, username, user_com_count, DATE_FORMAT(registration_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_registration_date FROM members ORDER BY user_com_count DESC, registration_date DESC  LIMIT 1 ');
        $mostComUser = $req->fetch();
        return $mostComUser;
    }

    public function leastComUser(){

        $db = $this->dbConnect();
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

    
    // General public function to connect to database
    private function dbConnect()
    {
        $db = new PDO('mysql:host=localhost;dbname=p4blog;charset=utf8', 'root', '');
        return $db;
    }

}