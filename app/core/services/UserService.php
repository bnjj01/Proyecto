<?php
namespace app\core\services;

use app\core\models\dto\UserDto;
use app\core\models\dao\UserDao;
use app\core\services\base\BaseService;
use app\libs\database\Connection;

final class UserService extends BaseService{

    private UserDao $userDao;

    function __construct(){
        $this->userDao = new UserDao(Connection::get());

        parent::__construct($this->userDao);
    }

    public function save(UserDto $dto): void{
        $this->validateForSave($dto);
        $data = $dto->toArrayForSave();

        if (isset($data['clave']) && !empty($data['clave'])) {
            $data['clave'] = password_hash($data['clave'], PASSWORD_BCRYPT);
        }

        $this->dao->save($data);
    } 

    public function update(UserDto $dto): void{
        $this->validate($dto);
        $data = $dto->toArrayForUpdate();
        
        if (isset($data['clave']) && !empty($data['clave'])) {
            $data['clave'] = password_hash($data['clave'], PASSWORD_BCRYPT);
        }
        
        $this->modify($data);
    }

    public function list(array $filters = []): array {
        return $this->dao->list($filters);
    }

    public function load(int $id): array {
        return $this->dao->load($id);
    }

    private function validate(UserDto $dto): void{
        if($dto->getApellido() == ""){
            throw new \Exception("El campo <strong>apellido</strong> es obligatorio");
        }
        if($dto->getNombre() == ""){
            throw new \Exception("El campo <strong>nombre</strong> es obligatorio");
        }
        if($dto->getCuenta() == ""){
            throw new \Exception("El campo <strong>cuenta</strong> es obligatorio");
        }
        if($dto->getPerfil() == ""){
            throw new \Exception("Debe especificar el <strong>perfil</strong> de la cuenta.");
        }
        if (!filter_var($dto->getCorreo(), FILTER_VALIDATE_EMAIL)) {
        throw new \Exception("El campo <strong>correo</strong> debe ser una dirección de correo electrónico válida.");
        }
    }

    private function validateForSave(UserDto $dto): void{
        $this->validate($dto);
        if($dto->getClave() == ""){
            throw new \Exception("No se especificó una <strong>clave</strong> válida");
        }
    }

    public function habilitarUsuario(int $id): void {
        try {
            $this->userDao->enable($id);
        } catch (\Exception $e) {
            throw new \Exception("Error al habilitar el usuario: " . $e->getMessage());
        }
    }

    public function suspenderUsuario(int $id): void {
        try {
            $this->userDao->disable($id);
        } catch (\Exception $e) {
            throw new \Exception("Error al suspender el usuario: " . $e->getMessage());
        }
    }

    public function resetearClave(int $id): void {
        try {
            $this->userDao->reset($id);
        } catch (\Exception $e) {
            throw new \Exception("Error al restablecer la clave del usuario: " . $e->getMessage());
        }
    }
}