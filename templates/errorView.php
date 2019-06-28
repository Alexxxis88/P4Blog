<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Erreur</title>
        <link href="public/css/style.css" rel="stylesheet"/> 
        
    </head>
        
    <body class="errorPage">
        <div class="container">
            <div class="row">
                <div class="col-md-12 errorPageContainer">
                    <h1>Oups...on dirait qu'une erreur s'est produite</h1>
                    <p><strong>Voici la cause de cette erreur :</strong> <?= $errorMessage?> </p>
                    <a href="index.php"><i class="fas fa-home"></i></i>Retourner à la page d'accueil</a>

                </div>
            </div>
        </div>                
    </body>
</html>

