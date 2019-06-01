<?php   
function getPosts()
{
    try
    {
        $db = new PDO('mysql:host=localhost;dbname=p4blog;charset=utf8', 'root', '');
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    } 

    //Getting the posts
    $req = $db->query('SELECT id, title, content, DATE_FORMAT(publish_date, \'%d/%m/%Y\') AS mod_publish_date FROM posts ORDER BY id LIMIT 0, 4 ');

    return $req;
}    
?>




            
            
              
            