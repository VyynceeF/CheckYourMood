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
    </div>

    <div class="contain">
        <div class="menu-right"></div>
        <div class="contain-mood">

            <div class="head-mood">
                <p>Humeurs</p>
                <button>+</button>
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
                
                    while($row = $searchStmt->fetch()){

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