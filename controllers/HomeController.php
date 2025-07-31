<?php
class HomeController {
    private $classModel;
    private $activityModel;

    public function __construct() {
        $this->classModel = new ClassModel(getDatabaseConnection());
        $this->activityModel = new ActivityModel(getDatabaseConnection());
    }

    

    
    public function index() {
        if (isset($_SESSION['user'])) {
            header('Location: index.php?action=dashboard');
            exit();
        }
        
        $stats = [
            'total_classes' => $this->classModel->getTotalClasses(),
            'total_activities' => $this->activityModel->getTotalActivities(),
            'total_users' => (new UserModel(getDatabaseConnection()))->getTotalUsers()
        ];

        require 'views/home/index.php';
    }

        public function privacy() {


        require 'views/home/privacy.php';
    }
        public function terms() {


        require 'views/home/terms.php';
    }

    
    public function dashboard() {
        AuthController::checkAuth();
        
        $user = $_SESSION['user'];
        $data = [
            'user_classes' => $user['role'] === 'teacher' 
                ? $this->classModel->getClassesByTeacher($user['id'])
                : $this->classModel->getClassesByStudent($user['id']),
                
            'recent_activities' => $this->activityModel->getRecentActivities(5)
        ];

        require 'views/home/dashboard.php';
    }

    
    public function about() {
        require 'views/home/about.php';
    }

    
    public function contact() {
        require 'views/home/contact.php';
    }

    
    public function handleContact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

            $errors = [];
            
            if (empty($name)) $errors[] = "El nombre es requerido";
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email inválido";
            if (strlen($message) < 10) $errors[] = "Mensaje demasiado corto";

            if (empty($errors)) {
                
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Mensaje enviado correctamente'
                ];
            } else {
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => implode('<br>', $errors)
                ];
            }
            
            header('Location: index.php?action=contact');
            exit();
        }
    }

    
    public function maintenance() {
        http_response_code(503);
        require 'views/home/maintenance.php';
        exit();
    }
}