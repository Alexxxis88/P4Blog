<?php
class PostManager extends Manager
{
    //FRONTEND
    //gets the last X posts to display in listPostsView. X depends on $messagesPerPage
    public function getPosts($firstEntry, $messagesPerPage)
    {
        $req = $this->_db->prepare('SELECT id, chapterNb, title, content, DATE_FORMAT(publishDate, \'%d/%m/%Y à %Hh%imin%ss\') AS modPublishDate, DATE_FORMAT(editDate, \'%d/%m/%Y à %Hh%imin%ss\') AS modEditDate, commentCount FROM posts ORDER BY modPublishDate DESC LIMIT ?,?');
        $req->bindValue(1, $firstEntry, PDO::PARAM_INT);
        $req->bindValue(2, $messagesPerPage, PDO::PARAM_INT);
        $req->execute();

        while ($datas = $req->fetch(PDO::FETCH_ASSOC)) {
            $posts[] = new Post($datas);
        }
        if (!empty($posts)) { //needed otherwise gives an error on the listPostView.php when no posts in DB
            return $posts;
        }
    }


    //Pagination
    public function getTotalPages()
    {
        $getTotalPages = $this->_db->query('SELECT COUNT(*) AS total_posts FROM posts');
        $returnTotalPages= $getTotalPages->fetch();
        
        return $returnTotalPages;
    }



    public function getPost($postId)
    {
        $req = $this->_db->prepare('SELECT id, chapterNb, title, content, DATE_FORMAT(publishDate, \'%d/%m/%Y à %Hh%imin%ss\') AS modPublishDate, DATE_FORMAT(editDate, \'%d/%m/%Y à %Hh%imin%ss\') AS modEditDate, commentCount FROM posts WHERE id = ?');
        $req->execute(array($postId));
        $datas = $req->fetch();
        
        if ($datas == false) { //needed here otherwise if a user puts a random pageID in url the Post construct receive a boolean false and a PHP error is displayed in FO
            throw new Exception('Ce chapitre n\'existe pas');
        } else {
            $post = new Post($datas);
            return $post;
        }
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
