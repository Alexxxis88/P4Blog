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

 ['chapter_nb','Nb de commentaires'],
 <?php 
			
			 while($row = mysqli_fetch_array($exec)){
            
			 echo "['".$row['chapter_nb']."',".$row['comment_count']."],";
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
        <p><strong><?= $rankingBestPost['chapter_nb'] ?> <?= $rankingBestPost['title'] ?></strong> avec <strong><?= $rankingBestPost['comment_count'] ?></strong> commentaires </p>
        <p>Publié le <?= $rankingBestPost['mod_publish_date'] ?> </p>
    
        <h3>Chapitre le moins commenté</h3>
        <p><strong><?= $rankingWorstPost['chapter_nb'] ?> <?= $rankingWorstPost['title'] ?></strong> avec <strong><?= $rankingWorstPost['comment_count'] ?></strong> commentaires </p>
        <p>Publié le <?= $rankingWorstPost['mod_publish_date'] ?> </p>
    </div>
    <div class="container-fluid">
        <div id="columnchart12" style="width: 1000px; height: 500px;"></div>
    </div>
</div>

 <!-- FIXME : supprimer ci dessous ?  -->
<!-- <h3>Tous les Chapitre</h3>

< ? php 
// while ($datas = $allPostsStats->fetch()) //NOT WORKING
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
        <p><?= $bestContributor['username'] ?> avec <?= $bestContributor['user_com_count'] ?> commentaires publiés inscrit le <?= $bestContributor['mod_registration_date'] ?> </p></p>
        <h3>Utilisateurs le moins actif : </h3>
        <p><?= $worstContributor['username'] ?> avec <?= $worstContributor['user_com_count'] ?> commentaires publiés inscrit le <?= $worstContributor['mod_registration_date'] ?> </p>

        <h3>Utilisateurs le plus ancien : </h3>
        <p><?= $oldestUserRegistered['username'] ?> inscrit le <?= $oldestUserRegistered['mod_registration_date'] ?></p>
        <h3>Utilisateurs le plus récent : </h3>
        <p><?= $newestUserRegistered['username'] ?> inscrit le <?= $newestUserRegistered['mod_registration_date'] ?></p>
    </div>
    
    <div class="top10block">
        <h3>Top 10 des meilleurs contributeurs </h3>
        <?php 
        for ($i = 0; $i<10 ; $i++)
            { $datasUsers = $usersStats->fetch()     
        ?>
            <div class="topLines">
                <p><strong><?= $i+1 ?> . <?= $datasUsers['username'] ?> </strong>inscrit le <?= $datasUsers['mod_registration_date'] ?>. Nombre de commentaires postés : <strong> <?= $datasUsers['user_com_count'] ?></strong></p>
            </div>     
            <?php  
            }    
            ?> 
    </div>        
</div>

</body>
</html>

<?php $content = ob_get_clean(); ?>

<?php require('backendTemplate.php'); ?>