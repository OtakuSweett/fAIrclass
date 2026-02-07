<?php
class AuthController {
    private $pdo;

    public function __construct() {
        $this->pdo = getDatabaseConnection();
    }
public function register() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRF
            $csrf = $_POST['csrf_token'] ?? '';
            if (!validate_csrf_token($csrf)) {
                $_SESSION['flash_errors'] = ['Token CSRF inválido'];
                header("Location: index.php?action=register");
                exit();
            }

            // Cloudflare Turnstile (optional)
            $turnstileResp = $_POST['cf-turnstile-response'] ?? null;
            if (!verify_turnstile_response($turnstileResp)) {
                $_SESSION['flash_errors'] = ['Captcha inválido o faltante'];
                header("Location: index.php?action=register");
                exit();
            }
        
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name = trim($_POST['last_name'] ?? '');
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['password'] ?? '');
        $confirm_password = trim($_POST['confirm_password'] ?? '');
        $role = $_POST['role'] ?? DEFAULT_ROLE;

        
        $full_name = $first_name . ' ' . $last_name;

        
        $errors = [];
        
        if (empty($first_name)) {
            $errors[] = "El nombre es requerido";
        }

        if (empty($last_name)) {
            $errors[] = "El apellido es requerido";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "El correo electrónico no es válido";
        }

        if (strlen($password) < 8) {
            $errors[] = "La contraseña debe tener al menos 8 caracteres";
        }

        if ($password !== $confirm_password) {
            $errors[] = "Las contraseñas no coinciden";
        }

        
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = "El correo electrónico ya está registrado";
        }

        if (empty($errors)) {
            
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            
            $stmt = $this->pdo->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->execute([$full_name, $email, $hashed_password, $role]);

            
            $user_id = $this->pdo->lastInsertId();
            $this->setUserSession($user_id);

            header("Location: index.php?action=classes");
            exit();
        } else {
            
            $_SESSION['flash_errors'] = $errors;
            header("Location: index.php?action=register");
            exit();
        }
    } else {
        
        require 'views/auth/register.php';
    }
}

    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRF
            $csrf = $_POST['csrf_token'] ?? '';
            if (!validate_csrf_token($csrf)) {
                $_SESSION['flash_errors'] = ['Token CSRF inválido'];
                header("Location: index.php?action=login");
                exit();
            }

            // Turnstile
            $turnstileResp = $_POST['cf-turnstile-response'] ?? null;
            if (!verify_turnstile_response($turnstileResp)) {
                $_SESSION['flash_errors'] = ['Captcha inválido o faltante'];
                header("Location: index.php?action=login");
                exit();
            }
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $password = trim($_POST['password']);

            $errors = [];

            
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    $this->setUserSession($user['id']);
                    header("Location: index.php?action=classes");
                    exit();
                } else {
                    $errors[] = "Credenciales incorrectas";
                }
            } else {
                $errors[] = "El usuario no existe";
            }

            
            require 'views/auth/login.php';
        } else {
            require 'views/auth/login.php';
        }
    }

    
    public function logout() {
        $_SESSION = array();
        session_destroy();
        header("Location: index.php");
        exit();
    }

    
    private function setUserSession($user_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'full_name' => $user['full_name'],
            'role' => $user['role'],
            'logged_in' => true
        ];
    }

    
    public static function checkAuth() {
        if (!isset($_SESSION['user']['logged_in']) || !$_SESSION['user']['logged_in']) {
            header("Location: index.php?action=login");
            exit();
        }
    }

    
    public static function checkRole($allowedRoles = []) {
        self::checkAuth();
        
        if (!in_array($_SESSION['user']['role'], $allowedRoles)) {
            header("Location: index.php?action=unauthorized");
            exit();
        }
    }


public function profille() {
    self::checkAuth();
    $userId = $_SESSION['user']['id'];
    $userModel = new UserModel($this->pdo);

    
    $fotoPerfil = $this->obtenerFotoPerfil($userId, $this->pdo, true);

    
    $user = $userModel->getUserById($userId);

    require 'views/auth/profile.php';
}



