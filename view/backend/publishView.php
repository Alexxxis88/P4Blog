<?php $title = 'Publier un nouveau chapitre'; ?>
<?php ob_start(); ?>

<div class="postsBlock">
    <form action="index.php?action=publishChapter" method="post">
        <div>
            <label for="title">Titre</label><br />
            <input type="text" id="title" name="title" placeholder="Titre du chapitre" required/>
        </div>
        <div>
            <label for="postContent">Contenu</label><br />
            <textarea id="postContent" name="postContent">Contenu du chapitre</textarea>
        </div>
        <div>
            <input type="submit" value="Publier"/>
        </div>
    </form>
</div> 
   
<?php $content = ob_get_clean(); ?>

<?php require('backendTemplate.php'); ?>
