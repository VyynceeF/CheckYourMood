<?php


namespace services;

use PDOException;

class InscriptionService
{
    /**
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function inscription($pdo, $id, $mdp, $mail, $nom, $prenom)
    {
        try{

            $searchStmt = $pdo->prepare("INSERT INTO utilisateur(prenom,nom,identifiant,mail,motdePasse) VALUES(:prenom,:nom,:id,:mail,:mdp)" );
            $searchStmt->bindParam('id', $id);
            $searchStmt->bindParam('mdp', $mdp);
            $searchStmt->bindParam('mail', $mail);
            $searchStmt->bindParam('nom', $nom);
            $searchStmt->bindParam('prenom', $prenom);
            $searchStmt->execute();

            return "ok";

        }catch(PDOException $e){
            return "nOk";
        }
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