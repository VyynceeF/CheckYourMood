<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Your Mood - Humeurs</title>
    <link rel="stylesheet" href="/check-your-mood/css/style.css">
</head>
<body>

	<script>
	function openForm() {
		document.getElementById("popupForm").style.display = "block";
	}
	function closeForm() {
		document.getElementById("popupForm").style.display = "none";
	}
	</script>

<?php
spl_autoload_extensions(".php");
spl_autoload_register();

use yasmf\HttpHelper;

?>

    <div class="head">
        <img src="/check-your-mood/images/CheckYourMoodLogo.png" alt="Logo Check Your Mood">
    </div>

    <div class="contain">
        <div class="menu-right"></div>
        <div class="contain-mood">

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
				<div class="form-popup" id="popupForm">
				  <form action = "index.php" method="post">
					<input type="hidden" name="controller" value="Mood">
					<input type="hidden" name="codeUtil" value="<?php echo $util; ?>">
					<h2>Veuillez vous rentrer votre humeur</h2>
					<!-- Libellé de l'humeur -->
					<label for="humeur">Libellé</label>
					<select name="humeur">
						<?php 
						while($row = $libelles->fetch()){
							echo "<option value = '".$row['codeLibelle']."'>".$row['libelleHumeur']." ".$row['emoji']."</option>";
						}
						?>
					</select><br />
					<!-- Date de l'humeur -->
					<label for="dateHumeur">Date</label>
					<input type="date" name="dateHumeur" required /><br />
					<!-- Heure de l'humeur -->
					<label for="heure">Heure</label>
					<input type="time" name="heure" required /><br />
					<!-- Contexte de l'humeur -->
					<label for="contexte">Contexte</label>
					<input type="text" name="contexte" placeholder="Contexte..."><br />
					<!-- Boutons d'ajout et d'annulation de l'humeur -->
					<button type="submit" class="btn">Ajouter</button><br />
					<button type="submit" class="btn cancel" onclick="closeForm()">Annuler</button><br />
				  </form>
				</div>
            </div>
            

            <table class="table-mood">
                <tr>
                    <th>
                        Libelle
                    </th>
                    <th>
                        Emoji
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Heure
                    </th>
                    <th class="last-column">
                        Contexte
                    </th>
                </tr>

                <?php 
                
                    while($row = $humeurs->fetch()){

                        echo "<tr>";

                        echo "<td>".$row['libelleHumeur']."</td>";
                        echo "<td>".$row['emoji']."</td>";
                        echo "<td>".$row['dateHumeur']."</td>";
                        echo "<td>".$row['heure']."</td>";
                        echo "<td class = 'last-column'>".$row['contexte']."</td>";
            
                        echo "</tr>";  

                    }

                ?>

            </table>

        </div>
    </div>
    
</body>
</html>