<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Your Mood - Humeurs</title>
    <link rel="stylesheet" href="/check-your-mood/css/style.css">

    <?php
    var_dump($anneeComparaison);
    var_dump($anneeActuelle);
    ?>
    <script>
        window.onload = function () {
    
        var chart = new CanvasJS.Chart("chartContainer", {
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
                name: <?php echo '"'.$anneeActuelle.'"';?>,
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

$day = [2 => 'Lundi',3 => 'Mardi',4 => 'Mercredi',5 => 'Jeudi',6 => 'Vendredi',7 => 'Samedi',1 => 'Dimanche'];

use yasmf\HttpHelper;
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
                <input type="hidden" name="weekTableau" value="<?php echo $weekTableau; ?>">
                <!-- Formulaire pour le graphe radar-->
                <select id="humeur" name="humeur"> 
                <?php
                    while($row = $libellesRadar->fetch()){
                        if(isset($_POST['humeurRadar']) && $_POST['humeurRadar'] == $row['codeLibelle']){
                            $humeurRadar = $_POST['humeurRadar'];
                            echo "<option value = '".$row['codeLibelle']."' selected >".$row['libelleHumeur']." ".$row['emoji']."</option>";  
                        }else{
                            $humeurRadar = isset($humeurRadar) ? $humeurRadar: $row['codeLibelle'];
                          echo "<option value = '".$row['codeLibelle']."'>".$row['libelleHumeur']." ".$row['emoji']."</option>";  
                        }         
                    }
                ?>
                </select>
                <select name="week">
                    <?php
                    for($i = 1; $i <= $currentWeek ; $i++){
                        if(isset($_POST['week'])){
                            if($_POST['week'] == $i){
                                $semaineRadar = $_POST['week'];
                                echo "<option value = '".$_POST['week']."' selected >Semaine ".$_POST['week']."</option>";
                            } else {
                                echo "<option value = '".$i."' >Semaine ".$i."</option>";
                            }
                        } else {
                            if($i == $currentWeek){
                                $semaineRadar = $i;
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
                <!-- Formulaire pour le tableau-->  
                <form action="index.php" method="post">
                    <input type="hidden" name="humeur" value="<?php echo $humeurRadar; ?>">
                    <input type="hidden" name="week" value="<?php echo $semaineRadar; ?>">
                    <input type="hidden" name="controller" value="donnees">
                    <input type="hidden" name="action" value="goToMood">
                    <input type="hidden" name="namepage" value="visualisation">
                    
                    <select name="weekTableau">
                        <?php
                        for($i = 1; $i <= $currentWeek; $i++){
                            if(isset($_POST['weekTableau'])){
                                if($_POST['weekTableau'] == $i){
                                    $weekTableau = $_POST['weekTableau'];
                                    echo "<option value = '".$_POST['weekTableau']."' selected >Semaine ".$_POST['weekTableau']."</option>";
                                } else {
                                    echo "<option value = '".$i."' >Semaine ".$i."</option>";
                                }
                            } else {
                                if($i == $currentWeek){
                                    $weekTableau = $i;
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
            <div class="carreBasGauche">
                <?php
                while($row = $humeursLaPlusFrequente->fetch()){
                    echo "<span>".$row['libelle']."</span>";
                    echo "<span>".$row['emoji']."</span>";
                }
                ?>
            </div>
            <div class="carreHautGauche">

            </div>

        </div>
        
    </div>
    <?php
        echo '<script type="text/javascript">';
        echo "var dataHumeur = '".implode(",", $visualisationRadar)."'.split(',');"; 
        echo 'console.table(dataHumeur);';
        echo '</script>';
        ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="script/script.js"></script>

    <span>Choisissez l'annee à comparer</span>
    <form action="index.php" method="post">
        <input type="hidden" name="humeur" value="<?php echo $humeurRadar; ?>">
        <input type="hidden" name="week" value="<?php echo $semaineRadar; ?>">
        <input type="hidden" name="weekTableau" value="<?php echo $weekTableau; ?>">
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
        <button type="submit">OK</button>
    </form>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>  
    </body>
</html>
