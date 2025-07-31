<?php
require __DIR__ . '/config/config.php';
require_once __DIR__ . '/helpers/UserHelper.php';

$action = $_GET['action'] ?? 'home';


switch ($action) {

    case 'login':
        (new AuthController())->login();
        break;

    case 'register':
        (new AuthController())->register();
        break;

    case 'profille':
        (new AuthController())->profille();
        break;

    case 'update_profile':
        (new AuthController())->updateProfile();
        break;

    case 'change_password':
        (new AuthController())->changePassword();
        break;

    case 'logout':
        (new AuthController())->logout();
        break;


    case 'dashboard':
        header("Location: index.php?action=classes");
        break;


    case 'classes':
        (new ClassController())->dashboard();
        break;

    case 'edit_class':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $classId = (int) $_GET['id'];
            (new ClassController())->editClass($classId);
        } else {
            http_response_code(400);
            echo "ID de clase inválido o no proporcionado.";
        }
        break;

    case 'grade_submission':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            (new ActivityController())->gradeSubmission((int)$_GET['id']);
        } else {
            header('Location: index.php?action=dashboard');
            exit;
        }
        break;
    
    case 'create_class':
        (new ClassController())->create();
        break;
    
    case 'join_class':
        (new ClassController())->joinClass();
        break;
    
    case 'view_class':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            (new ClassController())->view((int)$_GET['id']);
        } else {
            header('Location: index.php?action=classes');
            exit;
        }
        break;
    
    case 'delete_class':
        if (isset($_GET['class_id'])) {
            (new ClassController())->delete((int)$_GET['class_id']);
        }
        break;
    
    case 'manage_enrollments':
        if (isset($_GET['class_id']) && is_numeric($_GET['class_id'])) {
            (new ClassController())->manageEnrollments((int)$_GET['class_id']);
        } else {
            header('Location: index.php?action=classes');
            exit;
        }
        break;

    case 'class_activities':
        if (isset($_GET['class_id'])) {
            (new ClassController())->viewClassActivities((int)$_GET['class_id']);
        }
        break;        


    case 'create_activity':
        if (isset($_GET['class_id']) && is_numeric($_GET['class_id'])) {
            (new ActivityController())->create((int)$_GET['class_id']);
        } else {
            header('Location: index.php?action=classes');
            exit;
        }
        break;

    case 'edit_activity':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            (new ActivityController())->editActivity((int)$_GET['id']);
        } else {
            header('Location: index.php?action=dashboard');
            exit;
        }
        break;

    case 'delete_activity':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            (new ActivityController())->deleteActivity((int)$_GET['id']);
        } else {
            header('Location: index.php?action=dashboard');
            exit;
        }
        break;

    case 'delete_activity_resource':
        if (isset($_GET['resource_id']) && is_numeric($_GET['resource_id'])) {
            (new ActivityController())->deleteActivityResource((int)$_GET['resource_id']);
        } else {
            header('Location: index.php?action=dashboard');
            exit;
        }
        break;

    case 'view_activity':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            (new ActivityController())->view((int)$_GET['id']);
        } else {
            header('Location: index.php?action=dashboard');
            exit;
        }
        break;


    case 'submit_activity':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            (new ActivityController())->submit((int)$_GET['id']);
        } else {
            header('Location: index.php?action=dashboard');
            exit;
        }
        break;

    case 'edit_submission':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            (new ActivityController())->editSubmission((int)$_GET['id']);
        } else {
            header('Location: index.php?action=dashboard');
            exit;
        }
        break;

    case 'cancel_submission':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            (new ActivityController())->cancelSubmission((int)$_GET['id']);
        } else {
            header('Location: index.php?action=dashboard');
            exit;
        }
        break;

    case 'submissions':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            (new ActivityController())->listSubmissions((int)$_GET['id']);
        } else {
            header('Location: index.php?action=dashboard');
            exit;
        }
        break;

    case 'view_submission':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            (new ActivityController())->viewSubmission((int)$_GET['id']);
        } else {
            header('Location: index.php?action=dashboard');
            exit;
        }
        break;


    case 'generate_report':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            (new ActivityController())->generateReport((int)$_GET['id']);
        } else {
            header('Location: index.php?action=dashboard');
            exit;
        }
        break;

    case 'download_file':
        if (isset($_GET['file_id']) && is_numeric($_GET['file_id'])) {
            $type = $_GET['type'] ?? 'activity';
            (new ActivityController())->downloadFile((int)$_GET['file_id'], $type);
        } else {
            header('Location: index.php?action=dashboard');
            exit;
        }
        break;

    case 'terms':
        (new HomeController())->terms();
        break;    


            case 'privacy':
        (new HomeController())->privacy();
        break;  

    default:
        (new HomeController())->index();
        break;
}
?>