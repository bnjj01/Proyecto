<?php

//#########################################
// DIRECTORIOS Y URL BASE DE LA APLICACIÓN
//#########################################

const APP_URL = 'http://localhost/lab_prog_2026_Pozzo_Benjamin/public/';
define('APP_URI', $_SERVER['DOCUMENT_ROOT'] . '/lab_prog_2026_Pozzo_Benjamin/app/');

//const APP_URL = "https://www.innotecsistemas.com.ar/apps/sipger/";
//define('APP_URI', $_SERVER['DOCUMENT_ROOT'] . '/../sistemas/sipger/app/');

define('APP_DIR_TEMPLATE',  APP_URI . 'resources/template/');
define('APP_DIR_VIEWS',     APP_URI . 'resources/views/');
define('APP_DIR_REPORTS',   APP_URI . 'resources/reports/');

define('APP_FILE_TEMPLATE',     APP_DIR_TEMPLATE . 'template.php');
define('APP_FILE_LOG_ERRORS',   APP_URI.'logs/error.log');
define('APP_FILE_LOG_ACCESS',   APP_URI.'logs/access.log');

define('APP_FILE_LOGIN',    APP_DIR_VIEWS . 'authentication/index.php');
define('APP_FILE_LOGOUT',   APP_DIR_VIEWS . 'authentication/logout.php');

//#########################################
// CONTROLADOR Y ACCION POR DEFECTO
//#########################################

const APP_DEFAULT_CONTROLLER = "home";
const APP_DEFAULT_ACTION = "index";

const APP_AUTHENTICATION_CONTROLLER = "authentication";
const APP_LOGIN_ACTION = "login";
const APP_LOGOUT_ACTION = "logout";

//#########################################
// TOKEN DE VALIDACION INTERNO
//#########################################

const APP_TOKEN = '$2y$10$YKfOXUtphkqkMcZJm93pg.2Bh0tnofpo3czmxOHEGxuSTBW.xg7Bi';

//#########################################
// MANEJO DE SESIONES
//#########################################

const SESSION_FINISHED = 0;
const SESSION_PASSWORD_CHANGE = 1;
const SESSION_NOT_AUTHORIZED = 2;
const SESSION_OUT_OF_TIME = 3;
const SESSION_DISABLED_ACCOUNT = 4;
const SESSION_CONTROLLER_WITHOUT_PRIVILEGES = 5;
const SESSION_MENSAJES = array(
    0 => "¡Sesión finalizada!",
    1 => "¡Su clave fue cambiada!",
    2 => "¡Acceso no autorizado!",
    3 => "¡Acceso fuera de horario!",
    4 => "¡Su cuenta ha sido desactivada!",
    5 => "¡Su cuenta no tiene permisos para acceder al módulo!");