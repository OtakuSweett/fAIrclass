<?php
class ClassController {
    private $pdo;
    private $classModel;
    private $activityModel;
    private $enrollmentModel;
    
    public function __construct() {
        $this->pdo = getDatabaseConnection();
        $this->classModel = new ClassModel($this->pdo);
        $this->activityModel = new ActivityModel($this->pdo);
        $this->enrollmentModel = new EnrollmentModel($this->pdo);
        AuthController::checkAuth();
    }




    public function create() {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $className = trim($_POST['class_name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $userId = $_SESSION['user']['id'];

            if (empty($className)) {
                $errors[] = "El nombre de la clase es requerido.";
            } elseif (mb_strlen($className) > 100) {
                $errors[] = "El nombre no puede exceder 100 caracteres.";
            }

            if (empty($errors)) {
                $classCode = $this->generateClassCode();

                if ($classId = $this->classModel->createClass($userId, $className, $classCode, $description)) {
                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => "¡Clase creada exitosamente! Código: $classCode"
                    ];
                    header("Location: index.php?action=classes");
                    exit;
                } else {
                    $errors[] = "Error al crear la clase. Inténtalo nuevamente.";
                }
            }
        }

        require 'views/classes/create.php';
    }

    /**
     * Dashboard que lista las clases del usuario
     */
    public function dashboard() {
        $userId = $_SESSION['user']['id'];
        $classes = $this->classModel->getUserClasses($userId);
        require 'views/classes/dashboard.php';
    }

    /**
     * Unirse a clase con código
     */
    public function joinClass() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $classCode = trim($_POST['class_code'] ?? '');
            $userId = $_SESSION['user']['id'];

            $class = $this->classModel->getClassByCode($classCode);

            if ($class) {
                if (!$this->classModel->isEnrolled($userId, $class['id'])) {
                    if ($this->classModel->enrollUser($userId, $class['id'])) {
                        $_SESSION['flash'] = [
                            'type' => 'success',
                            'message' => "Te has unido a la clase {$class['class_name']}."
                        ];
                    } else {
                        $_SESSION['flash'] = [
                            'type' => 'danger',
                            'message' => 'Error al unirse a la clase.'
                        ];
                    }
                } else {
                    $_SESSION['flash'] = [
                        'type' => 'warning',
                        'message' => 'Ya estás inscrito en esta clase.'
                    ];
                }
            } else {
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => 'Código de clase inválido.'
                ];
            }

            header("Location: index.php?action=classes");
            exit;
        }

        require 'views/classes/join.php';
    }

    /**
     * Ver detalles de la clase (actividades y alumnos)
     */
public function view(int $classId) {
    $class = $this->classModel->getClassById($classId);

    if (!$class) {
        $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => 'Clase no encontrada.'
        ];
        header("Location: index.php?action=classes");
        exit;
    }

    $userId = $_SESSION['user']['id'];
    $isTeacher = ($class['teacher_id'] == $userId);
    $isEnrolled = $this->classModel->isEnrolled($userId, $classId);

    if (!$isTeacher && !$isEnrolled) {
        $this->denyAccess();
    }

    $enrolledStudents = $this->classModel->getEnrolledStudents($classId);
    $activities = $this->classModel->getClassActivities($classId);

    
    
if (!$isTeacher) {
    foreach ($activities as &$activity) {
        $activity['entregada'] = $this->activityModel->isActivityDelivered($activity['id'], $userId);
    }
    unset($activity);
}


    require 'views/classes/view.php';
}

