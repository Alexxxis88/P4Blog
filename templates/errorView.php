<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Erreur</title>
        <link href="public/css/style.css" rel="stylesheet" /> 
    </head>
        
    <body>
        <h1>Oups...on dirait qu'une erreur s'est produite</h1>
        <p><strong>Voici la cause de cette erreur :</strong> <?= $errorMessage?> </p>
        <button onclick="goBack()">Retourner à la page précédente</button>
        <script>
        function goBack() {
        window.history.back();
        }
        </script>
        <button><a href="index.php">Retourner à la page d'accueil</a></button>

    </body>
</html>