<?php
namespace controllers;

use services\InscriptionService;
use yasmf\HttpHelper;
use yasmf\View;

session_start();

class InscriptionController {

    private $InscriptionService;

    public function __construct()
    {
        $this->InscriptionService = InscriptionService::getDefaultInscriptionService();
    }

    public function signin($pdo) {

        $id = htmlspecialchars(HttpHelper::getParam('identifiant')) != "" ? htmlspecialchars(HttpHelper::getParam('identifiant')) : null;
        $mdp = htmlspecialchars(HttpHelper::getParam('motdepasse')) != "" ? htmlspecialchars(HttpHelper::getParam('motdepasse')) : null;
        $mail = htmlspecialchars(HttpHelper::getParam('mail')) != "" ? htmlspecialchars(HttpHelper::getParam('mail')) : null;
        $nom = htmlspecialchars(HttpHelper::getParam('nom')) != "" ? htmlspecialchars(HttpHelper::getParam('nom')) : null;
        $prenom = htmlspecialchars(HttpHelper::getParam('prenom')) != "" ? htmlspecialchars(HttpHelper::getParam('prenom')) : null;

        $insertOk = $this->InscriptionService->inscription($pdo,$id,$mdp,$mail,$nom,$prenom);

        if($insertOk == "nOk"){
            $view = new View("check-your-mood/views/inscription");
            return $view;
        }

        $view = new View("check-your-mood/views/connexion");
        return $view;
    }

}
