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

    private function encodeText(string $text): string
{
    $text = (string) $text;

    if (function_exists('mb_detect_encoding') && function_exists('mb_convert_encoding')) {
        $encoding = mb_detect_encoding($text, ['UTF-8', 'ISO-8859-1', 'Windows-1252', 'CP1252'], true);

        if ($encoding === 'UTF-8') {
            return mb_convert_encoding($text, 'Windows-1252', 'UTF-8');
        }

        if ($encoding === 'ISO-8859-1' || $encoding === 'Windows-1252' || $encoding === 'CP1252') {
            return mb_convert_encoding($text, 'Windows-1252', $encoding);
        }
    }

    if (function_exists('iconv')) {
        $converted = @iconv('UTF-8', 'Windows-1252//IGNORE', $text);
        if ($converted !== false) {
            return $converted;
        }

        $converted = @iconv('ISO-8859-1', 'Windows-1252//IGNORE', $text);
        if ($converted !== false) {
            return $converted;
        }
    }

    if (function_exists('mb_convert_encoding')) {
        $converted = @mb_convert_encoding($text, 'Windows-1252', 'UTF-8');
        if ($converted !== false) {
            return $converted;
        }
    }

    return utf8_decode($text);
}

public function exportPdf(Request $request, Response $response)
{
    require_once __DIR__ . '/../../libs/fpdf/fpdf.php';

    $service = new ItemService();
    $items = $service->list([]);

    $pdf = new \FPDF('P', 'mm', 'A4');
    $pdf->AddPage();

    $pdf->SetFont('Helvetica', 'B', 16);
    $pdf->Cell(0, 10, $this->encodeText('Reporte de Inventario'), 0, 1, 'C');
    $pdf->Ln(2);

    $pdf->SetFont('Helvetica', '', 10);
    date_default_timezone_set('America/Argentina/Rio_Gallegos');
    $fechaActual = date('d/m/Y H:i');
    $pdf->Cell(0, 10, $this->encodeText('Fecha de emisión: ' . $fechaActual), 0, 1, 'R');
    $pdf->Ln(5);

    $pdf->SetFont('Helvetica', 'B', 10);
    $pdf->SetFillColor(230, 230, 230);

    $pdf->Cell(25, 10, $this->encodeText('Código'), 1, 0, 'C', true);
    $pdf->Cell(55, 10, $this->encodeText('Nombre'), 1, 0, 'C', true);
    $pdf->Cell(40, 10, $this->encodeText('Categoría'), 1, 0, 'C', true);
    $pdf->Cell(30, 10, $this->encodeText('Precio'), 1, 0, 'C', true);
    $pdf->Cell(20, 10, $this->encodeText('Stock'), 1, 1, 'C', true);

    $pdf->SetFont('Helvetica', '', 9);

    foreach ($items as $item) {
        $pdf->Cell(25, 10, $this->encodeText($item['codigo'] ?? ''), 1, 0, 'L');
        $pdf->Cell(55, 10, $this->encodeText($item['nombre'] ?? ''), 1, 0, 'L');
        $pdf->Cell(40, 10, $this->encodeText($item['categoria'] ?? ''), 1, 0, 'L');
        $pdf->Cell(30, 10, $this->encodeText('$' . number_format((float)($item['precio'] ?? 0), 2, ',', '.')), 1, 0, 'R');
        $pdf->Cell(20, 10, $this->encodeText((string)($item['stock'] ?? 0)), 1, 1, 'C');
    }

    $pdf->Output('I', 'Reporte_Inventario.pdf');
    exit();
}

}