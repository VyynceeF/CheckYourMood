<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CheckYourMood - Connexion</title>
    <link rel="stylesheet" href="/check-your-mood//css/style.css">
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
                <div class="login">

                    <p class="login-text">Connexion</p>

                    <form method="post">
                        <input type="hidden" name="action" value="login">
                        <input class="user" type="text" name="identifiant" placeholder="Identifiant">
                        <div class="contain-mdp">
                            <input class="locker" type="text" name="motdepasse" placeholder="Mot de passe">
                            <div class="contain-revele"><input type="checkbox" name="revele"><label>Révéler mot de passe</label></div>
                        </div>
                        <div class="contain-btn"><input class="btn" type="submit" value="Se connecter"></div>
                    </form>

                    <div class="contain-bottom">
                        <hr>                
                        <p>Vous n'avez pas de compte ?</p><form method = "post"><input type = "hidden" name = "action" value="changeView"><input type="hidden" name="namepage" value="inscription"><input type="submit" value = "Inscrivez-vous"></form>
                    </div>
                    
                </div>

                <div class="login right">
                    <img class="logo" src="/check-your-mood/images/CheckYourMoodLogo.png" alt="Logo Check Your Mood">
                </div>

            </div>
        </div>
    </body>
</html>