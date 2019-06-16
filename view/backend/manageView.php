<?php $title = 'Editer les chapitres'; ?>
<?php ob_start(); ?> 
    <div class="postsBlock">
        <form action="index.php?action=updatePost&amp;id=<?= $displayedPostToEdit['id']?>" method="post">
        <div>
            <label for="chapter">Chapitre n°</label><br />
            <input type="text" id="chapter" name="chapter" value="<?= htmlspecialchars($displayedPostToEdit['chapter_nb']) ?>" required/>
        </div>
        <div>
            <label for="title">Titre</label><br />
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($displayedPostToEdit['title']) ?>" required/>
        </div>
        <div>
            <label for="postContent">Contenu</label><br />
            <textarea id="postContent" name="postContent"><?= nl2br($displayedPostToEdit['content']) ?></textarea>
        </div>
        <div>
            <p>Publié le <?= $displayedPostToEdit['mod_publish_date'] ?></p>
            <p>Edité le <?= $displayedPostToEdit['mod_edit_date'] ?></p>
            <input type="submit" onclick="return confirm('Sauvegarder les changements?')" value="Sauvegarder" />
        </div>
        </form>
    </div>
<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>


