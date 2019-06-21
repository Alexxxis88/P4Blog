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



        <div class="singIn">
            <form action="index.php?action=addNewMember" method="post">
                <div>
                    <label for="username">Le pseudo doit faire 4 caractères minimum (20 maximum) et peut contenir des lettres et des chiffres</label><br />
                    <input type="text" id="username" name="username" placeholder="Votre Pseudo" required/>
                </div>
                <div>
                    <label for="pass">Le password doit faire 8 caractères minimum (20 maximum) et peut contenir des lettres, chiffres et caractères spéciaux authorisés ( . - _ ! ?)</label><br />
                    <input type="password" id="pass" name="pass" placeholder="Votre Password" required/>
                </div>
                <div>
                    <label for="passCheck">Vérification Password</label><br />
                    <input type="password" id="passCheck" name="passCheck" placeholder="Tapez votre Password à nouveau" required/>
                </div>
                <div>
                    <label for="email">Adresse Email</label><br />
                    <input type="text" id="email" name="email" placeholder="Votre adresse Email" required/>
                </div>
                <div>
                <input type="hidden" name="recaptcha" id="recaptcha">
                    <input type="submit" value="S'inscrire"/>
                </div>
            </form>
        </div> 
        <p><a href="index.php">Retour à la page d'accueil</a></p>
    </body>
</html>
   
