<?php
namespace controllers;

use services\DonneesService;
use services\MoodService;
use yasmf\HttpHelper;
use yasmf\View;
use services\VisualisationService;


class DonneesController {

    private $DonneesService;
    private $MoodService;
    private $visualisationService;

    public function __construct()
    {
        $this->DonneesService = DonneesService::getDefaultDonneesService();
        $this->MoodService = MoodService::getDefaultMoodService(); 
        $this->visualisationService = VisualisationService::getDefaultVisualisationService();
    }

    //TODO : Etablir l'utilité -> Potentiellement separer en plusieur fonction et resitué dans le bon controller
    public function goToMood($pdo){
        
        $namepage = htmlspecialchars(HttpHelper::getParam('namepage'));
        $requeteCurrentWeek = $this->visualisationService->getCurrentWeek($pdo);
        while($row = $requeteCurrentWeek->fetch()){
            $currentWeek = $row['week'];
        }
        $week = (int) htmlspecialchars(HttpHelper::getParam('week')) ?: $currentWeek;

        while($row = $requeteCurrentWeek->fetch()){
            $currentWeek = $row['weekTableau'];
        }
        $weekTableau = (int) htmlspecialchars(HttpHelper::getParam('weekTableau')) ?: $currentWeek;
        $idUtil = $_SESSION['util'];
        $code = (int) HttpHelper::getParam('humeur') ?: 1;

        $requeteAnneeActuelle = $this->visualisationService->getCurrentYear($pdo);
        while($row = $requeteAnneeActuelle->fetch()){
            $anneeActuelle = $row['year'];
        }
        $anneeComparaison = (int) htmlspecialchars(HttpHelper::getParam('anneeAComparer')) ?: $anneeActuelle;

        $tabAnneeActuelle = $this->visualisationService->visualisationHumeurAnnee($pdo, $idUtil, $anneeActuelle,$code);
        $tabAnneeComparaison = $this->visualisationService->visualisationHumeurAnnee($pdo, $idUtil, $anneeComparaison,$code);


        
        $humeursRadar = $this->MoodService->viewMoods($pdo,$_SESSION['util']);
        $libellesRadar = $this->MoodService->libelles($pdo);
        $libellesTableau = $this->MoodService->libelles($pdo);
        $visualisationRadar = $this->visualisationService->visualisationRadar($pdo, $idUtil, $code, $week);
        $visualisationTableau = $this->visualisationService->visualisationTableau($pdo, $idUtil, $weekTableau);
        $humeursLaPlusFrequente = $this->visualisationService->visualisationHumeurSemaine($pdo, $idUtil, $weekTableau);


        $view = new View("check-your-mood/views/".$namepage);
        $view->setVar('humeursRadar',$humeursRadar);
        $view->setVar('libellesRadar',$libellesRadar);
        $view->setVar('libellesTableau',$libellesTableau);
        $view->setVar('currentWeek',$currentWeek);
        $view->setVar('visualisationRadar',$visualisationRadar);
        $view->setVar('visualisationTableau',$visualisationTableau);
        $view->setVar('humeursLaPlusFrequente',$humeursLaPlusFrequente);
        $view->setVar('dataPoints2',$tabAnneeComparaison);
        $view->setVar('dataPoints1',$tabAnneeActuelle);
        $view->setVar('anneeActuelle',$anneeActuelle);
        $view->setVar('anneeComparaison',$anneeComparaison);
        $view->setVar('weekTableau',$weekTableau);
        
        
        return $view;
    }


    //TODO : Modification des données personnelles
    public function updateData($pdo){
        $tab['identifiant'] = htmlspecialchars(HttpHelper::getParam('identifiant'));
        $tab['nom'] = htmlspecialchars(HttpHelper::getParam('nom'));
        $tab['prenom'] = htmlspecialchars(HttpHelper::getParam('prenom'));
        $mdp = htmlspecialchars(HttpHelper::getParam('motdepasse'));
        $tab['motDePasse'] = md5($mdp);
        $tab['mail'] = htmlspecialchars(HttpHelper::getParam('mail'));
        $util = $_SESSION['util'];

        $updateNo = true;

        foreach($tab as $key => $value){
            if($value == ""){
                $updateNo = false;
            }
        }

        if($updateNo){$donnees = $this->DonneesService->updateData($pdo,$tab,$util);}else{$donnees = "nOk";}
		
		$view = new View("check-your-mood/views/modification");
        if($donnees == "nOk"){
			$view->setVar('updateOk',1); 
		}else{
           $view->setVar('updateOk',2);
           $_SESSION['id'] = $tab['identifiant'];
           $_SESSION['mdp'] = $mdp;
           $_SESSION['nom'] = $tab['nom'];
           $_SESSION['prenom'] = $tab['prenom'];
           $_SESSION['mail'] = $tab['mail'];
        }
		return $view;
    }

}
