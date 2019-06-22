
<?php $title = 'Statistiques du site'; 
ob_start(); ?>

<h2>Chapitres</h2>
<div class="chapterStatsContainer">
    <div class=chapterStats>
        <h3>Chapitre le plus commenté </h3>
        <p><strong><?= $rankingBestPost['chapterNb'] ?> <?= $rankingBestPost['title'] ?></strong> avec <strong><?= $rankingBestPost['commentCount'] ?></strong> commentaires </p>
        <p>Publié le <?= $rankingBestPost['modPublishDate'] ?> </p>
    
        <h3>Chapitre le moins commenté</h3>
        <p><strong><?= $rankingWorstPost['chapterNb'] ?> <?= $rankingWorstPost['title'] ?></strong> avec <strong><?= $rankingWorstPost['commentCount'] ?></strong> commentaires </p>
        <p>Publié le <?= $rankingWorstPost['modPublishDate'] ?> </p>
    </div>
    <div class="container-fluid">
        <div id="columnchart12" style="width: 1000px; height: 500px;"></div>
    </div>
</div>

<h2>Utilisateurs</h2>
<div class="userStatsContainer">
<div class="usersBlock">
        <h3>Utilisateurs le plus actif : </h3>
        <p><?= $bestContributor['username'] ?> avec <?= $bestContributor['userComCount'] ?> commentaires publiés inscrit le <?= $bestContributor['mod_registrationDate'] ?> </p></p>
        <h3>Utilisateurs le moins actif : </h3>
        <p><?= $worstContributor['username'] ?> avec <?= $worstContributor['userComCount'] ?> commentaires publiés inscrit le <?= $worstContributor['mod_registrationDate'] ?></p>

        <h3>Utilisateurs le plus ancien : </h3>
        <p><?= $oldestUserRegistered['username'] ?> inscrit le <?= $oldestUserRegistered['mod_registrationDate'] ?></p>
        <h3>Utilisateurs le plus récent : </h3>
        <p><?= $newestUserRegistered['username'] ?> inscrit le <?= $newestUserRegistered['mod_registrationDate'] ?></p>
    </div>
    
    <div class="top10block">
        <h3>Top 10 des meilleurs contributeurs </h3>
        <?php 
        $i = 1;
        while ($datasUsers = $usersStats->fetch())
        {  
        ?>
            <div class="topLines">
                <p><strong><?= $i++ ?> . <?= $datasUsers['username'] ?> </strong>inscrit le <?= $datasUsers['mod_registrationDate'] ?>. Nombre de commentaires postés : <strong> <?= $datasUsers['userComCount'] ?></strong></p>
            </div>     
        <?php  
        }    
        ?> 
    </div>           
</div>


<?php $content = ob_get_clean(); ?>

<?php require('templates/base.php'); ?>
