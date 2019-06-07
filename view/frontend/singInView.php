<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Page d'inscription</title>
        <link href="public/css/style.css" rel="stylesheet" /> 
    </head>
        
    <body>
        <div class="singIn">
            <form action="index.php?action=addNewMember" method="post">
                <div>
                    <label for="username">Le pseudo doit faire 4 caractères minimum et peut contenir des lettres et des chiffres</label><br />
                    <input type="text" id="username" name="username" placeholder="Votre Pseudo" required/>
                </div>
                <div>
                    <label for="pass">Le password doit faire 8 caractères minimum et peut contenir des lettres, chiffres et caractères spéciaux authorisés ( . - _ ! ?)</label><br />
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
                    <input type="submit" value="S'inscrire"/>
                </div>
            </form>
        </div> 
        <p><a href="index.php">Retour à la page d'accueil</a></p>
    </body>
</html>
   

