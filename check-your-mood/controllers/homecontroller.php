<?php
namespace controllers;

use services\HomeService;
use services\MoodService;
use yasmf\HttpHelper;
use yasmf\View;

session_start();

class HomeController {

    private $HomeService;

    public function __construct()
    {
        $this->HomeService = HomeService::getDefaultHomeService();
        $this->MoodService = MoodService::getDefaultMoodService();
    }

    public function login($pdo){
        $id = htmlspecialchars(HttpHelper::getParam('identifiant'));
        $mdp = htmlspecialchars(HttpHelper::getParam('motdepasse'));
        $utilOk = $this->HomeService->connexion($pdo,$id,$mdp);

        if($utilOk == 0){
            $view = new View("check-your-mood/views/connexion");
            return $view;
        }
			
			// Stockage dans la session //
		$_SESSION['id'] = $id;		// Stockage nom dans la session
		$_SESSION['util'] = $utilOk;// Stockage prénom dans la session
		$_SESSION['mdp'] = $mdp;
		$_SESSION['numeroSession']=session_id();// Stockage numéro de session pour éviter les piratages.

        $humeurs = $this->MoodService->viewMoods($pdo,$utilOk);
        $libelles = $this->MoodService->libelles($pdo);

        $view = new View("check-your-mood/views/humeurs");
        $view->setVar('humeurs',$humeurs);
        $view->setVar('libelles',$libelles);
        return $view;
        
    }

    public function goTo(){
        $namepage = HttpHelper::getParam('namepage');
        $view = new View("check-your-mood/views/".$namepage);
        return $view;
    }

    public function index() {

        $view = new View("check-your-mood/views/connexion");
        return $view;
    }

}
