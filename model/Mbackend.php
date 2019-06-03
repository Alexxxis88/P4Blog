<?php
function getPostsAdmin()
{
    $db = dbConnectAdmin();
    $req = $db->query('SELECT id, title, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_publish_date FROM posts ORDER BY publish_date DESC LIMIT 0, 5');

    return $req;
}

function insertNewPost($title, $content)
{
    $db = dbConnectAdmin();
    $newPostDb = $db->prepare('INSERT INTO posts( title, content, publish_date) VALUES(?, ?, NOW())');
    $newPostDb->execute(array($title, $content));
}



// Nouvelle fonction qui nous permet d'éviter de répéter du code
function dbConnectAdmin()
{
    $db = new PDO('mysql:host=localhost;dbname=p4blog;charset=utf8', 'root', '');
    return $db;
}