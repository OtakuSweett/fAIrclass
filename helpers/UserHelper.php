<?php

function obtenerFotoPerfil(int $userId, PDO $pdo, bool $updateSession = false): ?string {
    $stmt = $pdo->prepare("SELECT profile_picture FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) return null;

    $foto = $result['profile_picture'] ?? '';

    if (empty($foto)) return null;

    if (preg_match('#^https?://#i', $foto)) {
        if ($updateSession && isset($_SESSION['user']['id']) && $_SESSION['user']['id'] === $userId) {
            $_SESSION['user']['profile_picture'] = $foto;
        }
        return $foto;
    }

    $fotoLimpia = '/' . ltrim($foto, '/');
    $rutaFisica = $_SERVER['DOCUMENT_ROOT'] . $fotoLimpia;

    if (!file_exists($rutaFisica) || !is_file($rutaFisica)) {
        return null;
    }

    if ($updateSession && isset($_SESSION['user']['id']) && $_SESSION['user']['id'] === $userId) {
        $_SESSION['user']['profile_picture'] = $fotoLimpia;
    }

    return $fotoLimpia;
}
