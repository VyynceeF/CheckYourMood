<?php
namespace controllers;

use services\HomeService;
use services\MoodService;
use yasmf\HttpHelper;
use yasmf\View;


class HomeController {

    private $HomeService;

    public function __construct()
    {
        $this->HomeService = HomeService::getDefaultHomeService();
        $this->MoodService = MoodService::getDefaultMoodService();
    }

    //Fonction de connection
    public function login($pdo){
        $id = htmlspecialchars(HttpHelper::getParam('identifiant'));
        $mdp = htmlspecialchars(HttpHelper::getParam('motdepasse'));
        $infos = $this->HomeService->connexion($pdo,$id,$mdp);

        if($infos['util'] == 0){
            
            $view = new View("check-your-mood/views/connexion");
            $view->setVar('errData',false);
            return $view;
        }
			
        //TODO : Inserer toutes les infos utilisateurs dans la session
		// Stockage dans la session //
        foreach($infos as $key => $value){
            $_SESSION["$key"] = $value;
        }

		$_SESSION['id'] = $id;		
		$_SESSION['mdp'] = $mdp;
		$_SESSION['numeroSession']=session_id();// Stockage numéro de session pour éviter les piratages.

        //Humeurs de l'utilisateur
        $humeurs = $this->MoodService->viewMoods($pdo,$infos['util']);

        //Libelle disponible
        $libelles = $this->MoodService->libelles($pdo);

        //Création de la vue et set vraiable
        $view = new View("check-your-mood/views/humeurs");
        $view->setVar('humeurs',$humeurs);
        $view->setVar('libelles',$libelles);
        $view->setVar('updateOk',true);
        return $view;
    }

    //goTo pour ce déplacer entre la page de connexion et celle d'inscription
    public function goTo(){
        $namepage = HttpHelper::getParam('namepage');
        $view = new View("check-your-mood/views/".$namepage);
        $view->setVar('errData',true);
        return $view;
    }

    public function index() {

        $view = new View("check-your-mood/views/connexion");
        $view->setVar('errData',true);
        return $view;
    }

}
