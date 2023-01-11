<?php include("session.php"); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta HTTP-EQUIV="Pragma" content="no-cache"> 
<meta HTTP-EQUIV="Expires" content="-1">
    <title>CheckYourMood - Inscription</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="/check-your-mood/css/style.css">
	<link rel="stylesheet" href="/check-your-mood/css/header.css">
</head>

<?php
spl_autoload_extensions(".php");
spl_autoload_register();

use yasmf\HttpHelper;
?>

    <script>	 
    function openForm() {
		document.getElementById("popupFormModification").style.display = "block";
		// Ajout du flou sur toutes les humeurs
		for (let noId = 0 ; noId <= nbHumeur ; noId++) {
			document.getElementById("containHumeur" + noId).classList.add("flou");
		}
	}
	function closeForm() {
		document.getElementById("popupFormModification").style.display = "none";
		// Suppression du flou sur toutes les humeurs
		for (let noId = 0 ; noId <= nbHumeur ; noId++) {
			document.getElementById("containHumeur" + noId).classList.remove("flou");
		}
	}
    </script>

    <body>

        <?php include("header.php"); ?>

        <div class="contain page">
            <div class="container">
                <?php
                    // Vérifie s'il y a une tentative de modification réussite de mot de passe
                    if ($tentativeModificationMDP && $modificationMDPOk) {
                        echo '<span class="ok">Modification de mot de passe effectuée</span>' ;
                    }   
                    // Vérifie s'il y a une tentative de modification réussite de mot de passe
                    if ($tentativeModificationInformation && $modificationInformationOk) {
                        echo '<span class="ok">Modification des informations effectuées</span>' ;
                    }  
                ?>
                <div class="row">
                    <div class="col-md-12 ">
                        <span><i class="fa fa-pencil fa-10x" aria-hidden="true"></i></span><br>
                        <span class="textModifier">Modifier</span>
                    </div>
                    <br>
                    
                </div>

                <div class="row">
                    <form action="index.php" method="post">
                        <div>
                            <input type="hidden" name="controller" value="donnees">
                            <input type="hidden" name="action" value="updateData">

                            <div class="col-md-6 col-xs-12 containModification">
                                <span>&nbsp;&nbsp;Prénom</span>
                                <input class="form-control" type="text" name="prenom" placeholder="Prénom*" value="<?php echo $prenom ?>">
                            </div>
                            <div class="col-md-6 col-xs-12 containModification">
                                <span>&nbsp;&nbsp;Nom</span>
                                <input class="form-control" type="text" name="nom" placeholder="Nom*" value="<?php echo $nom ?>">
                            </div> 
                            <div class="col-xs-12 containModification">
                                <span>&nbsp;&nbsp;Courriel</span>
                                <input class="form-control" type="text" name="mail" placeholder="Email*" value="<?php echo $courriel ?>">  
                            </div> 
                            <div class="col-xs-12 containModification">
                                <span>&nbsp;&nbsp;Identifiant</span>
                                <input class="form-control" type="text" name="identifiant" placeholder="Identifiant*" value="<?php echo $identifiant ?>">
                            </div>
                            <div class="col-xs-12 containModification">
                                <button class="btn-ajout" type="submit" form="rien" onclick="openForm()">Modifier le mot de passe</button>
                            </div>
                        </div>
                        <div class="col-xs-12 containModificationEnregistrer">
                            
                            <a class="annuler" href="/check-your-mood?controller=donnees&action=viewModification&namepage=modification">Annuler</a>
                            <button class="btn-ajout" type="submit">Enregistrer</button>
                        </div>
                    </form>
                    <div id="popupFormModification">
                        <?php
                            // Vérifie s'il y a une tentative de modification de mot de passe
                            if ($tentativeModificationMDP && !$modificationMDPOk) {
                                // Informe de l'erreur
                                if (!$mdpOk) {
                                    echo '<span class="err">Mot de passe incorrect</span>' ;
                                } else if (!$mdpNouveauOk) {
                                    echo '<span class="err">Nouveau mot de passe incorrect</span>' ;
                                }
                                // Affiche la popup
                                echo '<script>openForm()</script>';
                            }
                        ?>
					    <form action = "index.php" method="post">
                            <input type="hidden" name="controller" value="donnees">
                            <input type="hidden" name="action" value="updateMDP"><div class="containModification">
                            <div class="containModification">
                                <span>&nbsp;&nbsp;Ancien mot de passe</span>
                                <input class="form-control" type="password" name="ancienMDP" placeholder="Ancien mot de passe">
                            </div>
                            <div class="containModification">
                                <span>&nbsp;&nbsp;Nouveau mot de passe</span>
                                <input class="form-control" type="password" name="nouveauMDP" placeholder="Nouveau mot de passe">
                            </div>
                            <div class="containModification">
                                <span>&nbsp;&nbsp;Confirmation du nouveau mot de passe</span>
                                <input class="form-control" type="password" name="confirmationNouveauMDP" placeholder="Confirmation du nouveau mot de passe">
                            </div>
                            <!-- Boutons d'ajout et d'annulation de l'humeur -->
                            <div class="btnNav">
                                <button type="button" class="annuler" onclick="closeForm()">Annuler</button>
                                <button type="submit" class="btn-ajout">Modifier</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>