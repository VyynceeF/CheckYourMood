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
var_dump($visualisationRadar);
?>

    <div class="head">
        <img src="/check-your-mood/images/CheckYourMoodLogo.png" alt="Logo Check Your Mood">
    </div>

    <div class="contain1">
        <div>
            <form action="index.php" method="post">
                <input type="hidden" name="controller" value="donnees">
                <input type="hidden" name="action" value="goToMood">
                <input type="hidden" name="namepage" value="visualisation">
                <select id="humeur" name="humeur"> 
                <?php
                    while($row = $libelles->fetch()){
                        if(isset($_POST['humeur']) && $_POST['humeur'] == $row['codeLibelle']){
                            echo "<option value = '".$row['codeLibelle']."' selected >".$row['libelleHumeur']." ".$row['emoji']."</option>";  
                        }else{
                          echo "<option value = '".$row['codeLibelle']."'>".$row['libelleHumeur']." ".$row['emoji']."</option>";  
                        }         
                    }
                ?>
                </select>
                <select name="week">
                    <?php
                    for($i = 1; $i < 54; $i++){
                        if(isset($_POST['week'])){
                            if($_POST['week'] == $i){
                                echo "<option value = '".$_POST['week']."' selected >Semaine ".$_POST['week']."</option>";
                            } else {
                                echo "<option value = '".$i."' >Semaine ".$i."</option>";
                            }
                        } else {
                            if($i == $currentWeek){
                                echo "<option value = '".$i."' selected >Semaine ".$i."</option>";
                            } else {
                                echo "<option value = '".$i."' >Semaine ".$i."</option>";
                            }
                        }
                    }
                     ?>
                </select>
                
                <button type="submit">OK</button>
                
            </form>
            
        </div>
        <div class="globalContainer">
            <div class="carreHautGauche">
                <div class="cadre">
                    <div >
                        <canvas id="myChart" class="containGraph"></canvas>
                    </div>
                </div>
            </div>
            <div class="carreHautDroit">            
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

                        while($row = $visualisationTableau->fetch()){

                            echo "<tr>";

                            echo "<td>".$row['libelle']."</td>";
                            echo "<td>".$row['emoji']."</td>";
                            echo "<td>".$row['date']."</td>";
                            echo "<td>".$row['heure']."</td>";
                            echo "<td class = 'last-column'>".$row['contexte']."</td>";

                            echo "</tr>";

                        }

                    ?>

                </table>
            </div>
            <div class="carreHautGauche">

            </div>
            <div class="carreHautGauche">

            </div>

        </div>
        
    </div>
    <?php
        echo '<script type="text/javascript">';
        echo "var dataHumeur = '".implode("<>", $visualisationRadar)."'.split('<>');"; 
        echo '</script>';
    ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="script/script.js"></script>
</body>
</html>
