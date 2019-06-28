
<script type="text/javascript">
 google.load("visualization", "1", {packages:["corechart"]});
 google.setOnLoadCallback(drawChart);
 function drawChart() {
 var data = google.visualization.arrayToDataTable([
 ['chapterNb','Nb de commentaires'],
 <?php
            
             while ($row = mysqli_fetch_array($exec)) {
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