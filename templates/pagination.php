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
         if($currentView == "listPost")
         {
            echo ' <a href="index.php?page='.$i.'">'.$i.'</a> ';
         }

         elseif($currentView == "users")
         {
            echo ' <a href="index.php?action=' . $_GET['action'] . '&page='.$i.'&sortBy=' . $_GET['sortBy'] . '">'.$i.'</a> ';
         }

         elseif($currentView == "comments")
         {
            echo ' <a href="index.php?action=' . $_GET['action'] . '&id=' . $_GET['id']. '&page='.$i. '&sortBy=' . $_GET['sortBy'] . '#commentsAnchor">'.$i.'</a> ';
         }
          
     }
}
echo '</p>';


