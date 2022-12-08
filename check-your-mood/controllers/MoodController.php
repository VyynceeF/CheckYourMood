<?php
namespace controllers;

use services\MoodService;
use yasmf\HttpHelper;
use yasmf\View;

class MoodController {

    private $MoodService;

    public function __construct() 
    {
        $this->MoodService = MoodService::getDefaultMoodService();
    }

    public function index($pdo) {
        $code = (int) HttpHelper::getParam('humeur');
        $contexte = HttpHelper::getParam('contexte');
        $util = HttpHelper::getParam('codeUtil');

        $insertion = $this->MoodService->insertMood($pdo,$code,$contexte,$util);

        $humeurs = $this->MoodService->viewMoods($pdo,$util);
        $libelles = $this->MoodService->libelles($pdo);

        $view = new View("check-your-mood/views/humeurs");

        $view->setVar('util', $util);
        $view->setVar('humeurs',$humeurs);
        $view->setVar('libelles',$libelles);

        return $view;
    }

}
