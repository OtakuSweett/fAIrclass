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


function is_owner($resourceUserId) {
    return is_logged_in() && $_SESSION['user']['id'] == $resourceUserId;
}


function password_hash_custom($password) {
    return password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
}


function password_verify_custom($password, $hash) {
    return password_verify($password, $hash);
}