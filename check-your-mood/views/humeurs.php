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

<?php
spl_autoload_extensions(".php");
spl_autoload_register();

use yasmf\HttpHelper;
?>

    <div class="head">
        <img src="/check-your-mood/images/CheckYourMoodLogo.png" alt="Logo Check Your Mood">
        <a href="/check-your-mood?controller=Donnees&action=goToMood&namepage=modification&namepage=modification"><img src="/check-your-mood/images/compte.png" alt="Logo Du Compte" class="LogoDuCompte"></a><!--Relier le bouton à la nouvelle vue--> 
    </div>

    <div class="contain">
        <div class="menu-right"></div>
        <div class="contain-mood">

            <div class="head-mood">
                <p>Humeurs</p>
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

                <form action = "index.php" method="post">
                    <tr>
                        <input type="hidden" name="controller" value="Mood">
                        <td colspan="4">
                            <select name="humeur">
                                <?php 
                                while($row = $libelles->fetch()){
                                    echo "<option value = '".$row['codeLibelle']."'>".$row['libelleHumeur']." ".$row['emoji']."</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td class="last-column"><input type="text" name="contexte" placeholder="Contexte..."></td>
                        <td class="column-button"><button type="submit">+</button></td>

                    <tr>
                <form>

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