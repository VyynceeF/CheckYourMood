<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CheckYourMood - Inscription</title>
    <link rel="stylesheet" href="/check-your-mood/css/style.css">
</head>

<?php
spl_autoload_extensions(".php");
spl_autoload_register();

use yasmf\HttpHelper;

?>

    <body>
        <div class="container-main">
            <div class="container">
                <!---Cadre de connexion-->
                <div class="login inscription">

                    <p class="login-text">Inscription</p>

                    <form method="post">
                        <div class="contain-double-data">
                            <input type="text" name="prenom" placeholder="Prénom*">
                            <input type="text" name="nom" placeholder="Nom*">
                        </div>
                        <div class="contain-double-data date">
                            <select name="gender">
                                <option value="Genre">Genre</option>
                                <option value="Homme">Homme</option>
                                <option value="Femme">Femme</option>
                                <option value="Autre">Autre</option>
                            </select>
                            <input type="date" name="date" class="date">
                        </div>

                        <input type="text" name="email" placeholder="Email*">

                        <input type="text" name="identifiant" placeholder="Identifiant*">

                        <div class="contain-mdp">
                            <input type="text" name="motdepasse" placeholder="Mot de passe*">
                        </div>

                        <input type="text" name="confirmation" placeholder="Confirmation*">

                        <div class="contain-btn inscription">
                            <input class="btn" type="submit" value="S'inscrire">
                            <p>OU</p> <form method = "post"><input type = "hidden" name = "action" value="changeView"><input type="hidden" name="namepage" value="connexion"><input type="submit" value = "Connectez-vous"></form>
                            
                        </div>
                    </form>
                </div>

                <div class="login right">
                    <img class="logo" src="/check-your-mood//images/CheckYourMoodLogo.png" alt="Logo Check Your Mood">
                </div>

            </div>
        </div>
    </body>
</html>