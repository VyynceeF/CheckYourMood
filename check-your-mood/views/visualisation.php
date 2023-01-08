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
    <title>Check Your Mood - Humeurs</title>
    <link rel="stylesheet" href="/check-your-mood/css/style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
	<!-- Police Font Awesome pour les icônes -->
	<link href="fontawesome-free-6.2.1-web/css/all.css" rel="stylesheet">

    <?php
    $ChoixTypeDeRepresentation = ['Choissez votre représentation','Jour','Semaine','Année']
    ?>

	<!-- Création du srcipt js pour le digramme de comparaison d'humeur par année-->
    <script>
        window.onload = function () {

        var chart = new CanvasJS.Chart("chartconteneur", {
            animationEnabled: true,
            theme: "light2",
            title:{
                text: "Diagramme de comparaison par année"
            },
            axisY:{
                includeZero: true
            },
            legend:{
                cursor: "pointer",
                verticalAlign: "center",
                horizontalAlign: "right",
                itemclick: toggleDataSeries
            },
            data: [{
                type: "column",
                name: <?php echo '"'.$anneeComparaison.'"';?>,
                indexLabel: "{y}",
                showInLegend: true,
                dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
            },{
                type: "column",
                name: <?php echo '"'.$anneeChoisi.'"';?>,
                indexLabel: "{y}",
                showInLegend: true,
                dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

        function toggleDataSeries(e){
            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            }
            else{
                e.dataSeries.visible = true;
            }
            chart.render();
            }
        }
    </script>


</head>
<body>


<?php
spl_autoload_extensions(".php");
spl_autoload_register();

$day = [2 => 'Lundi',3 => 'Mardi',4 => 'Mercredi',5 => 'Jeudi',6 => 'Vendredi',7 => 'Samedi',1 => 'Dimanche'];

use yasmf\HttpHelper;
?>



    <div class="head">
        <img src="/check-your-mood/images/CheckYourMoodLogo.png" alt="Logo Check Your Mood">
        <!-- lien pour aller sur la page des humeurs : (ne marche pas pour l'instant) -->
        <a href="/check-your-mood?controller=Mood&action=index">Humeurs</a>
    </div>
	
    <?php
    if(!isset($_POST['premiereCo'])){
        ?>
        <div class="conteneur-main">
            <div class="conteneurVisu">
                <div class="loginVisu left">
                    <img class="logo" src="/check-your-mood/images/visualisation.png" alt="Logo Check Your Mood">
                </div>
                <div class="loginVisu ">
                    <div class="row">
                        <p class="login-textVisu">Prêt à visualiser vos données ?</p>
                        <p class="login-textVisuBis">Veuillez d'abord choisir l'année dont vous voulez visualiser vos données et le temps</p>
                    </div>
                    <div class="row-btn">
                        <form action="index.php" method="post">
                            <input type="hidden" name="premiereCo" value="1">
                            <input type="hidden" name="controller" value="donnees">
                            <input type="hidden" name="action" value="goToMood">
                            <input type="hidden" name="namepage" value="visualisation">

                            <!-- Choisir l'année dont on souhaite visualiser les données-->

                                <div class="btn-connect">
                                    <select name="anneeChoisi" class = "btnVisu" >
                                        <?php
                                        for($nbr = 2021; $nbr <= $anneeActuelle; $nbr ++){
                                            if(isset($_POST['anneeChoisi'])){
                                                if($_POST['anneeChoisi'] == $nbr){
                                                    ?>
                                                    <option value="<?php echo $_POST['anneeChoisi'];?>" selected><?php echo $_POST['anneeChoisi'];?></option>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <option value="<?php echo $nbr;?>"><?php echo $nbr;?></option>
                                                    <?php
                                                }
                                            } else {
                                                if($anneeActuelle == $nbr){
                                                    ?>
                                                    <option value="<?php echo $anneeActuelle;?>" selected><?php echo $anneeActuelle ;?></option>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <option value="<?php echo $nbr;?>"><?php echo $nbr;?></option>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>


                                <br>
                                <!-- Choisir si on veut afficher les données par jur semaine mois ou année dont on souhaite visualiser les données-->
                                <div class="btn-connect">
                                    <select name="typeDeRpresentation" class = "btnVisu ">
                                        <?php
                                        for($nbr = 1; $nbr <= 3; $nbr ++){
                                            if(isset($_POST['typeDeRpresentation'])){
                                                if($_POST['typeDeRpresentation'] == $nbr){
                                                    ?>
                                                    <option value="<?php echo $_POST['typeDeRpresentation'];?>" selected><?php echo $ChoixTypeDeRepresentation[$nbr];?></option>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <option value="<?php echo $nbr;?>"><?php echo $ChoixTypeDeRepresentation[$nbr];?></option>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <option value="<?php echo $nbr;?>"><?php echo $ChoixTypeDeRepresentation[$nbr];?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            <br>
                            <input type="submit" value ="valider 😉" class = "btnVisu">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {


		?>
		<div class="container-fluid">
			<div class="col-md-12 bG sansCadre">
				<span class="enBleu"><i class="fa-sharp fa-solid fa-face-smile-beam enBleu"> Vous pouvez modifier l'annee ou le temps </i></span> <i class="enBleu fa-sharp fa-solid fa-face-smile-beam"></i>
			</div>
			<div class="row visu">
				<div class="col-md-12 container-fluid sansCadre visu">
					<form action="index.php" method="post">
						<input type="hidden" name="premiereCo" value="1">
						<input type="hidden" name="controller" value="donnees">
						<?php
						if(isset($humeurRadar)){
							?>
							<input type="hidden" name="humeur" value="<?php echo $humeurRadar; ?>">
							<?php
						}
						?>
						<input type="hidden" name="anneeAComparer" value="<?php echo $anneeComparaison; ?>">
						<input type="hidden" name="action" value="goToMood">
						<input type="hidden" name="namepage" value="visualisation">

						<?php
						if($_POST['typeDeRpresentation'] != 1 ){
							?>
							<div class="col-md-3  sansCadre">
								<select name="anneeChoisi" class = "btnVisu2" >
									<?php
									for($nbr = 2021; $nbr <= $anneeActuelle; $nbr ++){
										if(isset($_POST['anneeChoisi'])){
											if($_POST['anneeChoisi'] == $nbr){
												?>
												<option value="<?php echo $_POST['anneeChoisi'];?>" selected><?php echo $_POST['anneeChoisi'];?></option>
												<?php
											} else {
												?>
												<option value="<?php echo $nbr;?>"><?php echo $nbr;?></option>
												<?php
											}
										} else {
											if($anneeActuelle == $nbr){
												?>
												<option value="<?php echo $anneeActuelle;?>" selected><?php echo $anneeActuelle ;?></option>
												<?php
											} else {
												?>
												<option value="<?php echo $nbr;?>"><?php echo $nbr;?></option>
												<?php
											}
										}
									}
									?>
								</select>
							</div>
							<?php
							}
						?>
						<div class="<?php echo $typeDeRpresentation == 1 ? "col-md-4 sansCadre": "col-md-3 sansCadre"; ?> ">
							<select name="typeDeRpresentation" class = "btnVisu2">
								<?php
								for($nbr = 1; $nbr <= 3; $nbr ++){
									if(isset($_POST['typeDeRpresentation'])){
										if($_POST['typeDeRpresentation'] == $nbr){
											?>
											<option value="<?php echo $_POST['typeDeRpresentation'];?>" selected><?php echo $ChoixTypeDeRepresentation[$nbr];?></option>
											<?php
										} else {
											?>
											<option value="<?php echo $nbr;?>"><?php echo $ChoixTypeDeRepresentation[$nbr];?></option>
											<?php
										}
									} else {
										?>
										<option value="<?php echo $nbr;?>"><?php echo $ChoixTypeDeRepresentation[$nbr];?></option>
										<?php
									}
								}
								?>
							</select>
						</div>
						<?php
						if($_POST['typeDeRpresentation'] == 2){
							?>
							<div class="<?php echo $typeDeRpresentation == 1 ? "col-md-4 sansCadre": "col-md-3 sansCadre"; ?>">
								<select name="weekGeneral" class = "btnVisu2">
									<?php
									if($anneeActuelle == $anneeChoisi){
										for($i = 1; $i <= $currentWeek ; $i++){
											if(isset($_POST['weekGeneral'])){
												if($_POST['weekGeneral'] == $i){
													$weekGeneral = $_POST['weekGeneral'];
													echo "<option value = '".$_POST['weekGeneral']."' selected >Semaine ".$_POST['weekGeneral']."</option>";
												} else {
													echo "<option value = '".$i."' >Semaine ".$i."</option>";
												}
											} else {
												if($i == $currentWeek){
													$weekGeneral = $i;
													echo "<option value = '".$i."' selected >Semaine ".$i."</option>";
												} else {
													echo "<option value = '".$i."' >Semaine ".$i."</option>";
												}
											}
										}
									} else {
										for($i = 1; $i <= 52 ; $i++){
											if($_POST['weekGeneral'] == $i){
												$weekGeneral = $_POST['weekGeneral'];
												echo "<option value = '".$_POST['weekGeneral']."' selected >Semaine ".$_POST['weekGeneral']."</option>";
											} else {
												echo "<option value = '".$i."' >Semaine ".$i."</option>";
											}
										}
									}

									?>
								</select>
							</div>
							<?php
						}
						?>
						<?php
						if($_POST['typeDeRpresentation'] == 1){
							?>
							<div class="<?php echo $typeDeRpresentation == 1 ? "col-md-4 sansCadre": "col-md-3 sansCadre"; ?>">
								<!-- Choisir la semaine dont on souhaite visualiser les données pour le graph Radar-->
								<input class = "btnVisu2" type="date" name="dateChoisiDonught" value="<?php echo $dateDonught; ?>" min="2021-01-01" max="<?php echo $anneeChoisi == $anneeActuelle ? $currentDay : $anneeChoisi + "-12-31";?>">
							</div>
							<?php
						}
						?>
						<div class="<?php echo $typeDeRpresentation == 1 ? "col-md-4 sansCadre": "col-md-3 sansCadre"; ?>">
							<input type="submit" value ="valider 😉" class = "btnVisu2">
						</div>
					</form>
				</div>
			</div>
			<br>
			<?php
			if($typeDeRpresentation == 2){
				?>
			<div class = "rowVisualisation">
				<div class = "col-md-6">
					<div class="radarPlus">
						<!-- partie du formulaire pour faire le graphe radar -->
						<form action="index.php" method="post">
						<input type="hidden" name="anneeChoisi" value="<?php echo $anneeChoisi; ?>">
						<input type="hidden" name="premiereCo" value="1">
						<input type="hidden" name="typeDeRpresentation" value="<?php echo $typeDeRpresentation; ?>">
						<input type="hidden" name="weekGeneral" value="<?php echo $weekGeneral; ?>">
						<input type="hidden" name="controller" value="donnees">
						<input type="hidden" name="action" value="goToMood">
						<input type="hidden" name="namepage" value="visualisation">
						<!-- Formulaire pour le graphe radar-->
						<select id="humeur" name="humeur">
						<?php
							/* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! */
							/* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! */
							/* mettre un selected qui fonctionne parce que sah j y arrive pas et j ai pas envi */
							while($row = $libellesRadar->fetch()){
								if(isset($_POST['humeur']) && $_POST['humeur'] == $row['codeLibelle']){
									$humeurRadar = $_POST['humeur'];
									echo "<option value = '".$row['codeLibelle']."' selected >".$row['libelleHumeur']." ".$row['emoji']."</option>";
								}else{
									$humeurRadar = isset($humeurRadar) ? $humeurRadar: $row['codeLibelle'];
								echo "<option value = '".$row['codeLibelle']."'>".$row['libelleHumeur']." ".$row['emoji']."</option>";
								}
							}
						?>
						</select>
						
						<button type="submit">OK</button>
						</form>
						<!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!  -->
						<!-- fin de la partie du formulaire pour le graphe radar  -->
						<!-- affichage du graphe radar -->
						<div class="nimport">
							<canvas id="myChart" ></canvas>
						</div>
					</div>
				</div>
				<div class = "col-md-6">
					<!-- partie affichage du tableau des humeurs -->
					<table class="table-mood">
						<tr>
							<th>
								Jour
							</th>
							<th>
								Emoji
							</th>
							<th>
								Libelle
							</th>
							<th>
								Heure
							</th>
							<th class="last-column">

							Contexte
							</th>
						</tr>

						<?php
							$ancienneDate = NULL;
							while($row = $visualisationTableau->fetch()){
								echo "<tr>";
								if ($row['jourDeLaSemaine'] == $ancienneDate) {
									echo "<td> </td>";
								} else {
									echo "<td>".$day[$row['jourDeLaSemaine']]."</td>";
								}
								echo "<td>".$row['emoji']."</td>";
								echo "<td>".$row['libelle']."</td>";
								echo "<td>".$row['heure']."</td>";
								echo "<td class = 'last-column'>".$row['contexte']."</td>";
								echo "</tr>";
								$ancienneDate = $row['jourDeLaSemaine'];
							}

						?>
					</table>
				</div>
			</div>
			<div class = "row">
				<div class = "col-md-12">
					<div class="enBleu">
						<span>Voici l'humeur qui est revenu le plus cette semaine :</span>
					</div>
					<br>
					<?php
					while($row = $humeursLaPlusFrequente->fetch()){
						?>
						<div class="enBleu">
							<span><?php echo $row['libelle']; ?></span>
						</div>
						<span class="emojie"><?php echo $row['emoji']; ?></span>
						<?php
					}
					?>
				</div>
			</div>
		</div>
		<?php
		}
		echo '<script type="text/javascript">';
		echo "var dataHumeur = '".implode(",", $visualisationRadar)."'.split(',');";
		echo 'console.table(dataHumeur);';
		echo '</script>';
		?>




			<!-- Affichage de du diagramme batton qui permet de visualiser un humeur en fonciton des mois et années-->
			<?php
			if($typeDeRpresentation == 3){
				?>
			<!-- carré du bas à droite -->
					<div class="col-md-6">

							<span>Choisissez l'annee à comparer</span>
							<form action="index.php" method="post">
							<?php
								if($typeDeRpresentation == 2){
									?>
									<input type="hidden" name="humeur" value="<?php echo $humeurRadar; ?>">
									<?php
								}
								?>
								<input type="hidden" name="anneeChoisi" value="<?php echo $anneeChoisi; ?>">
								<input type="hidden" name="typeDeRpresentation" value="<?php echo $typeDeRpresentation; ?>">
								<input type="hidden" name="premiereCo" value="1">
								<input type="hidden" name="controller" value="donnees">
								<input type="hidden" name="action" value="goToMood">
								<input type="hidden" name="namepage" value="visualisation">
								<select name="anneeAComparer" >
									<?php
									for($nbr = 2021; $nbr <= $anneeActuelle; $nbr ++){
										if(isset($_POST['anneeAComparer'])){
											if($_POST['anneeAComparer'] == $nbr){
												?>
												<option value="<?php echo $_POST['anneeAComparer'];?>" selected><?php echo $_POST['anneeAComparer'];?></option>
												<?php
											} else {
												?>
												<option value="<?php echo $nbr;?>"><?php echo $nbr;?></option>
												<?php
											}
										} else {
											if($anneeChoisi == $nbr){
												?>
												<option value="<?php echo $anneeChoisi;?>" selected><?php echo $anneeChoisi ;?></option>
												<?php
											} else {
												?>
												<option value="<?php echo $nbr;?>"><?php echo $nbr;?></option>
												<?php
											}
										}
									}
									?>
								</select>

								<select id="humeurDigrammeBatton" name="humeurDigrammeBatton">
								<?php
									while($row = $libellesRadar->fetch()){
										if(isset($_POST['humeurDigrammeBatton']) && $_POST['humeurDigrammeBatton'] == $row['codeLibelle']){
											$humeurDigrammeBatton = $_POST['humeurDigrammeBatton'];
											echo "<option value = '".$row['codeLibelle']."' selected >".$row['libelleHumeur']." ".$row['emoji']."</option>";
										}else{
											$humeurDigrammeBatton = isset($humeurDigrammeBatton) ? $humeurDigrammeBatton: $row['codeLibelle'];
										echo "<option value = '".$row['codeLibelle']."'>".$row['libelleHumeur']." ".$row['emoji']."</option>";
										}
									}
								?>
								</select>
								<button type="submit">OK</button>
							</form>
						<div id="chartconteneur" style="height: 370px; width: 100%;"></div>
					</div>
					<div class = "col-md-6">
						<div class="enBleu">
							<span>Voici l'humeur qui est revenu le plus cette année :</span>
						</div>
					<br>
					<?php
					while($row = $humeursLaPlusFrequenteAnnee->fetch()){
						?>
						<div class="enBleu">
							<span><?php echo $row['libelle']; ?></span>
						</div>
						<span class="emojie"><?php echo $row['emoji']; ?></span>
						<?php
					}
					?>
				</div>
				<?php
			}
			if($typeDeRpresentation == 1){
				?>
				<div class="col-md-6">
					<?php
					echo '<script type="text/javascript">';
					echo "var dataCountDonught = '".implode(",", $tableauCountDonught)."'.split(',');";
					echo "var dataLibelleDonught = '".implode(",", $tableauLibelleDonught)."'.split(',');";
					echo 'console.table(dataHumeur);';
					echo '</script>';
					if($tableauCountDonught[0] == 0){
						?>
						<p>Vous n'avez pas d'humeur aujourd'hui</p>
						<?php
					} else {
						?>
						<canvas id="myChart2" class="containGraph"></canvas>
						<?php
					}
					?>
				</div>
				<div class = "col-md-6">
						<div class="enBleu">
							<span>Voici l'humeur qui est revenu le plus cette année :</span>
						</div>
					<br>
					<?php
					while($row = $humeursLaPlusFrequenteJour->fetch()){
						?>
						<div class="enBleu">
							<span><?php echo $row['libelle']; ?></span>
						</div>
						<span class="emojie"><?php echo $row['emoji']; ?></span>
						<?php
					}
					?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
	
	




        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="script/script.js"></script>
        <script src="script/scriptjs2.js"></script>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <?php
    }
    ?>
    </body>
</html>
