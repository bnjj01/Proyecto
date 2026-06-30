<?php

namespace app\core\controllers;

use app\core\controllers\base\BaseController;
use app\libs\http\Request;
use app\libs\http\Response;

class HomeController extends BaseController{

    

    public function __construct(){
        parent::__construct();
    }

    public function index(Request $request, Response $response){
        $this->setCurrentView($request);
        $this->styles = ['app/css/home.css'];
        require_once(APP_FILE_TEMPLATE);
    }


}