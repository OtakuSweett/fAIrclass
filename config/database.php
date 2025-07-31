<?php
try {
    
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::ATTR_PERSISTENT         => false
    ];

    $pdo = new PDO(
        $dsn,  
        DB_USER, 
        DB_PASS,
        $options
    );

    
    if (ENVIRONMENT === 'development') {
        $tables = $pdo->query("SHOW TABLES LIKE 'users'")->fetch();
        if (!$tables) {
            throw new Exception("Ejecuta el archivo SQL de instalación primero");
        }
    }

} catch (PDOException $e) {
    error_log("Error de conexión: " . $e->getMessage());
    die("Error crítico: Revisa la configuración de la base de datos");
} catch (Exception $e) {
    error_log("Error de estructura: " . $e->getMessage());
    die("Error de configuración: " . $e->getMessage());
}

function getDatabaseConnection() {
    global $pdo;
    return $pdo;
}

register_shutdown_function(function() {
    $GLOBALS['pdo'] = null;
});

function getPDOConnection(): PDO {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    return new PDO($dsn, DB_USER, DB_PASS, $options);
}