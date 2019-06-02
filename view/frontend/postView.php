<?php $title = $post['title'] ; ?>

<?php ob_start(); ?>
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
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
