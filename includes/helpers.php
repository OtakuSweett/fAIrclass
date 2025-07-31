<?php

function sanitize_input($data, $type = 'string') {
    switch ($type) {
        case 'email':
            return filter_var(trim($data), FILTER_SANITIZE_EMAIL);
        case 'int':
            return filter_var($data, FILTER_SANITIZE_NUMBER_INT);
        case 'float':
            return filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT);
        case 'url':
            return filter_var($data, FILTER_SANITIZE_URL);
        default:
            return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
}


function format_date($mysqlDate, $format = 'd/m/Y H:i') {
    $date = new DateTime($mysqlDate);
    return $date->format($format);
}


function redirect($url, $message = null, $type = 'success') {
    if ($message) {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }
    header("Location: $url");
    exit();
}

function is_ajax() {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}


function generate_random_code($length = 8) {
    $characters = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $code;
}