<!DOCTYPE HTML>
<html>
<head>
 <meta charset="utf-8">
 <?php $title = 'Statistiques du site'; ?>
 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <script type="text/javascript">
 google.load("visualization", "1", {packages:["corechart"]});
 google.setOnLoadCallback(drawChart);
 function drawChart() {
 var data = google.visualization.arrayToDataTable([
 ['chapterNb','Nb de commentaires'],
 <?php 
			
			 while($row = mysqli_fetch_array($exec)){
            
			 echo "['".$row['chapterNb']."',".$row['commentCount']."],";
			 }
			 ?> 
 
 ]);
 var options = {
 title: 'Nombre de commentaires par chapitre',
 
 BarChart: {
            color: 'black',
          },
          legend: 'none'
 };
 var chart = new google.visualization.ColumnChart(document.getElementById("columnchart12"));
 chart.draw(data,options);
 }
	
    </script>

</head>




<?php ob_start(); ?>
 
<body>
 
 
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

 <!-- FIXME voir allPostsStats(C et M, a virer aussi) : supprimer ci dessous ?  -->
<!-- <h3>Tous les Chapitre</h3>
< ? php 
// while ($datas = $allPostsStats->fetch())
    // {       
 ? >
<div class="reportedComments">
 <p>< ?= $datas['title'] ?></p><p> Nombre de commentaires < ?= $datas['comment_count'] ?></p>
</div>
 < ?php  
}    
  ?> -->



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

</body>
</html>

<?php $content = ob_get_clean(); ?>

<?php require('templates/base.php'); ?>