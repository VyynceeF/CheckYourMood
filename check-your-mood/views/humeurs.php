<?php 
    // Test si on est bien connecté (session existante et bon numéro de session)
	if(!isset($_SESSION['id']) || !isset($_SESSION['mdp']) || !isset($_SESSION['numeroSession']) || $_SESSION['numeroSession']!=session_id()) {
		// Renvoi vers la page de connexion
  		header("Location: /check-your-mood/index.php");
        exit();
	}

    if(isset($_POST['deconnexion']) && $_POST['deconnexion'] == "1"){
        session_destroy();
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
    <title>Check Your Mood - Humeurs</title>
    <link rel="stylesheet" href="/check-your-mood/css/style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
</head>
<body>

	<script>
	function openForm() {
		document.getElementById("popupForm").style.display = "block";
	}
	function closeForm() {
		document.getElementById("popupForm").style.display = "none";
	}
	
	function openPopupHumeur(id) {
		document.getElementById("popupHumeur" + id).style.display = "block";
	}
	function closePopupHumeur(id) {
		document.getElementById("popupHumeur" + id).style.display = "none";
	}
	</script>

<?php
spl_autoload_extensions(".php");
spl_autoload_register();

use yasmf\HttpHelper;
?>

    <div class="head">
        <img src="/check-your-mood/images/CheckYourMoodLogo.png" alt="Logo Check Your Mood">
        <form action="index.php" method="post">
            <input type="hidden" name="deconnexion" value = "1">
            <button class='btn-deco' type="submit">Se deconnecter</button>
        </form>
    </div>

    <div class="contain">
        <div class="menu">
            <div><a href="#">Humeurs</a></div>
            <div><a href="/check-your-mood?controller=donnees&action=goToMood&namepage=visualisation">Visualisation</a></div>
            <div><a href="/check-your-mood?controller=mood&action=goTo&namepage=modification">Parametre</a></div>
        </div>
        <div id="contain-contenu" class="contain-mood">

            <div class="head-mood">

                <!-- Ligne d'ajout d'une humeur -->
                <p>Humeurs</p>
                <button onclick="openForm()">+</button>

                <!-------------------------------->
                <!-- Popup d'ajout d'une humeur -->
                <!-------------------------------->
                <!-- N'est affiché que lorsque  -->
                <!-- l'utilisateur clique sur   -->
                <!-- le +                       -->
                <div id="popupForm">
					<form action = "index.php" method="post">
						<input type="hidden" name="controller" value="Mood">
						<p class="sansBordure">Création humeur</p>
						<hr>
						<div class="ajoutHumeurForm">
							<!-- Libellé de l'humeur -->
							<select name="humeur" class="form-control">
								<?php
								while($row = $libelles->fetch()){
									echo "<option value = '".$row['codeLibelle']."'>".$row['emoji']." ".$row['libelleHumeur']."</option>";
								}
								?>
							</select>
							<!-- Date de l'humeur -->
							<input type="date" name="dateHumeur" class="form-control" value="<?php echo date('Y-m-d'); ?>" required />
							<!-- Heure de l'humeur -->
							<input type="time" class="form-control" name="heure" value="<?php echo date('H:i'); ?>" required /><br/>
						</div>
						<!-- Contexte de l'humeur -->
						<input type="textarea" name="contexte" class="form-control" placeholder="Contexte...">
						<!-- Boutons d'ajout et d'annulation de l'humeur -->
						<div class="btnNav">
							<button type="button" class="annuler" onclick="closeForm()">Annuler</button>
							<button type="submit" class="btn-ajout">Ajouter</button>
						</div>
					</form>
                </div>
            </div>
            <div class="container"> 
				<div class="row">
				<?php
					if (!$updateOk) {
						
						echo '<span class="col-xs-12">La modification n\'a pu être effectué, veuillez réessayer ultérieurement.</span>';
					}
					$i = 0;
					while($row = $humeurs->fetch()){

						echo '<div class="col-md-4 col-xs-12">';
							echo '<button class="containCadre" onclick="openPopupHumeur('.$i.')">';
								echo '<span>'.$row['emoji'].'  '.$row['libelleHumeur'].'</span><br/>';
								echo '<span>'.$row['dateHumeur'].'  '.$row['heure'].'</span>';
							echo '</button>';
						echo '</div>';
						
						/**
						 * Popup d'ajout d'une humeur
					     * --------------------------
                		 * N'est affiché que lorsque 
                		 * l'utilisateur clique sur  
                		 * le +                      
						 */
						echo '<div id="popupHumeur'.$i.'" class="popupHumeur">';
							echo '<form class="containPopup">';
								echo '<input type="hidden" name="controller" value="donnees">';
								echo '<input type="hidden" name="action" value="updateHumeur">';
								echo '<input type="hidden" name="codeHumeur" value="'.$row['codeHumeur'].'">';
								echo '<span class="title">'.$row['emoji'].'  '.$row['libelleHumeur'].'</span>';
								echo '<span>'.$row['dateHumeur'].'  '.$row['heure'].'</span><br/>';
								echo '<span>Contexte</span><br/>';
								echo '<input type="textarea" class="form-control" name="contexte" value="'.$row['contexte'].'">';
								echo '<div class="btnNav">';
									echo '<button type="button" class="annuler" onclick="closePopupHumeur('.$i.')">Fermer</button>';
									echo '<button type="submit" class="btn-ajout">Modifier</button>';
								echo '</div>';
							echo '</form>';
						echo '</div>';
						$i++;
					}

				?>
				</div>
				<!-------------------------------->
                <!-- Popup d'ajout d'une humeur -->
                <!-------------------------------->
                <!-- N'est affiché que lorsque  -->
                <!-- l'utilisateur clique sur   -->
                <!-- le +                       -->
                <div id="popupForm">
					<form action = "index.php" method="post">
						<input type="hidden" name="controller" value="Mood">
						<p class="sansBordure">Humeur</p>
					</form>
                </div>
				
			</div>

               
            <div class="affichage">
              <canvas id="myChart"></canvas>
            </div>
        </div>
      </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="script/script.js"></script>
</body>
</html>
