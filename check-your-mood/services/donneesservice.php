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
	
	/**
	 * Permet la modification du contexte de l'humeur
	 * appartenant à l'utilisateur $util
	 */
	public function updateHumeur($pdo,$tab){
		
        try {

            $requete = "UPDATE humeur SET contexte = :contexte WHERE idUtil = :id AND codeHumeur = :codeHumeur " ;
            $sql = $pdo->prepare($requete);
            $sql->execute($tab);
			
            return true;

        } catch (PDOException $e) {
			
            return false;
        }
    }
	
	/**
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function viewMoods($pdo, $idUtil)
    {
        $sql = "SELECT h.codeHumeur, h.dateHumeur, h.heure, h.contexte, l.libelleHumeur, l.emoji, h.idUtil FROM humeur h, libelle l WHERE h.libelle = l.codeLibelle AND idUtil = :id ORDER BY h.dateHumeur DESC, h.heure DESC";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('id', $idUtil);
        $searchStmt->execute();
        return $searchStmt;
    }

    /**
     * @param $pdo \PDO the pdo object
     * @return \PDOStatement the statement referencing the result set
     */
    public function nombreHumeur($pdo, $idUtil)
    {
        $sql = "SELECT COUNT(codeHumeur) FROM humeur h WHERE idUtil = :id";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('id', $idUtil);
        $searchStmt->execute();
        return $searchStmt;
    } 
    
    /**
    * @param $pdo \PDO the pdo object
    * @return \PDOStatement the statement referencing the result set
    */
   public function donneesUser($pdo, $idUtil)
   {
       $sql = "SELECT prenom, nom, identifiant, mail FROM `utilisateur` WHERE codeUtil = :id";
       $searchStmt = $pdo->prepare($sql);
       $searchStmt->bindParam('id', $idUtil);
       $searchStmt->execute();
       return $searchStmt;
   }

    /**
     * @param $pdo \PDO the pdo object
     * @param $premier Numero de la 1ere humeur de la page
     * @param $parPage Nombre d'humeurs par page
     * @return \PDOStatement the statement referencing the result set
     */
    public function viewMoodsPagination($pdo, $idUtil, $premier, $parPage)
    {
        $sql = "SELECT h.codeHumeur, h.dateHumeur, h.heure, h.contexte, l.libelleHumeur, l.emoji, h.idUtil FROM humeur h, libelle l WHERE h.libelle = l.codeLibelle AND idUtil = :id ORDER BY h.dateHumeur DESC, h.heure DESC LIMIT :premier, :parpage;";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('id', $idUtil);
        $searchStmt->bindParam('premier', $premier);
        $searchStmt->bindParam('parpage', $parPage);
        $searchStmt->execute();
        return $searchStmt;
    }    
    
    /**
    * @param $pdo \PDO the pdo object
    * @return \PDOStatement the statement referencing the result set
    */
   public function mdp($pdo, $idUtil)
   {
       $sql = "SELECT motDePasse FROM `utilisateur` WHERE codeUtil = :id";
       $searchStmt = $pdo->prepare($sql);
       $searchStmt->bindParam('id', $idUtil);
       $searchStmt->execute();
       return $searchStmt;
   }
   
   /**
    * @param $pdo \PDO the pdo object
    * @return \PDOStatement the statement referencing the result set
    */
    public function updateMDP($pdo, $idUtil, $nouveauMDP)
    {
        $sql = "UPDATE `utilisateur` SET motDePasse=:nouveauMDP WHERE codeUtil = :id";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('id', $idUtil);
        $searchStmt->bindParam('nouveauMDP', $nouveauMDP);
        $searchStmt->execute();
        return $searchStmt;
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