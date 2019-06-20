<?php $title = 'Publier un nouveau chapitre'; ?>
<?php ob_start(); ?>

<div class="postsBlock">
    <form action="index.php?action=publishChapter" method="post">
        <div>
            <label for="chapter">Chapitre n°</label><br />
            <input type="text" id="chapter" name="chapter" placeholder="Chapitre n°" required/>
        </div>
        <div>
        <div>
            <label for="title">Titre</label><br />
            <input type="text" id="title" name="title" placeholder="Titre du chapitre" required/>
        </div>
        <div>
            <label for="postContent">Contenu</label><br />
            <textarea id="postContent" name="postContent">Contenu du chapitre</textarea>
        </div>
        <div>
            <input type="submit" onclick="return confirm('Publier le chapitre?')" value="Publier"/>
        </div>
    </form>
</div> 
   
<?php $content = ob_get_clean(); ?>

<?php require('templates/base.php'); ?>