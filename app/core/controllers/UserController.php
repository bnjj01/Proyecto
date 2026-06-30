<?php
namespace app\core\controllers;

use app\core\controllers\base\BaseController;
use app\libs\http\Request;
use app\libs\http\Response;
use app\core\models\dto\UserDto;
use app\core\services\UserService;

class UserController extends BaseController{
    
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request, Response $response){
        $this->setCurrentView($request);
        $this->modules= ["app/js/user/index.js"];
        $this->styles= ["app/css/user-index.css"];
        require_once(APP_FILE_TEMPLATE);
    }

    public function create(Request $request, Response $response){
        $this->setCurrentView($request);
        $this->modules= ["app/js/user/create.js"];
        $this->styles= ["app/css/user-create.css"];
        require_once(APP_FILE_TEMPLATE);
    }

    public function save(Request $request, Response $response){
        $data = $request->getDataFromInput() ?? [];
        $dto = new UserDto($data);
        $service = new UserService();
        try {
            $service->save($dto);
            $response->setMessage("Se registró el usuario con éxito.");
            $response->send(true);
        } catch (\Exception $e) {
            $response->setMessage($e->getMessage());
            $response->send(false);
        }
    }

    public function edit(Request $request, Response $response){
        $this->setCurrentView($request);
        $this->modules= ["app/js/user/edit.js"];
        $this->styles= ["app/css/user-edit.css"];
        require_once(APP_FILE_TEMPLATE);
    }

    public function update(Request $request, Response $response){
        $data = $request->getDataFromInput() ?? [];
        $dto = new UserDto($data);
        $service = new UserService();
        try {
            $service->update($dto);
            $response->setMessage("Se actualizó el usuario con éxito.");
            $response->send(true);
        } catch (\Exception $e) {
            $response->setMessage($e->getMessage());
            $response->send(false);
        }
    }

    public function delete(Request $request, Response $response){
        $data = $request->getDataFromInput() ?? [];
        $idJson = isset($data['id']) ? (int)$data['id'] : 0;
        $idUrl = (int)$request->getId();
        $id = ($idJson !== 0) ? $idJson : $idUrl;
        $service = new UserService();
        try {
            $service->remove($id);
            $response->setMessage("Se eliminó el usuario con éxito.");
            $response->send(true);
        } catch (\Exception $e) {
            $response->setMessage($e->getMessage());
            $response->send(false);
        }
    }

    public function list(Request $request, Response $response){
        $data = $request->getDataFromInput() ?? [];
        $service = new UserService();
        try {
            $result = $service->list($data);
            $response->setData($result);
            $response->send(true);
        } catch (\Exception $e) {
            $response->setMessage($e->getMessage());
            $response->send(false);
        }
    }

    public function enable(Request $request, Response $response){
        $id = $request->getId();
        $service = new UserService();
        try {
            $service->habilitarUsuario($id);
            $response->setMessage("El usuario ha sido habilitado con éxito.");
            $response->send(true);
        } catch (\Exception $e) {
            $response->setMessage($e->getMessage());
            $response->send(false);
        }
    }

    public function disable(Request $request, Response $response){
        $id = $request->getId();
        $service = new UserService();
        try {
            $service->suspenderUsuario($id);
            $response->setMessage("El usuario ha sido suspendido con éxito.");
            $response->send(true);
        } catch (\Exception $e) {
            $response->setMessage($e->getMessage());
            $response->send(false);
        }
    }

    public function reset(Request $request, Response $response){
        $id = $request->getId();
        $service = new UserService();
        try {
            $service->resetearClave($id);
            $response->setMessage("La clave del usuario ha sido restablecida con éxito.");
            $response->send(true);
        } catch (\Exception $e) {
            $response->setMessage($e->getMessage());
            $response->send(false);
        }
    }

    public function load(Request $request, Response $response){
        $data = $request->getDataFromInput() ?? [];
        $idJson = isset($data['id']) ? (int)$data['id'] : 0;
        $idUrl = (int)$request->getId();
        $id = ($idJson !== 0) ? $idJson : $idUrl;
        $service = new UserService();
        try {
            $result = $service->load($id);
            $response->setData($result);
            $response->send(true);
        } catch (\Exception $e) {
            $response->setMessage($e->getMessage());
            $response->send(false);
        }
    }

}