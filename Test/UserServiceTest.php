<?php

require_once __DIR__ . '/../app/config/app.php';
require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';

use app\core\models\dto\UserDto;
use app\core\services\UserService;
use app\core\models\enums\UserProfile;

try{
    $service = new UserService();
    $dto = new UserDto([
        'apellido'  => 'Pozzo',
        'nombres'   => 'Benjamin',
        'cuenta'    => 'benja.pozzo',
        'perfil'    => UserProfile::ADMINISTRADOR->value,
        'clave'     => 'benja123',
        'correo'    => 'bepoamhu.2016@gmail.com'
        ]);
    $service->save($dto);
    echo 'Usuario registrado con éxito';
}
catch(\PDOException $ex){
    echo 'Error inesperado en BD: ' . $ex->getMessage();
}
catch(\Exception $ex){
    echo 'Error inesperado: ' . $ex->getMessage();
}