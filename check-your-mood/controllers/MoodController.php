<?php
namespace controllers;


use services\MoodService;
use yasmf\HttpHelper;
use yasmf\View;

session_start();

class MoodController {

    private $MoodService;

    public function __construct()
    {
        $this->MoodService = MoodService::getDefaultMoodService();
    }

    public function index($pdo) {
        $code = (int) HttpHelper::getParam('humeur');
        $date = date('y-m-d');
        $heure = date('h:i:s');
        $contexte = HttpHelper::getParam('contexte');
        $util = $_SESSION['util'];

        $insertion = $this->MoodService->insertMood($pdo, $code, $date, $heure, $contexte, $util);

        $humeurs = $this->MoodService->viewMoods($pdo,$util);
        $libelles = $this->MoodService->libelles($pdo);

        $view = new View("check-your-mood/views/humeurs");
        $view->setVar('humeurs',$humeurs);
        $view->setVar('libelles',$libelles);

        return $view;
    }

}
