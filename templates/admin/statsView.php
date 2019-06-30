<?php
$title = 'Statistiques du site';
ob_start();
?>
    <!-- Posts Stats -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="statsTitles">Chapitres</h2>
            </div>
        </div>
        <div class="row chapterStatsRow">
            <div class="col-md-4" >
                <div class="bestChaptUser">
                    <h3>Chapitre le plus commenté </h3>
                    <p><em><?= $rankingBestPost['chapterNb'] ?>:</em> <strong> <?= $rankingBestPost['title'] ?></strong><br>
                    avec <strong><?= $rankingBestPost['commentCount'] ?></strong> commentaires.
                    <p>Publié le <?= $rankingBestPost['modPublishDate'] ?> </p>
                    <a href="index.php?action=post&id=<?= $rankingBestPost['id']?>&page=1&sortBy=5"><span class="far fa-eye"></span>  Voir le chapitre</a>
                </div>

                <div class="worstChaptUser">
                    <h3>Chapitre le moins commenté </h3>
                    <p><em><?= $rankingWorstPost['chapterNb'] ?>:</em> <strong> <?= $rankingWorstPost['title'] ?></strong><br>
                    avec <strong><?= $rankingWorstPost['commentCount'] ?></strong> commentaires.
                    <p>Publié le <?= $rankingWorstPost['modPublishDate'] ?> </p>
                    <a href="index.php?action=post&id=<?= $rankingWorstPost['id']?>&page=1&sortBy=5"><span class="far fa-eye"></span>  Voir le chapitre</a>
                </div>
            </div>
            <div class="col-md-8">
                <div id="columnchart12"></div>
                
            </div>
        </div>
    </div>
    <!-- User Stats -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="statsTitles">Utilisateurs</h2>
            </div>
        </div>
        <div class="row chapterStatsRow">
            <div class="col-md-4" >
                <div class="bestChaptUser">
                    <h3>Utilisateur le plus actif </h3>
                    <p><strong><?= $bestContributor['username'] ?></strong>
                    avec <strong><?= $bestContributor['userComCount'] ?></strong> commentaires publiés.<br>
                    Inscrit le <?= $bestContributor['mod_registrationDate'] ?> </p></p>
                </div>
                <div class="worstChaptUser">
                    <h3>Utilisateur le moins actif </h3>
                    <p><strong><?= $worstContributor['username'] ?></strong>
                    avec <strong><?= $worstContributor['userComCount'] ?></strong> commentaires publiés.<br>
                    Inscrit le <?= $worstContributor['mod_registrationDate'] ?> </p></p>
                </div>
            </div>
            <div class="col-md-offset-1 col-md-6 col-md-offset-1">
                <div class="top10block">
                    <h3>Top 10 des meilleurs contributeurs </h3>
                    <?php
                    $i = 1;
                    while ($datasUsers = $usersStats->fetch()) {
                        ?>
                        <div class="topLines">
                            <p><strong><?= $i++ ?> . <?= $datasUsers['username'] ?> </strong>inscrit le <?= $datasUsers['mod_registrationDate'] ?>. Commentaires : <strong> <?= $datasUsers['userComCount'] ?></strong></p>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
$content = ob_get_clean();
require('templates/base.php');
require('templates/admin/statsCharts.php');
?>
