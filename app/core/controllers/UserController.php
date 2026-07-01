<?php
namespace app\core\controllers;

use app\core\controllers\base\BaseController;
use app\libs\http\Request;
use app\libs\http\Response;
use app\core\models\dto\UserDto;
use app\core\services\UserService;

class UserController extends BaseController{
    
    public function __construct(){
        parent::__construct();

        if (session_status() === PHP_SESSION_NONE) {
                session_start();
        }

        if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'Administrador') {
            header("Location: " . APP_URL . "home");
            exit();
        }
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

    public function exportPdf(Request $request, Response $response){
        require_once $_SERVER['DOCUMENT_ROOT'] . '/lab_prog_2026_Pozzo_Benjamin/app/libs/fpdf/fpdf.php';

        $service = new \app\core\services\UserService();
        $usuarios = $service->list();

        $pdf = new \FPDF('P', 'mm', 'A4');
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, utf8_decode('Reporte General de Usuarios'), 0, 1, 'C');
        $pdf->Ln(2); 

        $pdf->SetFont('Arial', '', 10);
        date_default_timezone_set('America/Argentina/Rio_Gallegos');
        $fechaActual = date('d/m/Y H:i');
        $pdf->Cell(0, 10, utf8_decode('Fecha de emisión: ' . $fechaActual), 0, 1, 'R');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(230, 230, 230);
        
        $pdf->Cell(35, 10, 'Apellido', 1, 0, 'C', true);
        $pdf->Cell(45, 10, 'Nombres', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Cuenta', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Perfil', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Correo', 1, 1, 'C', true);

        $pdf->SetFont('Arial', '', 9);
        
        foreach ($usuarios as $user) {
            $pdf->Cell(35, 10, utf8_decode($user['apellido']), 1, 0, 'L');
            $pdf->Cell(45, 10, utf8_decode($user['nombres']), 1, 0, 'L');
            $pdf->Cell(30, 10, utf8_decode($user['cuenta']), 1, 0, 'L');
            $pdf->Cell(30, 10, utf8_decode($user['perfil']), 1, 0, 'C');
            $pdf->Cell(50, 10, utf8_decode($user['correo']), 1, 1, 'L');
        }

        $pdf->Output('I', 'Reporte_Usuarios.pdf');
        exit();
    }

}