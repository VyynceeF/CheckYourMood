<?php


namespace services;

use PDOException;

class VisualisationService
{

    public function visualisationRadar($pdo, $idUtil, $code, $week){
        $sql="SELECT COUNT(dateHumeur), DAYOFWEEK(dateHumeur) as jour from humeur where idUtil = :id and libelle = :codeHumeur and WEEK(dateHumeur) = :date  GROUP by dateHumeur ";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('id', $idUtil);
        $searchStmt->bindParam('codeHumeur', $code);
        $searchStmt->bindParam('date', $week);
        $searchStmt->execute();
        while($dateWeek = $searchStmt->fetch()){
            $tableau[$dateWeek['jour']] = $dateWeek['COUNT(dateHumeur)'];
        }
        for ($i = 1 ; $i < 8 ; $i++) {
            $tabJour[$i] = isset($tableau[$i]) ? $tableau[$i] : 0;
        }
        return $tabJour;
    
    }

    public function visualisationTableau($pdo, $idUtil, $week){
        $sql="SELECT DAYOFWEEK(humeur.dateHumeur) as jourDeLaSemaine, libelle.libelleHumeur as libelle, libelle.emoji as emoji, humeur.dateHumeur as date, humeur.heure as heure, humeur.contexte as contexte from humeur join libelle on humeur.libelle = libelle.codeLibelle where humeur.idUtil = :id and WEEK(humeur.dateHumeur) = :date order by humeur.dateHumeur";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('id', $idUtil);
        $searchStmt->bindParam('date', $week);
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

    
    public function getCurrentWeek($pdo){
        $sql="Select week(curdate()) as week";
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