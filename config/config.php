<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}




define('BASE_URL', 'http://fairclass.devsweett.com/');
define('SITE_NAME', 'fAIrclass');
define('DEFAULT_ROLE', 'student');


define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'fairclass_db');
define('DB_CHARSET', 'utf8');


define('ROOT_DIR', realpath(dirname(__FILE__) . '/..'));
define('CONTROLLERS_DIR', ROOT_DIR . '/controllers');
define('MODELS_DIR', ROOT_DIR . '/models');
define('SERVICES_DIR', ROOT_DIR . '/services'); 
define('VIEWS_DIR', ROOT_DIR . '/views');
define('PARTIALS_DIR', VIEWS_DIR . '/partials');
define('ASSETS_URL', BASE_URL . 'assets');
define('INCLUDES_DIR', ROOT_DIR . '/includes');
define('UPLOADS_DIR', "http://localhost" . '/' );    
define('UPLOADS_PATH', ROOT_DIR );    


define('ENVIRONMENT', 'development'); 


if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    ini_set('error_log', ROOT_DIR . '/error.log');
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', ROOT_DIR . '/error.log');
}


spl_autoload_register(function ($className) {
    
    $classPath = str_replace('\\', '/', $className);
    
    
    $paths = [
        SERVICES_DIR . "/{$classPath}.php",
        MODELS_DIR . "/{$classPath}.php",
        CONTROLLERS_DIR . "/{$classPath}.php",
        INCLUDES_DIR . "/{$classPath}.php"
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
    
    if (ENVIRONMENT === 'development') {
        error_log("Clase {$className} no encontrada. Buscada en: " . implode(', ', $paths));
    }
});


require_once __DIR__ . '/database.php';
$pdo = getPDOConnection(); 
$GLOBALS['pdo'] = $pdo;    


require_once INCLUDES_DIR . '/helpers.php';
require_once INCLUDES_DIR . '/auth_helpers.php';


header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
header('Strict-Transport-Security: max-age=31536000; includeSubDomains'); 


if (ENVIRONMENT === 'production' && empty($_SERVER['HTTPS'])) {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit();
}

