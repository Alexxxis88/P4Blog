<?php
class PostManager extends Manager
{
//FRONTEND
    //gets the last X posts to display in listPostsView. X depends on $messagesPerPage
    public function getPosts()
    {
        
        $req = $this->_db->query('SELECT id, chapterNb, title, content, publishDate, editDate, commentCount FROM posts ORDER BY publishDate DESC LIMIT 0, 15');
        
            while ($datas = $req->fetch(PDO::FETCH_ASSOC))
            {           
                $posts[] = new Post($datas);
            }
            return $posts;

    }


    public function getPost($postId)
    {
        $req = $this->_db->prepare('SELECT id, chapterNb, title, content, publishDate, editDate, commentCount FROM posts WHERE id = ?');
        $req->execute(array($postId));
        $datas = $req->fetch();

        $post = new Post($datas);
        
        return $post;
    }



}