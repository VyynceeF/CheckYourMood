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
        <div class="menu-right">
          <a href="/check-your-mood?controller=donnees&action=goToMood&namepage=visualisation">visualisation</a>
        </div>
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
                <div id="popupForm">
                <form action = "index.php" method="post">
                    <input type="hidden" name="controller" value="Mood">
                    <input type="hidden" name="codeUtil" value="<?php echo $_SESSION['util']; ?>">
                    <p class="sansBordure">Création humeur</p>
                    <div class="ajoutHumeurForm">
                        <!-- Libellé de l'humeur -->
                        <select name="humeur">
                            <?php
                            while($row = $libelles->fetch()){
                                echo "<option value = '".$row['codeLibelle']."'>".$row['libelleHumeur']." ".$row['emoji']."</option>";
                            }
                            ?>
                        </select>
                        <!-- Date de l'humeur -->
                        <input type="date" name="dateHumeur" required />
                        <!-- Heure de l'humeur -->
                        <input type="time" name="heure" required />
                        <!-- Contexte de l'humeur -->
                        <input type="text" name="contexte" placeholder="Contexte...">
                    </div
                    <!-- Boutons d'ajout et d'annulation de l'humeur -->
                    <div class="btnNav">
                        <button type="submit" class="btn">Ajouter</button><br />
                        <button type="submit" class="lien" onclick="closeForm()">Annuler</button>
                    </div>
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
            <div class="affichage">
              <canvas id="myChart"></canvas>
            </div>
        </div>
      </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="script/script.js"></script>
</body>
</html>
