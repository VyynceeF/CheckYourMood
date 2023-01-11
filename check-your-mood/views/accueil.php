<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CheckYourMood - Connexion</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="/check-your-mood/css/accueil.css">
    <link rel="stylesheet" href="/check-your-mood/css/header.css">
    <link href="fontawesome-free-6.2.1-web/css/all.css" rel="stylesheet">
    <link rel="icon" href="/check-your-mood/images/YeuxLogo.png">


</head>
<?php
spl_autoload_extensions(".php");
spl_autoload_register();

use yasmf\HttpHelper;

?>
    <body class="backgroundBleu">
        <?php include("header.php"); ?>
        <div class="container bigContain">
            <div class="conteneur">
                <div>
                    <img class="logo" src="/check-your-mood/images/CheckYourMoodLogo.png" alt="Logo Check Your Mood">
                </div>
                <div class="big-center-div text-center">
                    <span>Cette application  permet à un utilisateur enregistré sur la plateforme d’indiquer son humeur à différents moments de la journée afin de pouvoir disposer de visualisations sur son humeur au fil du temps en fonction de différents paramètres comme la période, le type d’humeur, etc.</span>
                </div>
                <div class="seConnecter">
                    <button class="connect"><i class="fa fa-sign-in" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>

    </body>
</html>