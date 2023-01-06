<?php
namespace controllers;

use services\HomeService;
use services\MoodService;
use yasmf\HttpHelper;
use yasmf\View;

session_start();

class DeconnexionController {

    public function index() {
		
		session_destroy();

        $view = new View("check-your-mood/views/connexion");
        return $view;
    }

}
