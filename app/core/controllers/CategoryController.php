<?php
namespace app\core\controllers;

use app\core\controllers\base\BaseController;
use app\core\models\dto\CategoryDto;
use app\core\services\CategoryService;
use app\libs\http\Request;
use app\libs\http\Response;

class CategoryController extends BaseController{
    
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request, Response $response){
        $this->setCurrentView($request);
        $this->modules = ["app/js/category/index.js"];
        $this->styles = ["app/css/user-index.css"];
        require_once(APP_FILE_TEMPLATE);
    }

    public function list(Request $request, Response $response){
        $filters = $request->getDataFromInput() ?? [];
        $service = new CategoryService();

        try {
            $result = $service->list($filters);
            $response->setData($result);
            $response->send(true);
        } catch (\Exception $e) {
            $response->setMessage($e->getMessage());
            $response->send(false);
        }
    }

    public function save(Request $request, Response $response){
        $data = $request->getDataFromInput() ?? [];
        $dto = new CategoryDto($data);
        $service = new CategoryService();

        try {
            $service->save($dto);
            $response->setMessage("Categoría registrada con éxito.");
            $response->send(true);
        } catch (\Throwable $e) {
            $response->setMessage($e->getMessage());
            $response->send(false);
        }
    }

    public function update(Request $request, Response $response){
        $data = $request->getDataFromInput() ?? [];
        $dto = new CategoryDto($data);
        $service = new CategoryService();
        try {
            $service->update($dto);
            $response->setMessage("Categoría actualizada con éxito.");
            $response->send(true);
        } catch (\Exception $e) {
            $response->setMessage($e->getMessage());
            $response->send(false);
        }
    }

    public function delete(Request $request, Response $response){
        $data = $request->getDataFromInput() ?? [];
        $id = isset($data['id']) ? (int)$data['id'] : 0;
        
        $service = new CategoryService();
        try {
            if ($id === 0) throw new \Exception("ID no proporcionado.");
            $service->delete($id);
            $response->setMessage("Categoría eliminada.");
            $response->send(true);
        } catch (\Exception $e) {
            $mensajeError = $e->getMessage();
            
            if (strpos($mensajeError, '1451') !== false || strpos($mensajeError, 'Integrity constraint violation') !== false) {
                $mensajeError = "No puedes eliminar esta categoría porque hay productos que la están utilizando. Cámbiales la categoría primero.";
            }
            $response->setMessage($mensajeError);
            $response->send(false);
        }
    }
}