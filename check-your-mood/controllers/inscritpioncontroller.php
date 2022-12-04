<?php
namespace controllers;

use services\InscriptionService;
use yasmf\HttpHelper;
use yasmf\View;

class InscriptionController {

    private $InscriptionService;

    public function __construct()
    {
        $this->InscriptionService = InscriptionService::getDefaultInscriptionService();
    }

    public function signin($pdo){
        $id = htmlspecialchars(HttpHelper::getParam('identifiant'));
        $mdp = htmlspecialchars(HttpHelper::getParam('motdepasse'));
        echo $id;
        echo $mdp;
        $searchStmt = $this->InscriptionService->Inscription($pdo,$id,$mdp);

        $view = new View("check-your-mood/views/Inscription");
        return $view;
    }

    public function index() {

        $view = new View("check-your-mood/views/inscription");
        return $view;
    }

}
