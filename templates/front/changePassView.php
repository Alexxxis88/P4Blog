<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Changement de mot de passe</title>
        <link href="public/css/style.css" rel="stylesheet" />
    </head>
        
    <body>
        <div class="passChange">
            <form action="index.php?action=UpdatePass" method="post">
                <div>
                    <input type="text" id="id" name="id" value="<?= $cookieOrSessionID ?>"  hidden required/>
                </div>
                <div>
                    <label for="currentPass">Votre password actuel</label><br />
                    <input type="password" id="currentPass" name="currentPass" placeholder="Tapez votre Password actuel" required/>
                </div>
                <div>
                    <label for="newPass">Votre nouveau password doit faire 8 caractères minimum (20 maximum) et peut contenir des lettres, chiffres et caractères spéciaux authorisés ( . - _ ! ?)</label><br />
                    <input type="password" id="newPass" name="newPass" placeholder="Votre nouveau password" maxlength="20" required/>
                </div>
                <div>
                    <input type="submit" value="Mettre à jour le password"/>
                </div>
            </form>
        </div> 
        <p><a href="index.php">Retour à la page d'accueil</a></p>
    </body>
</html>