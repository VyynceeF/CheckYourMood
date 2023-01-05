<?php


namespace services;

use PDOException;

class VisualisationService
{

    public function visualisationRadar($pdo, $idUtil, $code, $week, $anneeAComparer){
        $sql="SELECT COUNT(dateHumeur), DAYOFWEEK(dateHumeur) as jour from humeur where idUtil = :id and libelle = :codeHumeur and WEEK(dateHumeur) = :date and YEAR( dateHumeur ) = :year GROUP by dateHumeur ";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('id', $idUtil);
        $searchStmt->bindParam('codeHumeur', $code);
        $searchStmt->bindParam('date', $week);
        $searchStmt->bindParam('year', $anneeAComparer);
        $searchStmt->execute();
        while($dateWeek = $searchStmt->fetch()){
            $tableau[$dateWeek['jour']] = $dateWeek['COUNT(dateHumeur)'];
        }
        for ($i = 1 ; $i < 8 ; $i++) {
            $tabJour[$i] = isset($tableau[$i]) ? $tableau[$i] : 0;
        }
        return $tabJour;
    
    }
	
	public function visualisationDoughnut($pdo, $idUtil, $date){
        $sql="SELECT COUNT(*) as nombreHumeur, libelleHumeur as libelle FROM humeur JOIN libelle ON humeur.libelle = libelle.codeLibelle WHERE idUtil = :id and dateHumeur = :date GROUP BY libelleHumeur";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('id', $idUtil);
        $searchStmt->bindParam('date', $date);
        $searchStmt->execute();

        if ($searchStmt ->rowCount() == 0) {
            $tableauDoughnut[] = null; 
        }  
        while($countLibelle = $searchStmt->fetch()){
            $tableauDoughnut[$countLibelle['libelle']] = $countLibelle['nombreHumeur'];
        }
        return $tableauDoughnut;
    
    }

    public function visualisationTableau($pdo, $idUtil, $week, $anneeAComparer){
        $sql="SELECT DAYOFWEEK(humeur.dateHumeur) as jourDeLaSemaine, libelle.libelleHumeur as libelle, libelle.emoji as emoji, humeur.dateHumeur as date, humeur.heure as heure, humeur.contexte as contexte from humeur join libelle on humeur.libelle = libelle.codeLibelle where humeur.idUtil = :id and WEEK(humeur.dateHumeur) = :date and YEAR( dateHumeur ) = :year order by humeur.dateHumeur";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('id', $idUtil);
        $searchStmt->bindParam('date', $week);
        $searchStmt->bindParam('year', $anneeAComparer);
        $searchStmt->execute();
        return $searchStmt;
    
    }

    public function visualisationHumeurSemaine($pdo, $idUtil, $week){
        $sql="SELECT libelle.libelleHumeur as libelle, libelle.emoji  as emoji FROM humeur join libelle on libelle.codeLibelle = humeur.libelle where humeur.idUtil = :id  and week(dateHumeur) = :date GROUP BY libelle ORDER BY COUNT(libelle) DESC LIMIT 1";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('id', $idUtil);
        $searchStmt->bindParam('date', $week);
        $searchStmt->execute();
        return $searchStmt;
    
    }


    public function visualisationHumeurAnnee($pdo, $idUtil, $annee, $libelle){
        $tableauAnnee=array();
        $tabMois = array( 1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août', 9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre');
        for($mois = 1 ; $mois <= 12; $mois ++){
            $sql="SELECT count(libelle) as nbrHumeurs from humeur where libelle = :libelle and humeur.idUtil = :id and YEAR(dateHumeur) = :annee and month(dateHumeur) = :mois";
            $searchStmt = $pdo->prepare($sql);
            $searchStmt->bindParam('id', $idUtil);
            $searchStmt->bindParam('libelle', $libelle);
            $searchStmt->bindParam('annee', $annee);
            $searchStmt->bindParam('mois', $mois);
            $searchStmt->execute();
            while($row = $searchStmt->fetch()){
                $resultat = $row['nbrHumeurs'];
            }
            array_push($tableauAnnee,array("label"=> $tabMois[$mois], "y"=> $resultat));
        }
        return $tableauAnnee;
    }
	
	public function getCurrentDay($pdo){
		$sql="Select curdate() as day ";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->execute();
        return $searchStmt;
	}

    
    public function getCurrentWeek($pdo){
        $sql="Select week(curdate()) as week ";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->execute();
        return $searchStmt;
    }


    public function getCurrentYear($pdo){
        $sql="Select Year(curdate()) as year";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->execute();
        return $searchStmt;
    }
    

    private static $defaultVisualisationService ;
    public static function getDefaultVisualisationService()
    {
        if (VisualisationService::$defaultVisualisationService == null) {
            VisualisationService::$defaultVisualisationService = new VisualisationService();
        }
        return VisualisationService::$defaultVisualisationService;
    }
}