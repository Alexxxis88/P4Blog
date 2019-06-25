<?php $title = 'Editer les chapitres'; ?>
<?php ob_start(); ?> 
    <div class="postsBlock">
        <form action="index.php?action=updatePost&amp;id=<?= $displayedPostToEdit->id()?>" method="post">
            <div>
                <label for="chapter">Chapitre n°</label><br />
                <input type="text" id="chapter" name="chapter" value="<?= htmlspecialchars($displayedPostToEdit->chapterNb()) ?>" required/>
            </div>
            <div>
                <label for="title">Titre</label><br />
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($displayedPostToEdit->title()) ?>" required/>
            </div><br/>
            <div>
                <label for="postContent">Contenu</label><br />
                <textarea id="postContent" name="postContent"><?= nl2br($displayedPostToEdit->content()) ?></textarea>
            </div>
            <div>
                <p>Publié le <?= $displayedPostToEdit->modPublishDate() ?><br/>
                   Edité le <?= $displayedPostToEdit->modEditDate() ?></p>
                <input type="submit" class="primary-button" onclick="return confirm('Sauvegarder les changements?')" value="Sauvegarder" />
            </div>
        </form>
    </div>
<?php $content = ob_get_clean(); ?>

<?php require('templates/base.php'); ?>