<?php

namespace app\core\controllers;

use app\core\controllers\base\BaseController;
use app\core\models\dto\ItemDto;
use app\core\services\ItemService;
use app\libs\http\Request;
use app\libs\http\Response;

class ItemController extends BaseController{
   
    public int $itemId;

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request, Response $response){
        $this->setCurrentView($request);
        $this->styles = ['app/css/user-index.css'];
        $this->modules = ['app/js/item/index.js'];
        require_once(APP_FILE_TEMPLATE);
    }

    public function create(Request $request, Response $response){
        $this->setCurrentView($request);
        $this->styles = ['app/css/user-create.css'];
        $this->modules = ['app/js/item/create.js'];
        require_once(APP_FILE_TEMPLATE);
    }

    public function save(Request $request, Response $response){
       try {
        $data = $request->getDataFromInput();
        $dto = new ItemDto($data);
        $service = new ItemService();
        $service->save($dto);
        
        $response->setMessage("Se registró el item con éxito.");
        $response->send(true);
        } catch (\Throwable $e) {
            $response->setMessage("Error Fatal: " . $e->getMessage() . " en la línea " . $e->getLine());
            $response->send(false);
        }
    }

    public function edit(Request $request, Response $response){
        $this->itemId = $request->getId();
        $this->setCurrentView($request);
        $this->styles = ['app/css/user-create.css'];
        $this->modules = ['app/js/item/edit.js'];
        require_once(APP_FILE_TEMPLATE);
    }

    public function update(Request $request, Response $response){
        $data = $request->getDataFromInput();
        $service = new ItemService();
        try {
            $dto = new ItemDto($data);
            $service->update($dto);
            $response->setMessage("Se actualizó el item con éxito.");
            $response->send(true);
        } catch (\Throwable $e) {
            $response->setMessage("Error Fatal: " . $e->getMessage() . " en la línea " . $e->getLine());
            $response->send(false);
        }
    }

    public function delete(Request $request, Response $response){
        $id = $request->getId();
        $service = new ItemService();
        try {
            $service->remove($id);
            $response->setMessage("Se eliminó el item con éxito.");
            $response->send(true);
        } catch (\Throwable $e) {
            $response->setMessage("Error Fatal: " . $e->getMessage() . " en la línea " . $e->getLine());
            $response->send(false);
        }
    }

    public function list(Request $request, Response $response){
        $data = $request->getDataFromInput();
        $service = new ItemService();
        try {
            $result = $service->list($data);
            $response->setData($result);
            $response->send(true);
        } catch (\Exception $e) {
            $response->setMessage($e->getMessage());
            $response->send(false);
        }
    }

    public function load(Request $request, Response $response){
        $id = $request->getDataFromInput()['id'] ?? 0;
        if ($id <= 0) {
            $response->setMessage("ID inválido");
            $response->send(false);
            return;
        }
        
        $service = new ItemService();
        try {
            $result = $service->getById($id);
            $response->setData($result);
            $response->send(true);
        } catch (\Exception $e) {
            $response->setMessage($e->getMessage());
            $response->send(false);
        }
    }
    
    public function suggestive(Request $request, Response $response){
        // $service = new MaterialService($request->getController());
        // $data = $service->suggestive($request->getDataFromInput());
        // $response->setResult($data);
        // $response->send();
    }

}