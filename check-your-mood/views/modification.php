<?php ?>
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

        <div class="head">
            <img src="/check-your-mood/images/CheckYourMoodLogo.png" alt="Logo Check Your Mood">
            <a href="/check-your-mood?controller=Donnees&action=goToMood&namepage=humeurs&namepage=humeurs"><img src="/check-your-mood/images/Home.png" alt="Logo Du Compte" class="LogoDuCompte"></a>
        </div>

        <div class="conteneur-main2">
            <div class="conteneur2">
                <div class="FirstFrame">
                    <img src="/check-your-mood/images/pencil.png" alt="Logo Pencil"><br>
                    <span class="TextModifier">Modifier</span>
                </div>
                <div class="SecondFrame">
                    <div>
                        <form action="index.php" method="post">
                            <input type="hidden" name="controller" value="donnees">
                            <input type="hidden" name="action" value="updateData">

                            <div class="NomPrenom">
                                <input type="text" name="prenom" placeholder="Prénom*">
                                <input type="text" name="nom" placeholder="Nom*">
                            </div><br>  
                            <div class="FirdFrame">
                                <input type="text" name="mail" placeholder="Email*"><br>    
                                <input type="text" name="identifiant" placeholder="Identifiant*"><br>
                                <input type="text" name="motdepasse" placeholder="Mot de passe*"><br>
                                <input type="text" name="motdepasse" placeholder="Mot de passe*">
                            </div>
                    </div>
                    <div>
                            <!--<input type="text" name="confirmation" placeholder="Confirmation*">-->
                        
                            <div class="Register">
                                <button class="btn" type="submit">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>