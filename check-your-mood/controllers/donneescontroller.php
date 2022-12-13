<?php
namespace controllers;

use services\DonneesService;
use services\MoodService;
use yasmf\HttpHelper;
use yasmf\View;

session_start();

class DonneesController {

    private $DonneesService;
    private $MoodService;
    public function __construct()
    {
        $this->DonneesService = DonneesService::getDefaultDonneesService();
        $this->MoodService = MoodService::getDefaultMoodService();
    }

    public function goToMood($pdo){
        
        $namepage = htmlspecialchars(HttpHelper::getParam('namepage'));
        $humeurs = $this->MoodService->viewMoods($pdo,$_SESSION['util']);
        $libelles = $this->MoodService->libelles($pdo);

        $view = new View("check-your-mood/views/".$namepage);
        $view->setVar('humeurs',$humeurs);
        $view->setVar('libelles',$libelles);
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
