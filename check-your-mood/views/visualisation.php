<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Your Mood - Humeurs</title>
    <link rel="stylesheet" href="/check-your-mood/css/style.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">

    <?php
    //var_dump($typeDeRpresentation);
    // var_dump($anneeActuelle);
    $ChoixTypeDeRepresentation = ['Choissez votre représentation','Jour','Semaine','Mois','Année']
    ?>
    
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
        <!-- lien pour aller sur la page des humeurs : (ne marche pas pour l'instant) -->
        <a href="/check-your-mood?controller=Mood&action=index">Humeurs</a> 
    </div>

    <form action="index.php" method="post">
        <input type="hidden" name="controller" value="donnees">
        <input type="hidden" name="anneeAComparer" value="<?php echo $anneeAComparerGraph; ?>">
        <input type="hidden" name="week" value="<?php echo $week; ?>">
        <input type="hidden" name="weekTableau" value="<?php echo $weekTableau; ?>">
        <input type="hidden" name="anneeAComparer" value="<?php echo $anneeAComparerGraph; ?>">
        <input type="hidden" name="action" value="goToMood">
        <input type="hidden" name="namepage" value="visualisation">
        <select name="anneeChoisi" > 
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
        <select name="typeDeRpresentation" > 
            <?php
            for($nbr = 1; $nbr <= 4; $nbr ++){
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
        <input type="submit" value ="valider">
    </form>


    <div>
        <!-- ligne du haut -->
        <div class="row">
            <!-- carre du haut a gauche -->
            <?php
            if($typeDeRpresentation == 2){
                ?>
                <div class="col-md-6">
                    <!-- partie du formulaire pour faire le graphe radar -->
                    <form action="index.php" method="post">
                        <input type="hidden" name="anneeChoisi" value="<?php echo $anneeChoisi; ?>">
                        <input type="hidden" name="typeDeRpresentation" value="<?php echo $typeDeRpresentation; ?>">
                        <input type="hidden" name="anneeAComparer" value="<?php echo $anneeAComparerGraph; ?>">
                        <input type="hidden" name="controller" value="donnees">
                        <input type="hidden" name="action" value="goToMood">
                        <input type="hidden" name="namepage" value="visualisation">
                        <input type="hidden" name="weekTableau" value="<?php echo $weekTableau; ?>">
                        <!-- Formulaire pour le graphe radar-->
                        <select id="humeur" name="humeur"> 
                        <?php
                            /* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! */
                            /* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! */
                            /* mettre un selected qui fonctionne parce que sah j y arrive pas et j ai pas envi */
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
                            if($anneeActuelle == $anneeChoisi){
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
                            } else {
                                for($i = 1; $i <= 52 ; $i++){
                                    if($_POST['week'] == $i){
                                        $semaineRadar = $_POST['week'];
                                        echo "<option value = '".$_POST['week']."' selected >Semaine ".$_POST['week']."</option>";
                                    } else {
                                        echo "<option value = '".$i."' >Semaine ".$i."</option>";
                                    }
                                }
                            }
                            
                            ?>
                        </select>
                        <button type="submit">OK</button>                    
                    </form>
                    <!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!  -->
                    <!-- fin de la partie du formulaire pour le graphe radar  -->

                    <!-- affichage du graphe radar --> 
                
                        <canvas id="myChart" class="containGraph"></canvas>
                </div>
                <?php
            }
            ?>

            <?php
            if($typeDeRpresentation == 2){
                ?>
                <!-- carré du haut à droite -->
                <div class="col-md-6">
                    <!-- Formulaire choix semaine pour le tableau des humeurs-->  
                    <form action="index.php" method="post">
                        <?php
                        if($typeDeRpresentation == 2){
                            ?>
                            <input type="hidden" name="humeur" value="<?php echo $humeurRadar; ?>">
                            <?php
                        }
                        ?>
                        <input type="hidden" name="week" value="<?php echo $week; ?>">
                        <input type="hidden" name="weekTableau" value="<?php echo $weekTableau; ?>">
                        <input type="hidden" name="anneeChoisi" value="<?php echo $anneeChoisi; ?>">
                        <input type="hidden" name="typeDeRpresentation" value="<?php echo $typeDeRpresentation; ?>">
                        <input type="hidden" name="anneeAComparer" value="<?php echo $anneeAComparerGraph; ?>">
                        <input type="hidden" name="controller" value="donnees">
                        <input type="hidden" name="action" value="goToMood">
                        <input type="hidden" name="namepage" value="visualisation">
                        
                        <select name="weekTableau">
                            <?php
                            if($anneeActuelle == $anneeChoisi){
                                for($i = 1; $i <= $currentWeek ; $i++){
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
                            } else {
                                for($i = 1; $i <= 52 ; $i++){
                                    if($_POST['weekTableau'] == $i){
                                        $semaineRadar = $_POST['weekTableau'];
                                        echo "<option value = '".$_POST['weekTableau']."' selected >Semaine ".$_POST['weekTableau']."</option>";
                                    } else {
                                        echo "<option value = '".$i."' >Semaine ".$i."</option>";
                                    }
                                }
                            }
                            ?>
                        </select>
                        <button type="submit">OK</button>
                    </form>

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
            <?php
        }
        ?>

        <!-- ligne du bas -->
        <div class="row">
            <!-- carre du bas a gauche -->
            <div class="col-md-6">
                <?php
                    while($row = $humeursLaPlusFrequente->fetch()){
                        echo "<span>".$row['libelle']."</span>";
                        echo "<span>".$row['emoji']."</span>";
                    }
                ?>
            </div>
                
            <!-- carré du bas à droite -->
            <div class="col-md-6">
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
                    <?php
                        if($typeDeRpresentation == 2){
                            ?>
                            <input type="hidden" name="humeur" value="<?php echo $humeurRadar; ?>">
                            <?php
                        }
                        ?>
                        <input type="hidden" name="weekTableau" value="<?php echo $weekTableau; ?>">
                        <input type="hidden" name="anneeChoisi" value="<?php echo $anneeChoisi; ?>">
                        <input type="hidden" name="anneeAComparer" value="<?php echo $anneeAComparerGraph; ?>">
                        <input type="hidden" name="week" value="<?php echo $week; ?>">
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
                        <button type="submit">OK</button>
                    </form>
                <div id="chartconteneur" style="height: 370px; width: 100%;"></div>
            </div>
        </div>
    </div>




  
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>  
    </body>
</html>
