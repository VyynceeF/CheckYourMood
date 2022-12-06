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
        //TODO Modifier pour adapter pour chaque util
        $sql = "SELECT h.dateHumeur, h.heure, h.contexte, l.libelleHumeur, l.emoji, h.idUtil FROM humeur h, libelle l WHERE h.libelle = l.codeLibelle AND idUtil = :id";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('id', $idUtil);
        $searchStmt->execute();
        return $searchStmt;
    }


    private static $defaultMoodService ;
    public static function getDefaultMoodService()
    {
        if (MoodService::$defaultMoodService == null) {
            MoodService::$defaultMoodService = new MoodService();
        }
        return MoodService::$defaultMoodService;
    }
}