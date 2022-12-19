<?php
namespace controllers;

use services\DonneesService;
use services\MoodService;
use yasmf\HttpHelper;
use yasmf\View;
use services\VisualisationService;

session_start();

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

    public function goToMood($pdo){
        
        $namepage = htmlspecialchars(HttpHelper::getParam('namepage'));
        $requeteCurrentWeek = $this->visualisationService->getCurrentWeek($pdo);
        while($row = $requeteCurrentWeek->fetch()){
            $currentWeek = $row['week'];
        }
        $week = (int) htmlspecialchars(HttpHelper::getParam('week')) ?: $currentWeek;
        $idUtil = $_SESSION['util'];
        $code = (int) HttpHelper::getParam('humeur') ?: 1;
        
        $humeurs = $this->MoodService->viewMoods($pdo,$_SESSION['util']);
        $libelles = $this->MoodService->libelles($pdo);
        $visualisationRadar = $this->visualisationService->visualisationRadar($pdo, $idUtil, $code, $week);
        $visualisationTableau = $this->visualisationService->visualisationTableau($pdo, $idUtil, $code, $week);


        $view = new View("check-your-mood/views/".$namepage);
        $view->setVar('humeurs',$humeurs);
        $view->setVar('libelles',$libelles);
        $view->setVar('currentWeek',$currentWeek);
        $view->setVar('visualisationRadar',$visualisationRadar);
        $view->setVar('visualisationTableau',$visualisationTableau);
        return $view;
    }

    public function updateData($pdo){
        $tab['id'] = htmlspecialchars(HttpHelper::getParam('identifiant'));
        $tab['nom'] = htmlspecialchars(HttpHelper::getParam('nom'));
        $tab['prenom'] = htmlspecialchars(HttpHelper::getParam('prenom'));
        $tab['motDePasse'] = htmlspecialchars(HttpHelper::getParam('motdepasse'));
        $tab['mail'] = htmlspecialchars(HttpHelper::getParam('mail'));
        $util = $_SESSION['util'];

        $donnees = $this->DonneesService->updateData($pdo,$tab,$util);
		
		if($donnees == "ok"){
			echo "cest good";
		}
		
		$view = new View("check-your-mood/views/modification");
		return $view;
    }

}
