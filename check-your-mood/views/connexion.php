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
        <script src="script\script.js"></script>
        <div class="conteneur-main">
            <div class="conteneur">
                <!---Cadre de connexion-->
                <div class="login">

                    <p class="login-text">Connexion</p>

                    <?php if(!$errData){?>
                        <p class = "err">Mot de passe ou identifiant incorrecte</p>
                    <?php } ?>

                    <form action="index.php" method="post">
                        <input type="hidden" name="action" value="login">
                        <input class="user" type="text" name="identifiant" placeholder="Identifiant" value="<?php echo HttpHelper::getParam('identifiant'); ?>">
                        <div class="contain-mdp">
                            <input class="locker" type="password" name="motdepasse" placeholder="Mot de passe" id="myInput"><br>
                            <div class="contain-revele"><input type="checkbox" name="revele" onclick="myFunction()"><label><h3>Révéler mot de passe</h3></label></div>
                        </div>
                        <div class="btn-connect"><button class="btn" type="submit">Se connecter</button></div>
                    </form>

                    <br>
                    <hr>

                    <div class="contain-bottom">    
                        <p>Vous n'avez pas de compte ? <a href="/check-your-mood?action=goTo&namepage=inscription">Inscrivez-vous</a></p>    
                    </div>
                    
                </div>


                <div class="login right">
                    <img class="logo" src="/check-your-mood/images/CheckYourMoodLogo.png" alt="Logo Check Your Mood">
                </div>

            </div>
        </div>
    </body>
</html>