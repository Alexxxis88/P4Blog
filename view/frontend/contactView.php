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
                <input type="text" id="firstName" name="firstName" placeholder="Votre prénom" maxlength="20" required/>
            </div>
            <div>
                <label for="lastName">Votre nom</label><br />
                <input type="text" id="lastName" name="lastName" placeholder="Votre nom" maxlength="20" required/>
            </div>
            <div>
                <label for="contactEmail">Votre adresse email</label><br />
                <input type="text" id="contactEmail" name="contactEmail" placeholder="Votre adresse email" required/>
            </div>
            <div>
                <label for="topic">Intitulé de votre message</label><br />
                <input type="topic" id="topic" name="topic" placeholder="Intitulé de votre message" maxlength="40"  required/>
            </div>
            <div>
            <div>
                <label for="messageContent">Votre message</label><br />
                
                <textarea id="messageContent" name="messageContent" cols="100" rows="15" maxlength="1000" required onkeyup="textCounter(this,'counter',1000);">Votre message</textarea>
                </div>

                <!-- Used to count how many characters there is left -->
                <input disabled  maxlength="3" size="3" value="1000" id="counter">

            <div>
            <!-- FIXME ; rajouter le captcha -->
            <!-- <input type="hidden" name="recaptcha" id="recaptcha">  -->
                <input type="submit" value="Envoyer"/>
            </div>
        </form>
    </div> 
        <p><a href="index.php">Retour à la page d'accueil</a></p>
    <script src="public/js/displayFunctions.js"></script>
    </body>
</html>    
