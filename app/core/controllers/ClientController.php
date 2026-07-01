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

    public function encodeText($text) {
    return mb_convert_encoding($text, 'UTF-8', 'auto');
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

    public function exportPdf(Request $request, Response $response){
        require_once $_SERVER['DOCUMENT_ROOT'] . '/lab_prog_2026_Pozzo_Benjamin/app/libs/fpdf/fpdf.php';

        $service = new ClientService();
        $id = (int) $request->getId();

        $pdf = new \FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        date_default_timezone_set('America/Argentina/Rio_Gallegos');
        $fechaActual = date('d/m/Y H:i');

        if ($id > 0) {
            $client = $service->getById($id);

            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(0, 10, utf8_decode('Ficha del Cliente'), 0, 1, 'C');
            $pdf->Ln(2);

            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(0, 10, utf8_decode('Fecha de emisión: ' . $fechaActual), 0, 1, 'R');
            $pdf->Ln(5);

            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 10, utf8_decode('Datos Personales / Comerciales'), 0, 1, 'L');
            $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
            $pdf->Ln(5);

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(40, 8, 'Tipo de Cliente:', 0, 0);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(0, 8, utf8_decode($client['tipo']), 0, 1);

            if ($client['tipo'] === 'Particular') {
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(40, 8, 'Apellido y Nombres:', 0, 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(0, 8, utf8_decode($client['apellido'] . ', ' . $client['nombres']), 0, 1);
                
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(40, 8, 'DNI:', 0, 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(0, 8, utf8_decode($client['dni']), 0, 1);
            } else {
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(40, 8, utf8_decode('Razón Social:'), 0, 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(0, 8, utf8_decode($client['razon_social']), 0, 1);
                
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(40, 8, 'CUIT:', 0, 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(0, 8, utf8_decode($client['cuit']), 0, 1);
            }

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(40, 8, utf8_decode('Teléfono:'), 0, 0);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(0, 8, utf8_decode($client['telefono']), 0, 1);

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(40, 8, 'Correo:', 0, 0);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(0, 8, utf8_decode($client['correo']), 0, 1);

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(40, 8, 'Domicilio:', 0, 0);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(0, 8, utf8_decode($client['domicilio']), 0, 1);

            $pdf->Output('I', 'Ficha_Cliente_' . $id . '.pdf');

        } 
        else {
            $clients = $service->list([]); 

            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(0, 10, utf8_decode('Reporte General de Clientes'), 0, 1, 'C');
            $pdf->Ln(2); 

            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(0, 10, utf8_decode('Fecha de emisión: ' . $fechaActual), 0, 1, 'R');
            $pdf->Ln(5);

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetFillColor(230, 230, 230);
            
            $pdf->Cell(45, 10, utf8_decode('Apellido / Razón Social'), 1, 0, 'C', true);
            $pdf->Cell(35, 10, 'Nombres', 1, 0, 'C', true);
            $pdf->Cell(30, 10, 'DNI / CUIT', 1, 0, 'C', true);
            $pdf->Cell(25, 10, 'Tipo', 1, 0, 'C', true);
            $pdf->Cell(55, 10, 'Correo', 1, 1, 'C', true);

            $pdf->SetFont('Arial', '', 9);
            
            foreach ($clients as $client) {
                $tipo = utf8_decode($client['tipo'] ?? '');
                $apellido = utf8_decode($client['tipo'] === 'Particular' ? ($client['apellido'] ?? '') : ($client['razon_social'] ?? ''));
                $nombres = utf8_decode($client['nombres'] ?? '');
                $dniCuit = utf8_decode($client['tipo'] === 'Particular' ? ($client['dni'] ?? '') : ($client['cuit'] ?? ''));
                $correo = utf8_decode($client['correo'] ?? '');

                $pdf->Cell(45, 10, $apellido, 1, 0, 'L');
                $pdf->Cell(35, 10, $nombres, 1, 0, 'L');
                $pdf->Cell(30, 10, $dniCuit, 1, 0, 'C');
                $pdf->Cell(25, 10, $tipo, 1, 0, 'C');
                $pdf->Cell(55, 10, $correo, 1, 1, 'L');
            }

            $pdf->Output('I', 'Reporte_Clientes.pdf');
        }
        
        exit();
    }
}