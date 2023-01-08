<?php 
    // Test si on est bien connecté (session existante et bon numéro de session)
	if(!isset($_SESSION['id']) || !isset($_SESSION['mdp']) || !isset($_SESSION['numeroSession']) || $_SESSION['numeroSession']!=session_id()) {
		// Renvoi vers la page de connexion
  		header("Location: /check-your-mood/index.php");
        exit();
	}
?>
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
            <form action="index.php" method="post">
                <input type="hidden" name="deconnexion" value = "1">
                <button class='btn-deco' type="submit">Se deconnecter</button>
            </form>
        </div>

        <div class="contain">

            <div class="menu">
                <div><a href="/check-your-mood?controller=mood&action=goTo&namepage=humeurs">Humeurs</a></div>
                <div><a href="/check-your-mood?controller=donnees&action=goToMood&namepage=visualisation">Visualisation</a></div>
                <div><a href="#">Parametre</a></div>
            </div>
            <div class="contain-modif">
                <div class="FirstFrame">
                    <img src="/check-your-mood/images/pencil.png" alt="Logo Pencil"><br>
                    <span class="TextModifier">Modifier</span>
                </div>
                <div class="SecondFrame">
                    <?php if($updateOk == 1){ ?>
                    <p class = "err">La changements des données n'a pas pu etre effectuer</p>
                    <?php }else if($updateOk == 2){ ?>
                    <p class="ok">Le changement à été effectuer</p>
                    <?php } ?>
                    <form action="index.php" method="post">
                        <div>
                            <input type="hidden" name="controller" value="donnees">
                            <input type="hidden" name="action" value="updateData">

                            <div class="NomPrenom">
                                <input type="text" name="prenom" placeholder="Prénom*" value="<?php echo $_SESSION['prenom'] ?>">
                                <input type="text" name="nom" placeholder="Nom*" value="<?php echo $_SESSION['nom'] ?>">
                            </div><br>  
                            <div class="FirdFrame">
                                <input type="text" name="mail" placeholder="Email*" value="<?php echo $_SESSION['mail'] ?>"><br>    
                                <input type="text" name="identifiant" placeholder="Identifiant*" value="<?php echo $_SESSION['id'] ?>"><br>
                                <input type="text" name="motdepasse" placeholder="Mot de passe*" value="<?php echo $_SESSION['mdp'] ?>"><br>
                            </div>
                        </div>
                        <div>
                            <div class="Register">
                                <button class="btn" type="submit">Enregistrer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>