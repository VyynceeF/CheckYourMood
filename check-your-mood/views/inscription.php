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

    <body class="backgroundBleu">
        <div class="conteneur-main">
            <div class="conteneur">
                <!---Cadre de connexion-->
                <div class="login inscription">

                    <p class="login-text">Inscription</p>
                    <form action="index.php" method="post">
                        <input type="hidden" name="controller" value="inscription">
                        <input type="hidden" name="action" value="signin">
                        <input type="hidden" name="premiereCo" value="1">

                        <div class="contain-double-data">
                            <input class="<?php if(isset($_POST['premiereCo'])) echo "errDonnees"; ?>" type="text" name="prenom" placeholder="Prénom*">
                            <input class="<?php if(isset($_POST['premiereCo'])) echo "errDonnees"; ?>" type="text" name="nom" placeholder="Nom*">
                        </div>

                        <input class="<?php if(isset($_POST['premiereCo'])) echo "errDonnees"; ?>" type="text" name="mail" placeholder="Email*">

                        <input class="<?php if(isset($_POST['premiereCo'])) echo "errDonnees"; ?>" type="text" name="identifiant" placeholder="Identifiant*">

                        <div class="contain-mdp">
                            <input class="<?php if(isset($_POST['premiereCo'])) echo "errDonnees"; ?>" type="text" name="motdepasse" placeholder="Mot de passe*">
                        </div>

                        <!--<input type="text" name="confirmation" placeholder="Confirmation*">-->
                       
                        <div class="contain-bottom inscription">
                            <button class="btn" type="submit">S'inscrire</button>
                            <p>OU</p>
                            <a href="/check-your-mood?action=goTo&namepage=connexion">Connectez-vous</a>
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