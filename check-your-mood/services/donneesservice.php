<?php


namespace services;

use PDOException;

class DonneesService
{
    
    public function updateData($pdo,$tab,$util){
        
        $setter = "";
        $tabExec = [];
		
        foreach($tab as $value => $cle){
            if($value != ""){
                if($setter == ""){
                    $setter .= " SET ";
                }else{
                    $setter .= " and ";
                }
                $setter .= " ".$cle." = :nom ";
                $tabExec[$cle]=$value;
            }
            
        }
        $setter .= " where codeUtil = :util ";


        try{

            $requete = "UPDATE utilisateur ".$setter ;
            $sql = $pdo->prepare($requete);
            $sql->execute($tabExec);
            return "ok";

        }catch(PDOException $e){
            return "nOk";
        }

    }


    private static $defaultDonneesService ;
    public static function getDefaultDonneesService()
    {
        if (DonneesService::$defaultDonneesService == null) {
            DonneesService::$defaultDonneesService = new DonneesService();
        }
        return DonneesService::$defaultDonneesService;
    }
}