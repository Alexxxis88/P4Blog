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
            <p class="pagination">Page: PAGINATION</p>
        
        </section>
        <p><a href="index.php">Retour à la page d'accueil</a></p>
            <div class="posts">
                <h2><?= htmlspecialchars($post['title']) ?></h2>
                <p>Publié le <?= $post['mod_publish_date'] ?></p>
                    
                <p class="posts">
                    <?= nl2br(htmlspecialchars($post['content'])) ?>
                        <button>Lire la suite</button><br/>
                </p>
                <button class="adminBtns">Modifier</button>
                <button class="adminBtns">Supprimer</button>
            </div>

            <h2>Commentaires</h2>

        <?php
        while ($comment = $comments->fetch())
        {
        ?>
            <p><strong><?= htmlspecialchars($comment['author']) ?></strong> le <?= $comment['mod_comment_date'] ?></p>
            <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
        <?php
        }
        ?>

             

        <section id="footer">
            <p>Page: PAGINATION</p>
            <a href="contact.php">Contact</a>
            <a href="about.php">A propos de l'auteur</a>
            <button><a href="#header">back to top</a></button>
        </section>  
    </body>
</html>