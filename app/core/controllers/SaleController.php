<?php
namespace app\core\controllers;

use app\core\controllers\base\BaseController;
use app\core\models\dto\SaleDto;
use app\core\services\SaleService;
use app\libs\http\Request;
use app\libs\http\Response;

class SaleController extends BaseController {
    public $venta;
    public function __construct() {
        parent::__construct();
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['usuarioId'])) {
            header("Location: " . APP_URL);
            exit();
        }
    }

    public function index(Request $request, Response $response){
        $this->setCurrentView($request);
        $this->styles = ['app/css/user-index.css']; 
        $this->modules = ['app/js/sale/index.js']; 
        require_once(APP_FILE_TEMPLATE);
    }

    public function create(Request $request, Response $response){
        $this->setCurrentView($request);
        $this->styles = ['app/css/user-index.css'];
        $this->modules = ['app/js/sale/create.js'];
        require_once(APP_FILE_TEMPLATE);
    }

    public function save(Request $request, Response $response){
        $data = $request->getDataFromInput() ?? [];
        $usuarioId = (int)$_SESSION['usuarioId'];

        try {
            $dto = new SaleDto($data);
            $service = new SaleService();
            $service->save($dto, $usuarioId);
            
            $response->setMessage("Venta registrada con éxito.");
            $response->send(true);
        } catch (\Throwable $e) {
            $response->setMessage("Error: " . $e->getMessage());
            $response->send(false);
        }
    }

    public function update(Request $request, Response $response){
        $data = $request->getDataFromInput() ?? [];
        $service = new SaleService();
        try {
            $service->update($data);
            $response->setMessage('Venta actualizada con éxito.');
            $response->send(true);
        } catch (\Exception $e) {
            $response->setMessage($e->getMessage());
            $response->send(false);
        }
    }

    public function delete(Request $request, Response $response){
    $data = $request->getDataFromInput() ?? [];
    $id = isset($data['id']) ? (int)$data['id'] : $request->getId();

    $service = new SaleService();
    try {
        $service->remove($id);
        $response->setMessage('Venta eliminada con éxito.');
        $response->send(true);
    } catch (\Exception $e) {
        $response->setMessage($e->getMessage());
        $response->send(false);
    }
}

    public function list(Request $request, Response $response){
        $filters = $request->getDataFromInput() ?? [];
        try {
            $service = new SaleService();
            $result = $service->list($filters);
            $response->setData($result);
            $response->send(true);
        } catch (\Exception $e) {
            $response->setMessage($e->getMessage());
            $response->send(false);
        }
    }

    public function edit(Request $request, Response $response){
        $id = (int) $request->getId();
        $service = new SaleService();

        try {
            $this->venta = $service->getById($id);
        } catch (\Exception $e) {
            header("Location: " . APP_URL . "sale");
            exit();
        }

        $this->setCurrentView($request);
        $this->styles = ['app/css/user-edit.css'];
        $this->modules = ['app/js/sale/edit.js'];
        require_once(APP_FILE_TEMPLATE);
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

    $data = $request->getDataFromInput() ?? [];
    $id = isset($data['id']) ? (int) $data['id'] : (int) $request->getId();
    $service = new SaleService();

    if ($id > 0) {
        $venta = $service->getById($id);

        $cliente = isset($data['cliente']) && $data['cliente'] !== '' ? $data['cliente'] : ($venta['cliente'] ?? '');
        $formaPago = isset($data['forma_pago']) && $data['forma_pago'] !== '' ? $data['forma_pago'] : ($venta['forma_pago'] ?? '');
        $estado = isset($data['estado']) && $data['estado'] !== '' ? (string) $data['estado'] : (string) ($venta['estado'] ?? '1');
        $estadoTexto = $estado === '0' ? 'Anulada' : 'Válida';
        $fecha = $venta['fecha_formateada'] ?? $venta['fecha'] ?? '';
        $numeroVenta = $venta['numero_venta'] ?? $id;
        $detalles = $venta['detalles'] ?? [];
        $total = (float) ($venta['total'] ?? 0);
        $vendedor = $venta['vendedor'] ?? 'Sin asignar';

        $pdf = new \FPDF('P', 'mm', 'A4');
        $pdf->AddPage();

        $pdf->SetFont('Helvetica', 'B', 18);
        $pdf->Cell(0, 10, $this->encodeText('COMPROBANTE DE VENTA'), 0, 1, 'C');
        $pdf->Ln(2);

        $pdf->SetFont('Helvetica', '', 10);
        date_default_timezone_set('America/Argentina/Rio_Gallegos');
        $fechaActual = date('d/m/Y H:i');
        $pdf->Cell(0, 7, $this->encodeText('Fecha de emisión: ' . $fechaActual), 0, 1, 'R');
        $pdf->Ln(2);

        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Cell(45, 7, $this->encodeText('Número de venta:'), 0, 0, 'L');
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell(0, 7, $this->encodeText((string) $numeroVenta), 0, 1, 'L');

        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Cell(45, 7, $this->encodeText('Fecha:'), 0, 0, 'L');
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell(0, 7, $this->encodeText($fecha), 0, 1, 'L');

        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Cell(45, 7, $this->encodeText('Cliente:'), 0, 0, 'L');
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell(0, 7, $this->encodeText($cliente), 0, 1, 'L');

        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Cell(45, 7, $this->encodeText('Forma de pago:'), 0, 0, 'L');
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell(0, 7, $this->encodeText($formaPago), 0, 1, 'L');

        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Cell(45, 7, $this->encodeText('Estado:'), 0, 0, 'L');
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell(0, 7, $this->encodeText($estadoTexto), 0, 1, 'L');

        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Cell(45, 7, $this->encodeText('Vendedor:'), 0, 0, 'L');
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell(0, 7, $this->encodeText($vendedor), 0, 1, 'L');
        $pdf->Ln(3);

        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(20, 8, $this->encodeText('Cant.'), 1, 0, 'C', true);
        $pdf->Cell(70, 8, $this->encodeText('Producto'), 1, 0, 'L', true);
        $pdf->Cell(35, 8, $this->encodeText('P. Unitario'), 1, 0, 'R', true);
        $pdf->Cell(30, 8, $this->encodeText('Subtotal'), 1, 1, 'R', true);

        $pdf->SetFont('Helvetica', '', 9);
        if (!empty($detalles)) {
            foreach ($detalles as $item) {
                $cantidad = (float) ($item['cantidad'] ?? 0);
                $precio = (float) ($item['precio_unitario'] ?? 0);
                $subtotal = (float) ($item['subtotal'] ?? ($cantidad * $precio));

                $pdf->Cell(20, 8, $this->encodeText((string) $cantidad), 1, 0, 'C');
                $pdf->Cell(70, 8, $this->encodeText((string) ($item['nombre'] ?? '')), 1, 0, 'L');
                $pdf->Cell(35, 8, $this->encodeText('$' . number_format($precio, 2, ',', '.')), 1, 0, 'R');
                $pdf->Cell(30, 8, $this->encodeText('$' . number_format($subtotal, 2, ',', '.')), 1, 1, 'R');
            }
        } else {
            $pdf->Cell(0, 8, $this->encodeText('No hay detalles cargados para esta venta.'), 1, 1, 'C');
        }

        $pdf->Ln(2);
        $pdf->SetFont('Helvetica', 'B', 11);
        $pdf->Cell(0, 8, $this->encodeText('TOTAL: $' . number_format($total, 2, ',', '.')), 0, 1, 'R');
        $pdf->Ln(4);
        $pdf->SetFont('Helvetica', '', 9);
        $pdf->MultiCell(0, 5, $this->encodeText('Gracias por su compra. Este comprobante representa la venta registrada en el sistema.'));

        $pdf->Output('I', 'Recibo_Venta_' . $id . '.pdf');
        exit();
    }

    $ventas = $service->list([]);

    $pdf = new \FPDF('P', 'mm', 'A4');
    $pdf->AddPage();

    $pdf->SetFont('Helvetica', 'B', 16);
    $pdf->Cell(0, 10, $this->encodeText('Reporte de Ventas'), 0, 1, 'C');
    $pdf->Ln(2);

    $pdf->SetFont('Helvetica', '', 10);
    date_default_timezone_set('America/Argentina/Rio_Gallegos');
    $fechaActual = date('d/m/Y H:i');
    $pdf->Cell(0, 10, $this->encodeText('Fecha de emisión: ' . $fechaActual), 0, 1, 'R');
    $pdf->Ln(5);

    $pdf->SetFont('Helvetica', 'B', 10);
    $pdf->SetFillColor(230, 230, 230);

    $pdf->Cell(20, 10, $this->encodeText('N°'), 1, 0, 'C', true);
    $pdf->Cell(30, 10, $this->encodeText('Fecha'), 1, 0, 'C', true);
    $pdf->Cell(40, 10, $this->encodeText('Cliente'), 1, 0, 'C', true);
    $pdf->Cell(35, 10, $this->encodeText('Pago'), 1, 0, 'C', true);
    $pdf->Cell(30, 10, $this->encodeText('Total'), 1, 0, 'C', true);
    $pdf->Cell(25, 10, $this->encodeText('Estado'), 1, 1, 'C', true);

    $pdf->SetFont('Helvetica', '', 9);

    foreach ($ventas as $venta) {
        $estado = $venta['estado'] == 1 ? 'Activa' : 'Anulada';
        $pdf->Cell(20, 10, $this->encodeText((string)($venta['numero_venta'] ?? '')), 1, 0, 'C');
        $pdf->Cell(30, 10, $this->encodeText((string)($venta['fecha'] ?? '')), 1, 0, 'L');
        $pdf->Cell(40, 10, $this->encodeText((string)($venta['cliente'] ?? '')), 1, 0, 'L');
        $pdf->Cell(35, 10, $this->encodeText((string)($venta['forma_pago'] ?? '')), 1, 0, 'L');
        $pdf->Cell(30, 10, $this->encodeText('$' . number_format((float)($venta['total'] ?? 0), 2, ',', '.')), 1, 0, 'R');
        $pdf->Cell(25, 10, $this->encodeText($estado), 1, 1, 'C');
    }

    $pdf->Output('I', 'Reporte_Ventas.pdf');
    exit();
}
}