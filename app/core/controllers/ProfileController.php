<?php
namespace app\core\controllers;

use app\core\controllers\base\BaseController;
use app\core\services\UserService;
use app\libs\http\Request;
use app\libs\http\Response;

class ProfileController extends BaseController {

    public int $currentUserId;
    public array $profile = [];

    public function __construct()
    {
        parent::__construct();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['perfil']) || !in_array($_SESSION['perfil'], ['Operador', 'Administrador'])) {
            header("Location: " . APP_URL . "home");
            exit();
        }

        $this->currentUserId = isset($_SESSION['usuarioId']) ? (int) $_SESSION['usuarioId'] : 0;
    }

    public function index(Request $request, Response $response)
    {
        $this->setCurrentView($request);
        $this->modules = ["app/js/profile/index.js"];
        $this->styles = ["app/css/user-index.css"];

        $service = new UserService();
        $this->profile = $service->load($this->currentUserId);

        require_once(APP_FILE_TEMPLATE);
    }

    public function changePassword(Request $request, Response $response)
    {
        $data = $request->getDataFromInput() ?? $_POST;
        $password = trim($data['clave'] ?? '');
        $confirm = trim($data['confirmarClave'] ?? '');

        if ($password === '' || $confirm === '') {
            throw new \Exception("Debe completar ambos campos de contraseña.");
        }
        if ($password !== $confirm) {
            throw new \Exception("Las contraseñas no coinciden.");
        }
        $service = new UserService();
        $service->changePassword($this->currentUserId, $password);

        $response->setMessage("Contraseña actualizada con éxito.");
        $response->send(true);
    }
}