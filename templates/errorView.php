<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Erreur</title>
        <link href="public/css/style.css" rel="stylesheet"/> 

        <!-- Font Awesome Icon -->
        <script src="https://kit.fontawesome.com/0e45521ec5.js"></script>

        <!-- Favico -->
        <link rel="apple-touch-icon" sizes="57x57" href="./public/img/favico/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="./public/img/favico/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="./public/img/favico/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="./public/img/favico/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="./public/img/favico/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="./public/img/favico/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="./public/img/favico/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="./public/img/favico/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="./public/img/favico/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="./public/img/favico/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="./public/img/favico/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="./public/img/favico/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="./public/img/favico/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">

        
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

