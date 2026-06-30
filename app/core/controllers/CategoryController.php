<?php
namespace app\core\controllers;

use app\core\controllers\base\BaseController;
use app\libs\http\Request;
use app\libs\http\Response;

class CategoryController extends BaseController{
    
    public function __construct()
    {
        parent::__construct();
    }

    // Este es el método que busca el ruteador cuando entrás a /category
    public function index(Request $request, Response $response){
        // Esto le dice al sistema que busque el archivo en app/views/category/index.php
        $this->setCurrentView($request); 
        
        
        $this->modules = ["app/js/category/index.js"];
        $this->styles = ["app/css/user-index.css"];
        
        // Finalmente, envuelve tu vista con el menú y el pie de página
        require_once(APP_FILE_TEMPLATE);
    }
}