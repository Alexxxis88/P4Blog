<!-- Display Pagination -->
<?php 
echo '<p align="center">Page : '; //FIXME : remove CSS from here
for($i=1; $i<=$nbOfPages; $i++)
{
     if($i==$currentPage)
     {
         echo ' [ '.$i.' ] '; 
     }
     else
     {
          echo ' <a href="index.php?action=' . $_GET['action'] . '&page='.$i.'&sortBy=' . $_GET['sortBy'] . '">'.$i.'</a> ';
     }
}
echo '</p>';
