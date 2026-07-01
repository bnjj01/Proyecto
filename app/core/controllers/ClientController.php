<?php
namespace app\core\controllers;

use app\core\controllers\base\BaseController;
use app\core\models\dto\ClientDto;
use app\core\services\ClientService;
use app\libs\http\Request;
use app\libs\http\Response;

class ClientController extends BaseController {
    public $client;
    public int $clientId;

    public function __construct() {
        parent::__construct();
        if (session_status() === PHP_SESSION_NONE) { session_start(); }

        if (!isset($_SESSION['perfil']) || !in_array($_SESSION['perfil'], ['Operador', 'Administrador'])) {
            header("Location: " . APP_URL . "home");
            exit();
        }
    }

    public function index(Request $request, Response $response){
        $this->setCurrentView($request);
        $this->styles = ['app/css/user-index.css'];
        $this->modules = ['app/js/client/index.js'];
        require_once(APP_FILE_TEMPLATE);
    }

    public function create(Request $request, Response $response){
        $this->setCurrentView($request);
        $this->styles = ['app/css/user-create.css'];
        $this->modules = ['app/js/client/create.js'];
        require_once(APP_FILE_TEMPLATE);
    }

    public function save(Request $request, Response $response){
        try {
            $data = $request->getDataFromInput();
            $dto = new ClientDto($data);
            $service = new ClientService();
            $service->save($dto);
            
            $response->setMessage("Cliente registrado con éxito.");
            $response->send(true);
        } catch (\Throwable $e) {
            $response->setMessage("Error: " . $e->getMessage());
            $response->send(false);
        }
    }

    public function edit(Request $request, Response $response){
        $this->clientId = $request->getId();
        $service = new ClientService();

        $this->client = $service->getById($this->clientId);
        $this->setCurrentView($request);

        $this->styles = ['app/css/user-edit.css'];
        $this->modules = ['app/js/client/edit.js'];
        require_once(APP_FILE_TEMPLATE);
    }

    public function update(Request $request, Response $response){
        try {
            $data = $request->getDataFromInput();
            $dto = new ClientDto($data);
            $service = new ClientService();
            $service->update($dto);
            
            $response->setMessage("Cliente actualizado con éxito.");
            $response->send(true);
        } catch (\Throwable $e) {
            $response->setMessage("Error: " . $e->getMessage());
            $response->send(false);
        }
    }

    public function delete(Request $request, Response $response){
        try {
            $id = $request->getDataFromInput()['id'] ?? 0;
            $service = new ClientService();
            $service->remove($id);
            $response->setMessage("Cliente eliminado con éxito.");
            $response->send(true);
        } catch (\Throwable $e) {
            $response->setMessage("Error: " . $e->getMessage());
            $response->send(false);
        }
    }

    public function list(Request $request, Response $response){
        try {
            $service = new ClientService();
            $result = $service->list($request->getDataFromInput() ?? []);
            $response->setData($result);
            $response->send(true);
        } catch (\Exception $e) {
            $response->setMessage($e->getMessage());
            $response->send(false);
        }
    }

    public function load(Request $request, Response $response){
        try {
            $id = $request->getDataFromInput()['id'] ?? 0;
            $service = new ClientService();
            $result = $service->getById($id);
            $response->setData($result);
            $response->send(true);
        } catch (\Exception $e) {
            $response->setMessage($e->getMessage());
            $response->send(false);
        }
    }
}