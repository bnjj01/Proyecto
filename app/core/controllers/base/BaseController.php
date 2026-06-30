<?php

namespace app\core\controllers\base;

use app\libs\http\Request;

class BaseController{
    
    protected string $view;
    protected array $scripts;
    protected array $modules;
    protected array $modals;
    protected array $breadCrumb;
    public array $styles = [];

    public function __construct(array $scripts = [], array $modules = [], array $modals = [])
    {
        $this->view = "";
        $this->scripts = $scripts;
        $this->modules = $modules;
        $this->modals = $modals;

        $this->breadCrumb = [
            "title" => "",
            "icon" => "",
            "nav" => []
        ];
    }

    protected function setCurrentView(Request $request): void{
        $this->view = $request->getController() . '/' . $request->getAction() . '.php';
    }

}