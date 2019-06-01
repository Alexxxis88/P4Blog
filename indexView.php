<!DOCTYPE html> 
<html> 
	<head> 
		<title>Billet simple pour l'Alaska</title> 
		<meta charset="utf-8" /> 
        <link rel="stylesheet" href="css/style.css" />
	</head> 
	<body> 
        <section id="header">
                <h1>Billet simple pour l'Alaska</h1>
                <div class="adminFields">
                    <form method="post" action ="admin.php">
                        <input type="text" name="log" placeholder="votre pseudo" required />
                        <input type="password" name="password" placeholder="votre password" required />
                        <input type="submit" name="login" value ="Connexion" /> 
                    </form>
                </div>
            </div>
            <p class="pagination">Page: PAGINATION</p>
        </section>

        <?php
         while($datas = $posts->fetch())
        {
        $id = (int) $datas['id']; 
        ?>
        
            <div class="posts">
                <h2><?= htmlspecialchars($datas['title']) ?></h2>
                <p>Publié le <?= $datas['mod_publish_date'] ?></p>
                    
                <p class="posts">
                    <?= nl2br(htmlspecialchars($datas['content'])) ?>
                        <button>Lire la suite</button><br/>
                    <a href="comments.php?post=<?=$id?>&title=<?=$datas['title']?>">Commentaires</a>
                </p>
                <button class="adminBtns">Modifier</button>
                <button class="adminBtns">Supprimer</button>
            </div>
        <?php
        }  
        $posts->closeCursor();
        ?>     

        <section id="footer">
            <p>Page: PAGINATION</p>
            <a href="contact.php">Contact</a>
            <a href="about.php">A propos de l'auteur</a>
            <button><a href="#header">back to top</a></button>
        </section>  
    </body>
</html>