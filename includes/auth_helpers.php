<?php

function is_logged_in() {
    return isset($_SESSION['user']) && !empty($_SESSION['user']['id']);
}


function has_role($role) {
    return is_logged_in() && $_SESSION['user']['role'] === $role;
}


function has_any_role($roles = []) {
    return is_logged_in() && in_array($_SESSION['user']['role'], $roles);
}


function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validate_csrf_token($token) {
    return isset($_SESSION['csrf_token']) 
        && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Verifica la respuesta de Cloudflare Turnstile si está configurado.
 * Devuelve true si no está configurado (comportamiento por defecto) o si la verificación es exitosa.
 */
function verify_turnstile_response(?string $token): bool {
    $secret = env('CF_TURNSTILE_SECRET', '') ;
    if (empty($secret)) {
        // No configurado, no bloquear
        return true;
    }
    if (empty($token)) return false;

    $ch = curl_init('https://challenges.cloudflare.com/turnstile/v0/siteverify');
    $data = http_build_query([
        'secret' => $secret,
        'response' => $token,
        'remoteip' => $_SERVER['REMOTE_ADDR'] ?? null
    ]);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_SSL_VERIFYPEER => true
    ]);
    $resp = curl_exec($ch);
    curl_close($ch);
    if (!$resp) return false;
    $json = json_decode($resp, true);
    return !empty($json['success']);
}


function is_owner($resourceUserId) {
    return is_logged_in() && $_SESSION['user']['id'] == $resourceUserId;
}


function password_hash_custom($password) {
    return password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
}


function password_verify_custom($password, $hash) {
    return password_verify($password, $hash);
}