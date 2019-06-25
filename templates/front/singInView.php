<?php //FIXME : put into controleur
$clef_secret = "6LepyacUAAAAAApuIRZjRc3VAAE0TyYVM6V7CQQ2";
$clef_public = "6LepyacUAAAAAONTcPfeWbCCyTHbK96JKT9epk4y";
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Page d'inscription</title>
        <link href="public/css/style.css" rel="stylesheet" /> 
        <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $clef_public;?>"></script>
        <script>
        grecaptcha.ready(function () {
            grecaptcha.execute('<?php echo $clef_public;?>', { action: 'contact' }).then(function (token) {
                var recaptcha = document.getElementById('recaptcha');
                recaptcha.value = token;
            });
        });
        </script>
    </head>
        
    <body>

    <?php //FIXME : put into index or controleur ? 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha'])) 
{
	$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
	$recaptcha_response = $_POST['recaptcha'];
	$recaptcha = file_get_contents($recaptcha_url . '?secret=' . $clef_secret . '&response=' . $recaptcha_response);
	$recaptcha = json_decode($recaptcha);
	if ($recaptcha->score >= 0.5) 
	{
	echo "succès";
	} 
	else 
	{
	echo "échec";
	}
} 
?>


        <div class="modal fade" id="singInModal" tabindex="-1" role="dialog" aria-labelledby="singInModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="singInModalLabel">Inscription</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="singInForm" action="index.php?action=addNewMember" method="post">
                            <div class="form-group">
                                <label for="username" class="col-form-label"><em>Le pseudo doit faire 4 caractères minimum (20 maximum) et peut contenir des lettres et des chiffres</em><br/><br/>Pseudo*</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div><br/><br/>
                            <div class="form-group">
                                <label for="pass" class="col-form-label"><em>Le password doit faire 8 caractères minimum (20 maximum) et peut contenir des lettres, chiffres et caractères spéciaux authorisés ( . - _ ! ?)</em><br/><br/>Password*</label>
                                <input type="password" class="form-control" id="pass" name="pass" required>
                            </div><br/>
                            <div class="form-group">
                                <label for="passCheck" class="col-form-label">Vérification du password*</label>
                                <input type="password" class="form-control" id="passCheck" name="passCheck" placeholder="Tapez votre Password à nouveau" required>
                            </div><br/>
                            <div class="form-group">
                                <label for="email" class="col-form-label">Adresse Email*</label>
                                <input type="text" class="form-control" id="email" name="email" required>
                            </div><br/>
                            <input type="hidden" name="recaptcha" id="recaptcha">
                            <input type="submit" class="btn btn-primary" value="S'inscrire"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
   
<!-- FIXME : étrange, ça fonctionne meme si je ne mets pas le code suivant -->
<script>
$('#singInModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var modal = $(this)
})</script>