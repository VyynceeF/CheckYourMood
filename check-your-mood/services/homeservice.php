<?php


namespace services;

use PDOException;

class HomeService
{
    /**
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function connexion($pdo, $idUtil, $mdpUtil)
    {
        $mdpUtil = md5($mdpUtil);
        $sql = "SELECT codeUtil FROM utilisateur WHERE identifiant = :idUtil AND motDePasse = :mdpUtil" ;
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('idUtil', $idUtil);
        $searchStmt->bindParam('mdpUtil', $mdpUtil);
        $searchStmt->execute();

        $util = 0;

        while($row = $searchStmt->fetch()){
            $util = $row['codeUtil'];
        }
        
        return $util;
    }


    private static $defaultHomeService ;
    public static function getDefaultHomeService()
    {
        if (HomeService::$defaultHomeService == null) {
            HomeService::$defaultHomeService = new HomeService();
        }
        return HomeService::$defaultHomeService;
    }
}