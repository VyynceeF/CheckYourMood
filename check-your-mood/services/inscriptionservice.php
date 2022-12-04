<?php


namespace services;

use PDOException;

class InscriptionService
{
    /**
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function Inscription($pdo, $idUtil, $mdpUtil)
    {
        $sql = "SELECT codeUtil FROM utilisateur WHERE identifiant = :idUtil AND motDePasse = :mdpUtil" ;
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('idUtil', $idUtil);
        $searchStmt->bindParam('mdpUtil', $mdpUtil);
        $searchStmt->execute();
        
        return $searchStmt;
    }


    private static $defaultInscriptionService ;
    public static function getDefaultInscriptionService()
    {
        if (InscriptionService::$defaultInscriptionService == null) {
            InscriptionService::$defaultInscriptionService = new InscriptionService();
        }
        return InscriptionService::$defaultInscriptionService;
    }
}