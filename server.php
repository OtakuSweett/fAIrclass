<?php
// Simple router for PHP built-in server that denies access to sensitive files and directories
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Deny access to dotfiles (like .env), the config directory, sql, vendor, composer, node_modules,
// and common sensitive files (README, composer files, docker files, nginx configs, git files, etc.)
if (preg_match('#/(?:\.|config|sql|vendor|composer|node_modules)(?:/|$)#', $uri)
    || preg_match('#^/(?:README(?:\.md)?|composer\.(?:json|lock)|docker-compose\.yml|Dockerfile|\.gitignore|nginx[^/]*\.conf|server\.php|\.htaccess)(?:$|/)#i', $uri)
    || preg_match('#/.*\.(?:md|sql|env|lock)$#i', $uri)
    ) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
    echo '403 Forbidden';
    return true;
}

$requested = __DIR__ . $uri;
if ($uri !== '/' && file_exists($requested) && is_file($requested)) {
    // Let the built-in server serve the requested resource
    return false;
}

// Otherwise, route to index.php (front controller)
require_once __DIR__ . '/index.php';
