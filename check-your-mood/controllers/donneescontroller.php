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

        $anneeAComparer = (int) HttpHelper::getParam('anneeChoisi') ?: 2023; 
        $typeDeRpresentation = (int) HttpHelper::getParam('typeDeRpresentation') ?: 1;
        $namepage = htmlspecialchars(HttpHelper::getParam('namepage'));
        $requeteCurrentWeek = $this->visualisationService->getCurrentWeek($pdo);
        while($row = $requeteCurrentWeek->fetch()){
            $currentWeek = $row['week'];
        }
        $weekGeneral = (int) htmlspecialchars(HttpHelper::getParam('weekGeneral')) ?: $currentWeek;

		
		
		$requeteCurrentDay = $this->visualisationService->getCurrentDay($pdo);
		while($row = $requeteCurrentDay->fetch()){
            $currentDay = $row['day'];
        }
        $dateDonught = htmlspecialchars(HttpHelper::getParam('dateChoisiDonught')) ?: $currentDay;
		
		
        while($row = $requeteCurrentWeek->fetch()){
            $currentWeek = $row['weekTableau'];
        }
        
        $idUtil = $_SESSION['util'];
        $code = (int) HttpHelper::getParam('humeur') ?: 1; 
		$codeDigrammeBatton = (int) HttpHelper::getParam('humeurDigrammeBatton') ?: 1;

        $requeteAnneeActuelle = $this->visualisationService->getCurrentYear($pdo);
        while($row = $requeteAnneeActuelle->fetch()){
            $anneeActuelle = $row['year'];
        }
        $anneeComparaison = (int) htmlspecialchars(HttpHelper::getParam('anneeAComparer')) ?: $anneeActuelle;

        $tabAnneeActuelle = $this->visualisationService->visualisationHumeurAnnee($pdo, $idUtil, $anneeAComparer,$codeDigrammeBatton);
        $tabAnneeComparaison = $this->visualisationService->visualisationHumeurAnnee($pdo, $idUtil, $anneeComparaison,$codeDigrammeBatton);

		$anneHumeurMax = (int) htmlspecialchars(HttpHelper::getParam('anneeAComparerHumeur')) ?: $anneeActuelle;
        
        $humeursRadar = $this->MoodService->viewMoods($pdo,$_SESSION['util']);
        $libellesRadar = $this->MoodService->libelles($pdo);
        $libellesTableau = $this->MoodService->libelles($pdo);
        $visualisationRadar = $this->visualisationService->visualisationRadar($pdo, $idUtil, $code, $weekGeneral, $anneeAComparer);
        $visualisationTableau = $this->visualisationService->visualisationTableau($pdo, $idUtil, $weekGeneral, $anneeAComparer);
        $visualisationDonught = $this->visualisationService->visualisationDoughnut($pdo, $idUtil, $dateDonught);

        foreach($visualisationDonught as $key => $value){
            $tableauLibelleDonught[] = $key; 
            $tableauCountDonught[] = $value; 
        }
        $humeursLaPlusFrequente = $this->visualisationService->visualisationHumeurSemaine($pdo, $idUtil, $weekGeneral);
		$humeursLaPlusFrequenteAnnee = $this->visualisationService->visualisationHumeurAnneeLaPlus($pdo, $idUtil, $anneeAComparer);
		$humeursLaPlusFrequenteJour = $this->visualisationService->visualisationHumeurJour($pdo, $idUtil, $dateDonught);
        

        $view = new View("check-your-mood/views/".$namepage);
        $view->setVar('humeursRadar',$humeursRadar);
        $view->setVar('libellesRadar',$libellesRadar);
        $view->setVar('libellesTableau',$libellesTableau);
        $view->setVar('currentWeek',$currentWeek);
        $view->setVar('visualisationRadar',$visualisationRadar);
        $view->setVar('visualisationTableau',$visualisationTableau);
        $view->setVar('visualisationDonught',$visualisationDonught);
        $view->setVar('humeursLaPlusFrequente',$humeursLaPlusFrequente);
		$view->setVar('humeursLaPlusFrequenteAnnee',$humeursLaPlusFrequenteAnnee);
        $view->setVar('dataPoints2',$tabAnneeComparaison);
        $view->setVar('dataPoints1',$tabAnneeActuelle);
        $view->setVar('anneeActuelle',$anneeActuelle);
		$view->setVar('currentDay',$currentDay);
        $view->setVar('anneeComparaison',$anneeComparaison);
        $view->setVar('anneeChoisi',$anneeAComparer);
        $view->setVar('weekGeneral',$weekGeneral);
        $view->setVar('typeDeRpresentation',$typeDeRpresentation);
		$view->setVar('codeDigrammeBatton',$codeDigrammeBatton);
		$view->setVar('dateDonught',$dateDonught);
        $view->setVar('tableauLibelleDonught',$tableauLibelleDonught);
        $view->setVar('tableauCountDonught',$tableauCountDonught);
		$view->setVar('humeursLaPlusFrequenteJour',$humeursLaPlusFrequenteJour);

        
        
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
