<?php
class PostManager extends Manager
{
//FRONTEND
    //gets the last X posts to display in listPostsView. X depends on $messagesPerPage
    public function getPosts()
    {
        $req = $this->_db->query('SELECT id, chapterNb, title, content, DATE_FORMAT(publishDate, \'%d/%m/%Y à %Hh%imin%ss\') AS modPublishDate, DATE_FORMAT(editDate, \'%d/%m/%Y à %Hh%imin%ss\') AS modEditDate, commentCount FROM posts ORDER BY modPublishDate DESC LIMIT 0, 15');
        
        while ($datas = $req->fetch(PDO::FETCH_ASSOC))
        {           
            $posts[] = new Post($datas);
        }
        return $posts;
    }


    public function getPost($postId)
    {
        $req = $this->_db->prepare('SELECT id, chapterNb, title, content, DATE_FORMAT(publishDate, \'%d/%m/%Y à %Hh%imin%ss\') AS modPublishDate, DATE_FORMAT(editDate, \'%d/%m/%Y à %Hh%imin%ss\') AS modEditDate, commentCount FROM posts WHERE id = ?');
        $req->execute(array($postId));
        $datas = $req->fetch();
        $post = new Post($datas);
        
        return $post;
    }



//BACKEND
    public function insertNewPost($chapter, $title, $content)
    {
        $newPostDb = $this->_db->prepare('INSERT INTO posts( chapterNb, title, content, publishDate, editDate ) VALUES(?, ?, ?, NOW(), NOW())');
        $newPostDb->execute(array($chapter, $title, $content));
    }


    public function erasePost($postId) // est ce que ce $postId est le même que celui de postComment ? 
    {
        $postDelete = $this->_db->prepare('DELETE FROM posts WHERE id = ?');
        $postDelete->execute(array($postId));
    }


    public function editPost($chapter, $title, $content, $postId)
    {
        $editedPost = $this->_db->prepare('UPDATE posts SET chapterNb = ?, title = ?, content = ?, editDate = NOW() WHERE id = ?');
        $editedPost->execute(array($chapter, $title, $content, $postId));
    }

 


}