public function editClass($classId) {
    $classModel = new ClassModel($this->pdo);
    $class = $classModel->getClassById($classId);
    
    
    if (!$class || !$classModel->isClassTeacher($classId, $_SESSION['user']['id'])) {
        $this->denyAccess();
    }
    
    $errors = [];
    $classData = [
        'class_name' => $class['class_name'],
        'description' => $class['description'],
        'class_code' => $class['class_code']
    ];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $classData['class_name'] = trim($_POST['class_name'] ?? '');
        $classData['description'] = trim($_POST['description'] ?? '');
        
        if (empty($classData['class_name'])) {
            $errors[] = "El nombre de la clase es requerido";
        }
        
        if (empty($errors)) {
            try {
                $classModel->updateClass($classId, $classData);
                
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Clase actualizada exitosamente!'
                ];
                header("Location: index.php?action=view_class&id=$classId");
                exit();
                
            } catch (Exception $e) {
                $errors[] = "Error al actualizar la clase: " . $e->getMessage();
                error_log("Error al editar clase: " . $e->getMessage());
            }
        }
    }
    
    require 'views/classes/edit.php';
}
    /**
     * Eliminar clase (solo el creador o admin)
     */
    public function delete(int $classId) {
        $class = $this->classModel->getClassById($classId);
        $userId = $_SESSION['user']['id'];

        if (!$class) {
            $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => 'Clase no encontrada.'
            ];
            header("Location: index.php?action=classes");
            exit;
        }

        
        if (($class['teacher_id'] == $userId) || ($_SESSION['user']['role'] === 'admin')) {
            if ($this->classModel->deleteClass($classId)) {
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Clase eliminada correctamente.'
                ];
            } else {
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => 'Error al eliminar la clase.'
                ];
            }
        } else {
            $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => 'No tienes permiso para esta acción.'
            ];
        }

        header("Location: index.php?action=classes");
        exit;
    }

    /**
     * Gestionar inscripciones de estudiantes (solo el creador o admin)
     */
public function manageEnrollments(int $classId) {
    $class = $this->classModel->getClassById($classId);
    $userId = $_SESSION['user']['id'];

    if (!$class) {
        $this->flashAndRedirect('danger', 'Clase no encontrada', 'index.php?action=classes');
    }

    
    if (($class['teacher_id'] != $userId) && ($_SESSION['user']['role'] !== 'admin')) {
        $this->flashAndRedirect('danger', 'No tienes permiso para administrar esta clase', 'index.php?action=classes');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        if (isset($_POST['student_id'])) {
            $studentId = (int)$_POST['student_id'];
            if (isset($_POST['action_add'])) {
                if (!$this->classModel->isEnrolled($studentId, $classId)) {
                    $this->classModel->enrollUser($studentId, $classId);
                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => 'Usuario agregado a la clase.'
                    ];
                } else {
                    $_SESSION['flash'] = [
                        'type' => 'warning',
                        'message' => 'El usuario ya está inscrito en la clase.'
                    ];
                }
            } elseif (isset($_POST['action_remove'])) {
                $this->classModel->removeEnrollment($studentId, $classId);
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Usuario eliminado de la clase.'
                ];
            }
        }

        
        if (isset($_POST['student_email'])) {
            $email = trim($_POST['student_email']);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                
                $user = $this->enrollmentModel->getUserByEmail($email);
                
                if ($user) {
                    if (!$this->classModel->isEnrolled($user['id'], $classId)) {
                        $this->classModel->enrollUser($user['id'], $classId);
                        $_SESSION['flash'] = [
                            'type' => 'success',
                            'message' => "Usuario agregado a la clase: {$user['full_name']} ({$user['email']})"
                        ];
                    } else {
                        $_SESSION['flash'] = [
                            'type' => 'warning',
                            'message' => "El usuario ya está inscrito en la clase."
                        ];
                    }
                } else {
                    $_SESSION['flash'] = [
                        'type' => 'danger',
                        'message' => "No se encontró ningún usuario con el correo {$email}."
                    ];
                }
            } else {
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => "Correo inválido."
                ];
            }
        }

        header("Location: index.php?action=manage_enrollments&class_id=$classId");
        exit;
    }

    $enrolledStudents = $this->classModel->getEnrolledStudents($classId);
    $availableStudents = $this->enrollmentModel->getUsersNotEnrolled($classId);

    require 'views/classes/manage_enrollments.php';
}

    /**
     * Generar código único alfanumérico para la clase (6 caracteres)
     */
    private function generateClassCode(): string {
        $characters = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
        do {
            $code = '';
            for ($i = 0; $i < 6; $i++) {
                $code .= $characters[random_int(0, strlen($characters) - 1)];
            }
        } while ($this->classModel->codeExists($code));

        return $code;
    }

    private function flashAndRedirect($type, $message, $location) {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
        header("Location: $location");
        exit;
    }

    private function denyAccess() {
        $this->flashAndRedirect('danger', 'Acceso denegado', 'index.php');
    }
}