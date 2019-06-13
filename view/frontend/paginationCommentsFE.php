<!-- Display Pagination -->
<?php 
echo '<p >Page de commentaires : '; //FIXME : remove CSS from here
for($i=1; $i<=$nbOfCommentsPages; $i++)
{
     if($i==$currentCommentPage)
     {
         echo ' [ '.$i.' ] '; 
     }
     else
     {
          echo ' <a href="index.php?action=' . $_GET['action'] . '&id=' . $_GET['id']. '&page='.$i. '&sortBy=' . $_GET['sortBy'] .' #commentsAnchor">'.$i.'</a> ';
     }
}
echo '</p>';