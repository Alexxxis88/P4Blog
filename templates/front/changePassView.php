<?php
//Needed here because I can't call the $sessionController->checkSession(); in the routeur because there is no action to dislplay the changePassView.php as it's opened in a modal box and not a proper view

//Get user's ID using COOKIE or SESSION
if (isset($_COOKIE['id'])) {
    $cookieOrSessionID = $_COOKIE['id'];
} elseif (isset($_SESSION['id'])) {
        $cookieOrSessionID = $_SESSION['id'];
}
?>
<div class="modal fade" id="updatePassModal" tabindex="-1" role="dialog" aria-labelledby="updatePassModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="updatePassModalLabel">Changer de mot de passe</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="updatePassForm" action="index.php?action=UpdatePass" method="post">
                    <div class="form-group">
                        <label for="idNewPass" class="col-form-label">Votre numéro de session</label><br>
                        <input type="text" id="idNewPass" name="idNewPass" value="<?= $cookieOrSessionID ?>"  readonly="readonly" required/>
                    </div><br><br>
                    <div class="form-group">
                        <label for="currentPass" class="col-form-label">Votre password actuel*</label>
                        <input type="password" class="form-control" id="currentPass" name="currentPass" required>
                    </div><br><br>
                    <div class="form-group">
                        <label for="newPass" class="col-form-label"><em>Votre nouveau password doit faire 8 caractères minimum (20 maximum) et peut contenir des lettres, chiffres et caractères spéciaux authorisés ( . - _ ! ?)</em><br><br>Nouveau password*</label>
                        <input type="password" class="form-control" id="newPass" name="newPass" required>
                    </div><br><br>
                    <input type="submit" class="btn btn-primary" id="changePassBtn" value="Mettre à jour le password"/>
                </form>
            </div>
        </div>
    </div>
</div>
