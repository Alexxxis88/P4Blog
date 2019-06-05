<?php $title = 'Page d\'administration'; ?>

<?php ob_start(); ?>

    
<h2>Publier un nouveau chapitre</h2>

    <form action="index.php?action=publishChapter" method="post">
    <div>
        <label for="title">Titre</label><br />
        <input type="text" id="title" name="title" placeholder="Titre du chapitre" required/>
    </div>
    <div>
        <label for="postContent">Contenu</label><br />
        <textarea id="postContent" name="postContent" placeholder="Contenu du chapitre" required></textarea>
    </div>
    <div>
        <input type="submit" />
    </div>
</form>
  
   
<?php $content = ob_get_clean(); ?>

<?php require('backendTemplate.php'); ?>
