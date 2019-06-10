<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<title>Formulaire de contact</title>
	</head>

	<body>
	<div class="contactForm">
            <form action="index.php?action=sendMessage" method="post">
                <div>
                    <label for="firstName">Votre prénom</label><br />
                    <input type="text" id="firstName" name="firstName" placeholder="Votre prénom" required/>
                </div>
				<div>
                    <label for="lastName">Votre nom</label><br />
                    <input type="text" id="lastName" name="lastName" placeholder="Votre nom" required/>
                </div>
                <div>
                    <label for="contactEmail">Votre adresse email</label><br />
                    <input type="text" id="contactEmail" name="contactEmail" placeholder="Votre adresse email" required/>
                </div>
                <div>
					<label for="messageContent">Votre message</label><br />
					<textarea id="messageContent" name="messageContent">Votre message</textarea>
       			</div>
                <div>
				<!-- FIXME ; rajouter le captcha -->
                <!-- <input type="hidden" name="recaptcha" id="recaptcha">  -->
                    <input type="submit" onclick="return alert('Votre message a été envoyé')" value="Envoyer"/>
                </div>
            </form>
        </div> 
        <p><a href="index.php">Retour à la page d'accueil</a></p>


        <button class="adminBtns"><a href="index.php?action=sendMessageTest">test email</a></button>
