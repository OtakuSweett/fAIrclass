<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}




// Detect BASE_URL dynamically from the current request when possible (useful for localhost/dev)
if (php_sapi_name() !== 'cli' && isset($_SERVER['HTTP_HOST'])) {
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
    $scheme = $https ? 'https' : 'http';
    define('BASE_URL', $scheme . '://' . $_SERVER['HTTP_HOST'] . '/');
} else {
    // Fallback for CLI or when HTTP_HOST is not available
    define('BASE_URL', 'http://fairclass.devsweett.com/');
}
define('SITE_NAME', 'fAIrclass');
define('DEFAULT_ROLE', 'student');


// Load environment variables from .env if present (simple loader)
// Prefer config/.env (safer) and fall back to project root .env
// Use dirname(__DIR__) to get the project root before ROOT_DIR is defined
$projectRoot = dirname(__DIR__);
$envCandidates = [
    $projectRoot . '/config/.env',
    $projectRoot . '/.env'
];
$envPath = null;
foreach ($envCandidates as $candidate) {
    if (file_exists($candidate)) {
        $envPath = $candidate;
        break;
    }
}
if ($envPath && file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0) {
            continue;
        }
        if (strpos($line, '=') === false) {
            continue;
        }
        list($key, $val) = explode('=', $line, 2);
        $key = trim($key);
        $val = trim($val);
        if ((strlen($val) >= 2) && (($val[0] === '"' && substr($val, -1) === '"') || ($val[0] === "'" && substr($val, -1) === "'"))) {
            $val = substr($val, 1, -1);
        }
        putenv("{$key}={$val}");
        $_ENV[$key] = $val;
        $_SERVER[$key] = $val;
    }
}

function env($key, $default = null) {
    $v = getenv($key);
    if ($v !== false) {
        return $v;
    }
    if (isset($_ENV[$key])) {
        return $_ENV[$key];
    }
    return $default;
}

define('DB_HOST', env('DB_HOST', 'localhost'));
define('DB_USER', env('DB_USER', 'root'));
define('DB_PASS', env('DB_PASS', ''));
define('DB_NAME', env('DB_NAME', 'fairclass_db'));
define('DB_CHARSET', env('DB_CHARSET', 'utf8'));


define('ROOT_DIR', realpath(dirname(__FILE__) . '/..'));
define('CONTROLLERS_DIR', ROOT_DIR . '/controllers');
define('MODELS_DIR', ROOT_DIR . '/models');
define('SERVICES_DIR', ROOT_DIR . '/services'); 
define('VIEWS_DIR', ROOT_DIR . '/views');
define('PARTIALS_DIR', VIEWS_DIR . '/partials');
define('ASSETS_URL', BASE_URL . 'assets');
define('INCLUDES_DIR', ROOT_DIR . '/includes');
// Uploads URL and path
define('UPLOADS_DIR', rtrim(BASE_URL, '/') . '/uploads');
define('UPLOADS_PATH', ROOT_DIR . '/uploads');


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

