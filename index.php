<?php
session_start();
require('controller/Cfrontend.php');
require('controller/Cbackend.php');

try {
    if (isset($_GET['action'])) {
    //Frontend    
        if ($_GET['action'] == 'listPosts' OR $_GET['action'] == '') {
            listPosts();
        }

        elseif ($_GET['action'] == 'post') 
        {
            if (isset($_GET['id']) && $_GET['id'] > 0) 
            {

                if(!isset($_GET['page']) OR !isset($_GET['id']) OR !isset($_GET['sortBy']) OR $_GET['page']<1 OR $_GET['id']<1 OR $_GET['sortBy']<1)
                    { 
                        throw new Exception('Il manque le numéro de page, du billet ou la classement des commentaires');
                    }
                    else{
                        post();
                    }

                    //Add a comment confirmation message. FIXME create a View for this ? but i don't want it displayed in a VIEW i want it displayed in the front office. Use template.php with a toggle display : none /block and create a modal box ? Z index etc jquerry 
                    if (isset($_GET['success']) AND $_GET['success'] == 4) 
                    {
                    ?>
                    <div class="commentConfirmation"> <!--FIXME : changer nom de la classe, un truc générique ? + update CSS  -->
                        <p>Merci pour votre commentaire.</p>
                        <p>Il sera affiché après validation d'un modérateur.</p>
                    </div>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
                    <script type="text/javascript" >
                    let delayConfirmationMsg = setTimeout(hideThanks, 1500);
                    function hideThanks(){
                    $(".commentConfirmation").fadeOut();
                    }
                    </script>
                    <?php    
                    }
                    
                    //Add a update comment confirmation message. FIXME create a View for this ? but i don't want it displayed in a VIEW i want it displayed in the front office. Use template.php with a toggle display : none /block and create a modal box ? Z index etc jquerry 
                    if (isset($_GET['success']) AND $_GET['success'] == 5) 
                    {
                    ?>
                    <div class="updateComConfirmation"> <!--FIXME : changer nom de la classe, un truc générique ? + update CSS  -->
                        <p>Votre commentaire a bien été modifié.</p>
                    </div>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
                    <script type="text/javascript" >
                    let delayConfirmationMsg = setTimeout(hideThanks, 1500);
                    function hideThanks(){
                    $(".updateComConfirmation").fadeOut();
                    }
                    </script>
                    <?php    
                    }
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }

        elseif ($_GET['action'] == 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                    addComment($_GET['id'], $_POST['author'], $_POST['comment'], $_GET['id']);
                }
                else {
                    throw new Exception('Tous les champs ne sont pas remplis !');
                }
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }

        elseif ($_GET['action'] == 'deleteComment') {
            if (isset($_GET['commentId']) && $_GET['commentId'] > 0) {
                deleteComment($_GET['commentId'], $_GET['id']);
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }


        elseif ($_GET['action'] == 'reportComment') {
            if (isset($_GET['commentId']) && $_GET['commentId'] > 0) {

                //checks in the controler if the member already reported the same comment
                checkIfReported();

                if(isset($_COOKIE['id'])){
                    $cookieOrSessionID = $_COOKIE['id'];
                    }
                    elseif(isset($_SESSION['id'])){
                        $cookieOrSessionID = $_SESSION['id'];
                    }

                reportCommentsCheck($cookieOrSessionID, $_GET['commentId']); //the reported comment is registered into reported_comments DB
                reportComments($_GET['commentId']);    //the reported comment is actually reported in comments DB and BE
            }
            else {
                throw new Exception('Aucun identifiant de commentaire envoyé');
            }
        }

        //user can edit his own comment
        elseif ($_GET['action'] == 'updateComment') {
            if (isset($_GET['commentId']) && $_GET['commentId'] > 0) {
                updateComment($_POST['comment'],$_GET['commentId']);
            }
            else {
                throw new Exception('Aucun identifiant de commentaire envoyé');
            }
        }
        



        elseif ($_GET['action'] == 'deletePost') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $postId = $_GET['id'];
                deleteAllComments($postId); //delete all the comments related to the post we're deleting with deletePost()
                deletePost($postId);
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }
        
    //SING IN, LOG IN, LOG OUT





        //LOG IN
        elseif ($_GET['action'] == 'logInCheck') {
            if(isset($_POST['username']) && isset($_POST['pass'])){
                checkLog($_POST['username']);
                
                //if there is a session open, displays a message        
                if (isset($_SESSION['id']) AND isset($_SESSION['username']))
                {
                    require('view/frontend/menu.php');

                }  
            }
            else{
                throw new Exception('Vérifiez vos identifiants de connexion');   
            }
        }

        //LOG OUT
        elseif ($_GET['action'] == 'logOutCheck') {
            if(isset($_SESSION['id']) AND isset($_SESSION['username'])){
                

                // FIXME : factoriser dans une fonction unique dans le controleur killSession() ? 
                // Delete session variables
                $_SESSION = array();
                session_destroy();

                // Delete autologing cookies
                setcookie('id', '', time() + 365*24*3600, null, null, false, true);
                setcookie('login', '', time() + 365*24*3600, null, null, false, true);
                setcookie('hash_pass', '', time() + 365*24*3600, null, null, false, true);
                
                header('Location: index.php');
                exit;
            }
            else{
                throw new Exception('Vous êtes déja déconnecté');   
            }
        }


        

        //UPDATE PASSWORD
        elseif ($_GET['action'] == 'changePasswordView') {
            if( (isset($_COOKIE['login']) AND $_COOKIE['login'] != '') OR  (isset($_SESSION['username']) AND $_SESSION['username'] != ''))
            {
                displaychangePasswordView();
            }     
            else {
                throw new Exception('Vous devez être connecté pour accéder à cette page');
            }    
        }



        elseif ($_GET['action'] == 'UpdatePass') 
        {
            if( (isset($_COOKIE['login']) AND $_COOKIE['login'] != '') OR  (isset($_SESSION['username']) AND $_SESSION['username'] != ''))
            {
                //to avoid problems with inputs
                $_POST['currentPass'] = htmlspecialchars($_POST['currentPass']);
                $_POST['newPass'] = htmlspecialchars($_POST['newPass']);
               
                $accentedCharactersNewPass = "àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ";

                if(currentPassInDB($_POST['currentPass']) == false)
                {
                    if(preg_match("#^[a-z".$accentedCharactersNewPass ."0-9._!?-]{8,20}$#i", $_POST['newPass']) )
                    {
                        //if the password is Correct check if current and new pass are the same
                        if($_POST['currentPass'] != $_POST['newPass'])
                        {
                            //hash password (security feature)
                            $_POST['newPass'] = password_hash($_POST['newPass'], PASSWORD_DEFAULT);
                
                            UpdatePassWord($_POST['newPass'], $_POST['id']);

                            // FIXME : factoriser dans une fonction unique dans le controleur killSession() ? 
                            // Delete session variables
                            $_SESSION = array();
                            session_destroy();

                            // Delete autologing cookies
                            setcookie('id', '', time() + 365*24*3600, null, null, false, true);
                            setcookie('login', '', time() + 365*24*3600, null, null, false, true);
                            setcookie('hash_pass', '', time() + 365*24*3600, null, null, false, true);

                            //success2 needed to display the confirmation message
                            header('Location: index.php?success=2#header');
                            exit;
                        }
                        else
                        {
                            throw new Exception('Votre nouveau password est le même que l\'actuel');
                        }
                    }
                    else
                    {
                        throw new Exception('Votre nouveau password n\'est pas conforme');
                    }                    
                }
                else {
                    throw new Exception('Votre password actuel n\'est pas le bon');
                } 
            }     
            else {
                throw new Exception('Vous devez être connecté pour accéder à cette page');
            }

            
        }





        //SIGN IN
        elseif ($_GET['action'] == 'singIn') {
            
            displaySingInView();
        }

        elseif ($_GET['action'] == 'addNewMember') {
 
            //testing if all fields a filled
            if (isset($_POST['username']) && isset($_POST['pass']) && isset($_POST['passCheck']) && isset($_POST['email'])) {

                //to avoid problems with inputs
                $_POST['username'] = htmlspecialchars($_POST['username']);
                $_POST['pass'] = htmlspecialchars($_POST['pass']);
                $_POST['passCheck'] = htmlspecialchars($_POST['passCheck']);
                $_POST['email'] = htmlspecialchars($_POST['email']);

                $accentedCharacters = "àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ";
                
                //testing if username only has authorised caracters and length  
                if (preg_match("#^[a-z".$accentedCharacters ."0-9]{4,20}$#i",$_POST['username']))
                {
                    //testing if passwords is conform
                    if (preg_match("#^[a-z".$accentedCharacters ."0-9._!?-]{8,20}$#i",$_POST['pass']) ){

                        //testing if both passwords match
                        if($_POST['pass'] == $_POST['passCheck']){
                            
                            //testing if email is conform
                            if( preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#i", $_POST['email']))
                            {
                                //hash password (security feature)
                                $_POST['pass'] = password_hash($_POST['pass'], PASSWORD_DEFAULT);


                                //check if username of email are already taken
                                if(checkUsernameAvailability($_POST['username']) == false){
                                    if(checkEmailAvailability($_POST['email']) == false){
                                        addNewMember($_POST['username'], $_POST['pass'], $_POST['email']);
                                    }
                                    else
                                     {
                                         throw new Exception('Cette adresse email n\'est pas disponible'); 
                                     }
                                }
                                else
                                 {
                                     throw new Exception('Ce pseudo n\'est pas disponible'); 
                                 }
   
                            }
                            else{
                                throw new Exception('L\'adresse email n\'est pas conforme'); 
                            } 
                        }
                        else{
                            throw new Exception('Les deux mots de passe ne sont pas identiques');   
                        }
                    }
                    else{
                        throw new Exception('Le mot de passe n\'est pas conforme.');
                    }    
                }
                else{
                    throw new Exception('Le pseudo n\'est pas conforme.');
                }
            }
            else {
                throw new Exception('Il manque des informations.');
            }       
        }

        elseif ($_GET['action'] == 'about') {
            displayAboutView();
        }
        
        //Contact page
        elseif ($_GET['action'] == 'contact') {
            displayContactView();
        }









        elseif ($_GET['action'] == 'sendMessage') {
   
            //testing if all fields a filled
            if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['contactEmail']) && isset($_POST['topic']) && isset($_POST['messageContent'])) 
            {
                //to avoid problems with inputs
                $_POST['firstName'] = htmlspecialchars($_POST['firstName']);
                $_POST['lastName'] = htmlspecialchars($_POST['lastName']);
                $_POST['contactEmail'] = htmlspecialchars($_POST['contactEmail']);
                $_POST['topic'] = htmlspecialchars($_POST['topic']);
                $_POST['messageContent'] = htmlspecialchars($_POST['messageContent']);


                $accentedCharacters = "àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ";
                
                //testing if firstName only has authorised caracters   
                if (preg_match("#^[a-z". $accentedCharacters ."]+[' -]?[a-z". $accentedCharacters ."]+$#i",$_POST['firstName']))
                {
                    //testing if lastName only has authorised caracters
                    if (preg_match("#^[a-z". $accentedCharacters ."]+[' -]?[a-z". $accentedCharacters ."]+$#i",$_POST['lastName']))
                    {
                        //testing if email is conform
                        if( preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#i", $_POST['contactEmail']))
                        { 
                            //testing if topic is conform
                            if (preg_match("#^[a-z". $accentedCharacters ."(' \-)*]+[a-z". $accentedCharacters ."]+$#i",$_POST['topic']))
                            {
                                sendMessage($_POST['firstName'], $_POST['lastName'], $_POST['contactEmail'], $_POST['topic'],  $_POST['messageContent']);
                            }
                            else{
                                throw new Exception('L\'intitulé n\'est pas conforme'); 
                            } 
                        }
                        else{
                            throw new Exception('L\'adresse email n\'est pas conforme');   
                        }
                    }
                    else{
                        throw new Exception('Le nom n\'est pas conforme.');
                    }    
                }
                else{
                    throw new Exception('Le prénom n\'est pas conforme.');
                }
            }
            else {
                throw new Exception('Il manque des informations.');
            }      
        } 














        //Backend
        elseif ($_GET['action'] == 'listPostsAdmin') {
            listPostsAdmin();
            nbOfReportedComments(); //NOT WORKING : display number of comments working

            
        }



        elseif ($_GET['action'] == 'manageUsers') {
            if(!isset($_GET['page']) OR !isset($_GET['sortBy']) OR $_GET['page']<1 OR $_GET['sortBy']<1)
            { 
                throw new Exception('Il manque le numéro de page ou le classement des utilisateurs');
            }
            else{
                listAllUsers();
            }
            
        }


       



        //to delete all selected users
        elseif ($_GET['action'] == 'manageAllSelectedUsers') { //NOT WORKING
            if(isset($_POST['deleteSelectedUsers'])){
                deleteAllSelectedUsers($_POST['selectUsers']);  
            }
            else{
                throw new Exception('Il y a une erreur');
            }  
        }


         //to update role
         elseif ($_GET['action'] == 'updateRole') { //NOT WORKING
            if(isset($_GET['role'])){
                updateUserRole($_GET['role'], $_GET['userID']);  
            }
            else{
                throw new Exception('Il y a une erreur');
            }  
        }





        //rajouter une fonction qui va etre liée a un bouton et qui va update le role de l'user


        elseif ($_GET['action'] == 'deleteUser') { //WORKING
            if (isset($_GET['userID']) && $_GET['userID'] > 0) {
                deleteUser($_GET['userID']);
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }


        





        elseif ($_GET['action'] == 'manageComments') {
            listAllComments();
            // listResportedComments(); FIXME : a supprimer quand manage comments marchera
        }
        
        //to approve or delete all reported comments
        elseif ($_GET['action'] == 'manageAllSelectedComments') {
            if(isset($_POST['deleteSelectedComments'])){
                deleteAllSelectedComments($_POST['selectComments']); // j'essaie de récupérer le tableau de commentsView.php 
            }
            elseif(isset($_POST['approveSelectedComments'])){
                approveAllSelectedComments($_POST['selectComments']);

            }
            else{
                throw new Exception('Il y a une erreur');
            }  
        }

        //to publish or delete all new comments
        elseif ($_GET['action'] == 'publishAllSelectedComments') {
            if(isset($_POST['deleteSelectedComments'])){
                deleteAllSelectedComments($_POST['selectPublishComments']); // j'essaie de récupérer le tableau de commentsView.php 
            }
            elseif(isset($_POST['publishSelectedComments'])){
                // publishAllSelectedComments($_POST['selectPublishComments']); FIXME a supprimer si ça fonctionne bien avec approveAllSelectedComments
                approveAllSelectedComments($_POST['selectPublishComments']);
            }
            else{
                throw new Exception('Il y a une erreur');
            }  
        }






        

        
        elseif ($_GET['action'] == 'approveComment') {
            approveComments($_GET['commentId']);
        }
        elseif ($_GET['action'] == 'publishChapter') {
            newPost($_POST['title'], $_POST['postContent']);
        }

        elseif ($_GET['action'] == 'displayPublishView') {
            displayPublishView();
        }

        elseif ($_GET['action'] == 'manageView') {
            displayPostToEdit($_GET['id']);
            
        }
        
        elseif ($_GET['action'] == 'updatePost') {
            updatePost($_POST['title'], $_POST['postContent'], $_GET['id']);
        }

        elseif ($_GET['action'] == 'displayStatsView') {

         
            displayStatsView();
        }

    }


    //Default behavior
    else {
        listPosts();

        //Sing in confirmation message. FIXME create a View for this ? but i don't want it displayed in a VIEW i want it displayed in the front office. Use template.php with a toggle display : none /block and create a modal box ? Z index etc jquerry 
        if (isset($_GET['success']) AND $_GET['success'] == 1) 
            {
            ?>
            <div class="signInConfirmation"> <!--FIXME : changer nom de la classe, un truc générique ? + update CSS  -->
                <p>Votre inscription est validée!</p>
                <p>Veuillez vous connecter avec votre identifiant et votre mot de passe.</p>
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
            <script type="text/javascript" >
            let delayConfirmationMsg = setTimeout(hideThanks, 1500);
            function hideThanks(){
        $(".signInConfirmation").fadeOut();
        }
            </script>
            <?php    
            }
        
        //Update pass confirmation message. FIXME create a View for this ? but i don't want it displayed in a VIEW i want it displayed in the front office. Use template.php with a toggle display : none /block and create a modal box ? Z index etc jquerry 
        if (isset($_GET['success']) AND $_GET['success'] == 2) 
            {
            ?>
            <div class="signInConfirmation"> <!--FIXME : changer nom de la classe, un truc générique ? + update CSS  -->
                <p>Votre mot de pass à bien été mis à jour!</p>
                <p>Veuillez vous reconnecter avec votre identifiant et votre nouveau mot de passe.</p>
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
            <script type="text/javascript" >
            let delayConfirmationMsg = setTimeout(hideThanks, 1500);
            function hideThanks(){
        $(".signInConfirmation").fadeOut();
        }
            </script>
            <?php    
            }


        //Message sent confirmation message. FIXME create a View for this ? but i don't want it displayed in a VIEW i want it displayed in the front office. Use template.php with a toggle display : none /block and create a modal box ? Z index etc jquerry 
        if (isset($_GET['success']) AND $_GET['success'] == 3) 
        {
        ?>
        <div class="signInConfirmation"> <!--FIXME : changer nom de la classe, un truc générique ? + update CSS  -->
            <p>Votre message à bien été envoyé.</p>
            <p>Jean Forteroche vous répondra rapidement !</p>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script type="text/javascript" >
        let delayConfirmationMsg = setTimeout(hideThanks, 1500);
        function hideThanks(){
    $(".signInConfirmation").fadeOut();
    }
        </script>
        <?php    
        }
    


    }
}
catch(Exception $e) {
    $errorMessage = $e->getMessage();
    require('view/errorView.php');

}
?>
