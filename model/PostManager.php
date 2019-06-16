<?php
class PostManager
{

    //FRONTEND
            //gets the last X posts to display in listPostsView. X depends on $messagesPerPage
    public function getPosts($firstEntry, $messagesPerPage)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, chapter_nb, title, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_publish_date, DATE_FORMAT(edit_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_edit_date FROM posts ORDER BY publish_date DESC LIMIT ?, ?');
        $req->bindValue(1, $firstEntry, PDO::PARAM_INT);
        $req->bindValue(2, $messagesPerPage, PDO::PARAM_INT);
        $req->execute();
        
        return $req;
    }


        //Pagination
    public function getTotalPages(){
        $db = $this->dbConnect();
        $getTotalPages = $db->query('SELECT COUNT(*) AS total_posts FROM posts');
        $returnTotalPages= $getTotalPages->fetch();

        return $returnTotalPages;
    }


    //gets last 3 posts to display in postView aside. 
    public function getLastPosts()
    {
        $db = $this->dbConnect();
        $lastPost = $db->query('SELECT id, chapter_nb, title, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_publish_date, DATE_FORMAT(edit_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_edit_date FROM posts ORDER BY publish_date DESC LIMIT 0, 3');

        return $lastPost;
    }


    public function getPost($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, chapter_nb, title, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_publish_date, DATE_FORMAT(edit_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_edit_date FROM posts WHERE id = ?');
        $req->execute(array($postId));
        $post = $req->fetch();

        return $post;
    }

    public function erasePost($postId) // est ce que ce $postId est le même que celui de postComment ? 
    {
        $db = $this->dbConnect();
        $postDelete = $db->prepare('DELETE FROM posts WHERE id = ?');
        $postDelete->execute(array($postId));
    }


    //BACKEND

    //gets the last X posts to display in adminView. X depends on $messagesPerPage
    public function getPostsAdmin($firstEntry, $messagesPerPage)
    {
       $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, chapter_nb, title, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_publish_date, DATE_FORMAT(edit_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_edit_date FROM posts ORDER BY publish_date DESC LIMIT ?, ?');
        $req->bindValue(1, $firstEntry, PDO::PARAM_INT);
        $req->bindValue(2, $messagesPerPage, PDO::PARAM_INT);
        $req->execute();
        return $req;
    }

    //Pagination
    public function getTotalPagesAdmin(){
        $db = $this->dbConnect();
        $getTotalPagesAdmin = $db->query('SELECT COUNT(*) AS total_posts FROM posts');
        $returnTotalPagesAdmin= $getTotalPagesAdmin->fetch();

        return $returnTotalPagesAdmin;
    }

    public function insertNewPost($chapter, $title, $content)
    {
        $db = $this->dbConnect();
        $newPostDb = $db->prepare('INSERT INTO posts( chapter_nb, title, content, publish_date, edit_date) VALUES(?, ?, ?, NOW(), NOW())');
        $newPostDb->execute(array($chapter, $title, $content));
    }

    public function getPostToEdit($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, chapter_nb, title, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_publish_date, DATE_FORMAT(edit_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_edit_date FROM posts WHERE id = ?');
        $req->execute(array($postId));
        $postToEdit = $req->fetch();

        return $postToEdit;
    }

    public function editPost($chapter, $title, $content, $postId)
    {
        $db = $this->dbConnect();
        $editedPost = $db->prepare('UPDATE posts SET chapter_nb = ?, title = ?, content = ?, edit_date = NOW() WHERE id = ?');
        $editedPost->execute(array($chapter, $title, $content, $postId));

    }



        // General function to connect to database
    private function dbConnect()
    {
        $db = new PDO('mysql:host=localhost;dbname=p4blog;charset=utf8', 'root', '');
        return $db;
    }




}