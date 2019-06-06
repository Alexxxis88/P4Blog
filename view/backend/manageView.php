<?php $title = 'Editer les chapitres'; ?>

<?php ob_start(); ?> 
    <div class="posts"><!-- edit class because div and <p> have same class name -->
        <form action="index.php?action=updatePost&amp;id=<?= $displayedPostToEdit['id']?>" method="post">
        <div>
            <label for="title">Titre</label><br />
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($displayedPostToEdit['title']) ?>" required/>
        </div>
        <div>
            <label for="postContent">Contenu</label><br />
            <textarea id="postContent" name="postContent" rows="15" cols="150" required><?= nl2br(htmlspecialchars($displayedPostToEdit['content'])) ?></textarea>
        </div>
        <div>
            <p>Publié le <?= $displayedPostToEdit['mod_publish_date'] ?></p>
            <p>Edité le <?= $displayedPostToEdit['mod_edit_date'] ?></p>
            <input type="submit" onclick="return confirm('Sauvegarder les changements?')" value="Sauvegarder" />
        </div>
        </form>
    
<?php $content = ob_get_clean(); ?>

<?php require('backendTemplate.php'); ?>