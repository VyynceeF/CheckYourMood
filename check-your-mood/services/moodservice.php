<?php


namespace services;

use PDOException;

class MoodService
{
    /**
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function viewMoods($pdo, $idUtil)
    {
        $sql = "SELECT h.dateHumeur, h.heure, h.contexte, l.libelleHumeur, l.emoji, h.idUtil FROM humeur h, libelle l WHERE h.libelle = l.codeLibelle AND idUtil = :id ORDER BY h.dateHumeur DESC, h.heure DESC";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('id', $idUtil);
        $searchStmt->execute();
        return $searchStmt;
    }

    public function libelles($pdo){
        $sql = "SELECT codeLibelle, libelleHumeur, emoji FROM Libelle ORDER BY libelleHumeur";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->execute();
        return $searchStmt;
    }

    public function insertMood($pdo, $codeL, $contexte, $util){

        try{

            date_default_timezone_set('Europe/Paris');
            $date = date('y-m-d');
            $heure = date('h:i:s');

            $sql = "INSERT INTO humeur(libelle,dateHumeur,heure,idUtil,contexte) VALUES(:libelle,:dateA,:heure,:id,:contexte)";
            $searchStmt = $pdo->prepare($sql);
            $searchStmt->bindParam('id', $util);
            $searchStmt->bindParam('libelle', $codeL);
            $searchStmt->bindParam('contexte', $contexte);
            $searchStmt->bindParam('dateA', $date);
            $searchStmt->bindParam('heure', $heure);
            $searchStmt->execute();

            return "ok";
        }catch(Exception $e){
            return "nOk";
        }
        
    }


    private static $defaultMoodService;
    public static function getDefaultMoodService()
    {
        if (MoodService::$defaultMoodService == null) {
            MoodService::$defaultMoodService = new MoodService();
        }
        return MoodService::$defaultMoodService;
    }
}