<?php 

include '../application/config/config.php';

// Link web del proyecto
define('BASE_URL', $settings['base_url']);

// Parametros de la base de datos
define('DB_HOST', $database['host']);
define('DB_USER', $database['user']);
define('DB_PASS', $database['password']);
define('DB_NAME', $database['database']);

// Controlador predefinido
define('DEFAULT_CONTROLLER', $default['default_controller']);