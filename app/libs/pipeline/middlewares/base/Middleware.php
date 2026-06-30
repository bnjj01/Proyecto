<?php

namespace app\libs\pipeline\middlewares\base;

use app\libs\pipeline\middlewares\base\InterfaceMiddleware;
use app\libs\http\Request;
use app\libs\http\Response;

/**
 * Descripción de Middleware
 * Clase base, que será heredada por los middlewares de la aplicación.
 * Implementa el Patrón de comportamiento: Chain of Responsability.
 *
 * @author Ing. Jose Rasjido
 */

class Middleware {
    
    protected ?InterfaceMiddleware $next;
    
    public function __construct() {
        $this->next = null;
    }
    
    public function setNext(InterfaceMiddleware $middleware): void{
        $this->next = $middleware;
    }
    
    public function processNext(Request $request, Response $response): void{
        if($this->next != null){
            $this->next->process($request, $response);
        }
    }
    
}