<?php


namespace services;

use PDOException;

class DonneesService
{
    
    //TODO : Finir la modif des données
    public function updateData($pdo,$tab,$util){
        
        $setter = "";
        $tabExec = [];
		
        foreach($tab as $cle => $value){
            if($value != ""){
                if($setter == ""){
                    $setter .= " SET ";
                }else{
                    $setter .= " , ";
                }
                $setter .= " ".$cle." = :".$cle." ";
                $tabExec[$cle]=$value;
            }
            
        }
        $setter .= "  where codeUtil = :util ";
        $tabExec['util'] = $util;


        try{

            $requete = "UPDATE utilisateur ".$setter ;
            $sql = $pdo->prepare($requete);
            $sql->execute($tabExec);
            return "ok";

        }catch(PDOException $e){
            echo $e->getMessage();
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