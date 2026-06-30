<?php

namespace app\core\controllers;

use app\core\controllers\base\BaseController;
use app\core\services\AuthenticationService;
use app\libs\http\Request;
use app\libs\http\Response;

class AuthenticationController extends BaseController{
    
        public function __construct(){
            parent::__construct();

    }

    public function index(Request $request, Response $response){
        require_once APP_FILE_LOGIN;
    }

    public function login(Request $request, Response $response){
        $user = $request->getParameterValue('user', '');
        $pass = $request->getParameterValue('pass', '');
        try{
            $service= new AuthenticationService();
            $service->login($user, $pass);
            $request->setController(APP_DEFAULT_CONTROLLER);

            header("Location: " . APP_URL . "home");
            exit;
        }catch(\Exception $e){
            $_SESSION['error'] = $e->getMessage();

            header("Location: " . APP_URL . "authentication");
            exit;

        }

    }

    public function logout(Request $request, Response $response){
        $service = new AuthenticationService();
        $service->logout();
        unset($_SESSION['error']);
        
        header("Location: " . APP_URL);
        exit;
    }

}