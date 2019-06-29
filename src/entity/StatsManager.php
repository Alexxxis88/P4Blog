<?php
class StatsManager extends Manager
{
    public function nbComPerPost($postId)
    {
        $totalComPerPosts = $this->_db->prepare(
            'SELECT COUNT(*) AS nb_com, p.id
                FROM posts p
                INNER JOIN comments c
                ON c.postId = p.id
                WHERE p.id = ?'
        );
        $totalComPerPosts->execute(array($postId));
        return $totalComPerPosts;
    }

    public function statsPosts()
    {
        $db = mysqli_connect('localhost', 'root', '', 'p4blog');
        $query = "SELECT * from posts ORDER BY id";
        $exec = mysqli_query($db, $query);
        return $exec;
    }

    public function rankingBest()
    {
        $req = $this->_db->query('SELECT id, chapterNb, title, content, DATE_FORMAT(publishDate, \'%d/%m/%Y à %Hh%imin%ss\') AS modPublishDate, commentCount FROM posts ORDER BY commentCount DESC, publishDate DESC LIMIT 1 ');
        $rankingBest = $req->fetch();
        return $rankingBest;
    }

    public function rankingWorst()
    {
        $req = $this->_db->query('SELECT id, chapterNb, title, content, DATE_FORMAT(publishDate, \'%d/%m/%Y à %Hh%imin%ss\') AS modPublishDate, commentCount FROM posts ORDER BY commentCount , publishDate LIMIT 1 ');
        $rankingWorst = $req->fetch();
        return $rankingWorst;
    }

    public function getUsersStats()
    {
        $usersStats = $this->_db->query('SELECT id, username, DATE_FORMAT(registrationDate, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_registrationDate,userComCount FROM members ORDER BY userComCount DESC LIMIT 0, 10 ');
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
