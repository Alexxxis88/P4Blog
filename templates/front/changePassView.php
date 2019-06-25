<?php
//FIXME this should not be needed and this line should work  $sessionController->checkSession();

if(isset($_COOKIE['id']))
    {
        $cookieOrSessionID = $_COOKIE['id'];
    }
    elseif(isset($_SESSION['id']))
    {
            $cookieOrSessionID = $_SESSION['id'];
    }
    ?>
    
    <!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Changement de mot de passe</title>
        <link href="public/css/style.css" rel="stylesheet" />
    </head>
        
    <body>
    <div class="modal fade" id="updatePassModal" tabindex="-1" role="dialog" aria-labelledby="updatePassModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updatePassModalLabel">Connexion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="updatePassForm" action="index.php?action=UpdatePass" method="post">
                            <div>
                                <input type="text" id="id" name="id" value="<?= $cookieOrSessionID ?>"  hidden required/>
                            </div>
                            <div class="form-group">
                                <label for="currentPass" class="col-form-label">Votre password actuel*</label>
                                <input type="password" class="form-control" id="currentPass" name="currentPass" required>
                            </div><br/><br/>
                            <div class="form-group">
                                <label for="newPass" class="col-form-label"><em>Votre nouveau password doit faire 8 caractères minimum (20 maximum) et peut contenir des lettres, chiffres et caractères spéciaux authorisés ( . - _ ! ?)</em><br/><br/>Nouveau password*</label>
                                <input type="password" class="form-control" id="newPass" name="newPass" required>
                            </div><br/><br/>
                            <input type="submit" class="btn btn-primary" value="Mettre à jour le password"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</html>

<!-- FIXME : étrange, ça fonctionne meme si je ne mets pas le code suivant -->
<script>
$('#updatePassModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var modal = $(this)
})</script>