public function updateProfile() {
    self::checkAuth();
    $userId = $_SESSION['user']['id'];
    $userModel = new UserModel($this->pdo);

    
    $full_name = trim($_POST['full_name'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    $errors = [];

    
    if (empty($full_name)) $errors[] = "El nombre completo es obligatorio";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Correo inválido";

    
    $userByEmail = $userModel->getUserByEmail($email);
    if ($userByEmail && $userByEmail['id'] != $userId) {
        $errors[] = "El correo ya está en uso por otro usuario";
    }

    
    $profile_picture_path = null;
    if (!empty($_FILES['profile_picture']['tmp_name'])) {
        $ext = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ext, $allowed)) {
            if (!file_exists('uploads')) mkdir('uploads', 0777, true);
            $filename = 'uploads/pfp_' . $userId . '_' . time() . '.' . $ext;

            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $filename)) {
                $profile_picture_path = $filename;
            } else {
                $errors[] = "Error al subir la imagen de perfil.";
            }
        } else {
            $errors[] = "Formato de imagen inválido. Usa JPG, PNG o WEBP.";
        }
    }

    
    $password_updated = false;
    if (!empty($current_password) || !empty($new_password) || !empty($confirm_password)) {
        if (empty($current_password)) $errors[] = "Debes ingresar la contraseña actual";
        if (empty($new_password) || strlen($new_password) < 6) $errors[] = "La nueva contraseña debe tener al menos 6 caracteres";
        if ($new_password !== $confirm_password) $errors[] = "Las nuevas contraseñas no coinciden";

        if (empty($errors)) {
            $userData = $userModel->getUserById($userId);
            if (!$userData || !password_verify($current_password, $userData['password'])) {
                $errors[] = "La contraseña actual es incorrecta";
            } else {
                $password_updated = true;
            }
        }
    }

    
    if (empty($errors)) {
        $data = [
            'full_name' => $full_name,
            'email' => $email
        ];

        if ($password_updated) {
            $data['password'] = password_hash($new_password, PASSWORD_DEFAULT);
        }

        $userModel->updateUser($userId, $data);

        if ($profile_picture_path) {
            $userModel->updateProfilePicture($userId, $profile_picture_path);
            $_SESSION['user']['profile_picture'] = $profile_picture_path;
        }

        $_SESSION['user']['full_name'] = $full_name;
        $_SESSION['user']['email'] = $email;

        $_SESSION['flash_success'] = "Perfil actualizado correctamente";
        header("Location: index.php?action=profille");
        exit();
    } else {
        $_SESSION['flash_errors'] = $errors;
        header("Location: index.php?action=edit_profile");
        exit();
    }
}

public function refreshUserProfilePicture() {
    if (!isset($_SESSION['user']['id'])) {
        return null;
    }

    $userId = $_SESSION['user']['id'];
    $userModel = new UserModel($this->pdo); 
    $profilePicture = $userModel->getProfilePicture($userId);

    $_SESSION['user']['profile_picture'] = $profilePicture;

    return $profilePicture;
}

/**
 * Obtiene la URL válida de la foto de perfil de un usuario.
 * Si no tiene foto válida devuelve null (para mostrar la inicial en la vista).
 * 
 * @param int $userId ID del usuario a consultar.
 * @param PDO $pdo Conexión PDO a la base de datos.
 * @param bool $updateSession (Opcional) Actualiza sesión si es usuario actual. Default false.
 * @return string|null Ruta o URL de la foto, o null si no tiene.
 */
function obtenerFotoPerfil(int $userId, PDO $pdo, bool $updateSession = false): ?string {
    $stmt = $pdo->prepare("SELECT profile_picture, full_name FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) return null;

    $foto = $result['profile_picture'] ?? '';
    $fullName = $result['full_name'] ?? '';

    if (empty($foto)) {
        
        return null;
    }

    if (preg_match('#^https?://#i', $foto)) {
        if ($updateSession && isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $userId) {
            $_SESSION['user']['profile_picture'] = $foto;
        }
        return $foto;
    }

    $fotoLimpia = '/' . ltrim($foto, '/');
    $rutaFisica = $_SERVER['DOCUMENT_ROOT'] . $fotoLimpia;

    if (!file_exists($rutaFisica) || !is_file($rutaFisica)) {
        return null;
    }

    if ($updateSession && isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $userId) {
        $_SESSION['user']['profile_picture'] = $fotoLimpia;
    }

    return $fotoLimpia;
}


}
?>