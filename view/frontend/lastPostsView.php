<div class="lastPosts">
    <h3>Les derniers chapitres publiés</h3>
<?php
while($datas = $lastPosts->fetch())
{
$id = (int) $datas['id']; 
?>
        <h4><?= htmlspecialchars($datas['title']) ?></h4>
        
        <?php //FIXME duplicate content (except $data instead of $post) with PostsView. Worth factoring into a function ? 
        if($datas['mod_publish_date'] ==  $datas['mod_edit_date'] )
        {
           echo '<p>Publié le '. $datas['mod_publish_date'] . '</p>';
        }
        else
        {
            echo '<p>Edité le '. $datas['mod_edit_date'] . '</p>';
        }
         
    ?>    
            <p class="lastPostsP"><!-- edit class because div and <p> have same class name -->
                <?= substr($datas['content'], 0, 200) . "..." ?><br/>
                <button class="regularBtns"><a href="index.php?action=post&id=<?=$id?>">Lire la suite</a></button>      
            </p>
            
<?php
}  
$lastPosts->closeCursor();
?>
</div>     
