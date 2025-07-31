<?php

require_once 'PlagiarismService.php';

class ActivityController {
    private $pdo;
    private $activityModel;
    private $plagiarismService;
public function cancelSubmission($submissionId) {
    AuthController::checkAuth();
    
    $submission = $this->activityModel->getSubmission($submissionId);
    if (!$submission) {
        $this->flashAndRedirect('danger', 'Entrega no encontrada.', 'index.php');
    }

    $userId = $_SESSION['user']['id'];
    if ($submission['user_id'] != $userId) {
        $this->denyAccess();
    }

    
    $activity = $this->activityModel->getActivityById($submission['activity_id']);
    $now = time();
    $deadline = $activity['deadline_timestamp'];
    if ($now > $deadline) {
        $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => 'No puedes anular la entrega después de la fecha límite.'
        ];
        header("Location: index.php?action=view_activity&id=" . $activity['id']);
        exit();
    }

    
    $this->pdo->beginTransaction();
    try {
        
        $resources = $this->activityModel->getSubmissionResources($submissionId);
        foreach ($resources as $resource) {
            if ($resource['type'] === 'file') {
                $filePath = __DIR__ . '/../uploads/submissions/' . $resource['stored_name'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        
        $this->activityModel->deleteSubmissionResources($submissionId);

        
        $this->activityModel->deleteSubmission($submissionId);

        $this->pdo->commit();

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Entrega anulada correctamente.'
        ];
        header("Location: index.php?action=view_activity&id=" . $activity['id']);
        exit();
    } catch (Exception $e) {
        $this->pdo->rollBack();
        error_log("Error al anular entrega: " . $e->getMessage());
        $this->flashAndRedirect('danger', 'Error al anular la entrega.', 'index.php');
    }
}


public function editSubmission($submissionId) {
    AuthController::checkAuth();
    
    $submission = $this->activityModel->getSubmission($submissionId);
    if (!$submission) {
        $this->flashAndRedirect('danger', 'Entrega no encontrada.', 'index.php');
    }

    $userId = $_SESSION['user']['id'];
    if ($submission['user_id'] != $userId) {
        $this->denyAccess();
    }

    $activity = $this->activityModel->getActivityById($submission['activity_id']);
    $now = time();
    $deadline = $activity['deadline_timestamp'];
    if ($now > $deadline) {
        $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => 'No puedes editar la entrega después de la fecha límite.'
        ];
        header("Location: index.php?action=view_activity&id=" . $activity['id']);
        exit();
    }

    
    header("Location: index.php?action=submit_activity&id=" . $activity['id'] . "&edit=" . $submissionId);
    exit();
}
    public function __construct() {
        $this->pdo = getDatabaseConnection();
        $this->activityModel = new ActivityModel($this->pdo);
        $this->plagiarismService = new PlagiarismService($this->pdo);
        
        
        $methods = get_class_methods($this->plagiarismService);
        if (!in_array('analyzeSubmission', $methods)) {
            throw new Exception("Error crítico: El servicio de plagio no tiene el método analyzeSubmission");
        }
        
        AuthController::checkAuth();
    }

public function editActivity($activityId) {
    $activityModel = new ActivityModel($this->pdo);
    $classModel = new ClassModel($this->pdo);

    $activity = $activityModel->getActivityById($activityId);

    
    if (!$activity || !$classModel->isClassTeacher($activity['class_id'], $_SESSION['user']['id'])) {
        $this->denyAccess();
    }

    $errors = [];
    
    $activityData = [
        'title' => $activity['title'] ?? '',
        'description' => $activity['description'] ?? '',
        'due_date' => $activity['due_date'] ?? ''
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $activityData['title'] = trim($_POST['title'] ?? '');
        $activityData['description'] = trim($_POST['description'] ?? '');
        $activityData['due_date'] = trim($_POST['due_date'] ?? '');

        if ($activityData['title'] === '') {
            $errors[] = "El título de la actividad es requerido";
        }

        if ($activityData['due_date'] === '') {
            $errors[] = "La fecha de entrega es requerida";
        }

        if (empty($errors)) {
            try {
                $activityModel->updateActivity($activityId, $activityData);

                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Actividad actualizada exitosamente!'
                ];
                header("Location: index.php?action=view_activity&id=$activityId");
                exit();
            } catch (Exception $e) {
                $errors[] = "Error al actualizar la actividad: " . $e->getMessage();
                error_log("Error al editar actividad: " . $e->getMessage());
            }
        }
    }

    require 'views/activities/edit.php';
}




public function create($classId) {
    $classModel = new ClassModel($this->pdo);
    $class = $classModel->getClassById($classId);
    
    if (!$class) {
        $this->flashAndRedirect('danger', 'La clase solicitada no existe.', 'index.php?action=dashboard');
    }

    if (!$this->isClassTeacher($classId)) {
        $this->flashAndRedirect('danger', 'Solo el profesor de esta clase puede crear actividades', "index.php?action=view_class&id=$classId");
    }

    $errors = [];
    $title = '';
    $description = '';
    $deadline = '';
    $resources = [];
    $clientTimezone = $this->getClientTimezone();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        if (empty($_POST) && empty($_FILES) && $_SERVER['CONTENT_LENGTH'] > 0) {
            $errors[] = "El tamaño de los datos enviados excede el límite permitido. Por favor, reduce el tamaño de los archivos.";
        }

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $deadlineInput = $_POST['deadline'] ?? '';
        $deadline = $deadlineInput;
        
        if (empty($title)) {
            $errors[] = "El título es requerido";
        }
        
        $uploadDir = __DIR__ . '/../uploads/activities/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        
        if (empty($errors) && !empty($_FILES['activity_files']['name'][0])) {
            foreach ($_FILES['activity_files']['tmp_name'] as $key => $tmpName) {
                if ($_FILES['activity_files']['error'][$key] !== UPLOAD_ERR_OK) {
                    $errors[] = "Error al subir el archivo: " . $_FILES['activity_files']['name'][$key];
                    continue;
                }
                
                $fileName = basename($_FILES['activity_files']['name'][$key]);
                $fileType = $_FILES['activity_files']['type'][$key];
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                $safeName = bin2hex(random_bytes(16)) . '.' . $fileExt;
                $filePath = $uploadDir . $safeName;
                
                if (move_uploaded_file($tmpName, $filePath)) {
                    $resources[] = [
                        'type' => 'file',
                        'original_name' => $fileName,
                        'stored_name' => $safeName,
                        'file_type' => $fileType,
                        'size' => $_FILES['activity_files']['size'][$key],
                        'extension' => $fileExt 
                    ];
                } else {
                    $errors[] = "Error al guardar el archivo: $fileName";
                }
            }
        }
        
        
        $links = $_POST['links'] ?? [];
        foreach ($links as $link) {
            $link = trim($link);
            if (!empty($link)) {
                if (filter_var($link, FILTER_VALIDATE_URL)) {
                    $resources[] = [
                        'type' => 'link',
                        'original_name' => $link,
                        'stored_name' => null,
                        'file_type' => 'url',
                        'size' => 0
                    ];
                } else {
                    $errors[] = "Enlace no válido: $link";
                }
            }
        }

        if (empty($errors)) {
            try {
                $deadlineObj = DateTime::createFromFormat(
                    'Y-m-d\TH:i', 
                    $deadlineInput, 
                    new DateTimeZone($clientTimezone)
                );
                
                if (!$deadlineObj) {
                    $errors[] = "Formato de fecha inválido";
                } else {
                    
                    $deadlineObj->setTimezone(new DateTimeZone('UTC'));
                    $deadlineTimestamp = $deadlineObj->getTimestamp();
                    
                    
                    $activityId = $this->activityModel->createActivity(
                        $classId, 
                        $title, 
                        $description, 
                        $deadlineTimestamp
                    );
                    
                    
                    foreach ($resources as $resource) {
                        $this->activityModel->saveActivityResource(
                            $activityId, 
                            $resource['type'],
                            $resource['original_name'], 
                            $resource['stored_name'], 
                            $resource['file_type'],
                            $resource['size']
                        );
                    }
                    
                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => 'Actividad creada exitosamente!'
                    ];
                    header("Location: index.php?action=view_class&id=$classId");
                    exit();
                }
            } catch (Exception $e) {
                
                foreach ($resources as $resource) {
                    if ($resource['type'] === 'file') {
                        $filePath = $uploadDir . $resource['stored_name'];
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                    }
                }
                $errors[] = "Error al crear la actividad: " . $e->getMessage();
                error_log("Error al crear actividad: " . $e->getMessage());
            }
        }
    }
    
    $viewData = [
        'classId' => $classId,
        'title' => $title,
        'description' => $description,
        'deadline' => $deadline,
        'errors' => $errors,
        'clientTimezone' => $clientTimezone,
        'resources' => $resources 
    ];
    extract($viewData);
    require 'views/activities/create.php';
}

    
    private function isClassTeacher(int $classId): bool {
        $classModel = new ClassModel($this->pdo);
        return $classModel->isClassTeacher($classId, $_SESSION['user']['id']);
    }

    
public function view($activityId) {
    $activity = $this->activityModel->getActivityById($activityId);
    if (!$activity || !isset($activity['class_id'])) {
        $this->flashAndRedirect('danger', 'Actividad no encontrada.', 'index.php');
    }

    $userId = $_SESSION['user']['id'];
    $classModel = new ClassModel($this->pdo);
    
    $isAdmin = ($_SESSION['user']['role'] === 'admin');
    $isTeacher = $classModel->isClassTeacher($activity['class_id'], $userId);
    $isEnrolled = $classModel->isEnrolled($userId, $activity['class_id']);
    
    if (!$isAdmin && !$isTeacher && !$isEnrolled) {
        $this->denyAccess();
    }

    $clientTimezone = $this->getClientTimezone();
    
    
    $deadlineObj = (new DateTime('@' . $activity['deadline_timestamp'], new DateTimeZone('UTC')))
        ->setTimezone(new DateTimeZone($clientTimezone));
    
    $activity['deadline_formatted'] = $deadlineObj->format('d/m/Y H:i:s');
    $activity['deadline_local'] = $deadlineObj->format('Y-m-d\TH:i');
    
    $activityResources = $this->activityModel->getActivityResources($activityId);
    $class = $classModel->getClassById($activity['class_id']);

    
    $userSubmission = null;
    if ($_SESSION['user']['role'] === 'student') {
        $userSubmission = $this->activityModel->getStudentSubmission($activityId, $userId);
    }

    require 'views/activities/view.php';
}

 public function submit($activityId) {
        $activity = $this->activityModel->getActivityById($activityId);
        if (!$activity) {
            $this->flashAndRedirect('danger', 'Actividad no encontrada.', 'index.php');
        }

        $userId = $_SESSION['user']['id'];
        $classModel = new ClassModel($this->pdo);
        
        if (!$classModel->isEnrolled($userId, $activity['class_id'])) {
            $this->flashAndRedirect('danger', 'No estás inscrito en esta clase.', "index.php?action=view_activity&id=$activityId");
        }

        $now = time();
        $deadlineTimestamp = $activity['deadline_timestamp'];
        
        if ($now > $deadlineTimestamp) {
            $this->flashAndRedirect('danger', 'La fecha límite ha expirado.', "index.php?action=view_activity&id=$activityId");
        }

        $editingSubmissionId = $_GET['edit'] ?? null;
        $editingSubmission = null;
        $editingResources = [];
        $isEditing = false;
        
        if ($editingSubmissionId) {
            $editingSubmission = $this->activityModel->getSubmission($editingSubmissionId);
            if (!$editingSubmission || $editingSubmission['user_id'] != $userId || $editingSubmission['activity_id'] != $activityId) {
                $this->denyAccess();
            }
            $editingResources = $this->activityModel->getSubmissionResources($editingSubmissionId);
            $isEditing = true;
        } else {
            $existingSubmission = $this->activityModel->getStudentSubmission($activityId, $userId);
            if ($existingSubmission) {
                $this->flashAndRedirect('warning', 'Ya has enviado un trabajo para esta actividad.', "index.php?action=view_activity&id=$activityId");
            }
        }

        $errors = [];
        $content = $isEditing ? ($editingSubmission['content'] ?? '') : '';
        $resources = [];
        $submissionId = $isEditing ? $editingSubmissionId : null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = trim($_POST['content'] ?? '');
            
            $uploadDir = __DIR__ . '/../uploads/submissions/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            if (!empty($_FILES['submission_files']['name'][0])) {
                foreach ($_FILES['submission_files']['tmp_name'] as $key => $tmpName) {
                    if ($_FILES['submission_files']['error'][$key] !== UPLOAD_ERR_OK) {
                        $errors[] = "Error al subir el archivo: " . $_FILES['submission_files']['name'][$key];
                        continue;
                    }
                    
                    $fileName = basename($_FILES['submission_files']['name'][$key]);
                    $fileType = $_FILES['submission_files']['type'][$key];
                    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    
                    $safeName = bin2hex(random_bytes(16)) . '.' . $fileExt;
                    $filePath = $uploadDir . $safeName;
                    
                    if (move_uploaded_file($tmpName, $filePath)) {
                        $resources[] = [
                            'type' => 'file',
                            'original_name' => $fileName,
                            'stored_name' => $safeName,
                            'resource_type' => $fileType,
                            'size' => $_FILES['submission_files']['size'][$key],
                            'path' => $filePath,
                            'extension' => $fileExt
                        ];
                    } else {
                        $errors[] = "Error al guardar el archivo: $fileName";
                    }
                }
            }
            
            $links = $_POST['links'] ?? [];
            foreach ($links as $link) {
                $link = trim($link);
                if (!empty($link) && filter_var($link, FILTER_VALIDATE_URL)) {
                    $resources[] = [
                        'type' => 'link',
                        'original_name' => $link,
                        'stored_name' => null,
                        'resource_type' => 'url',
                        'size' => 0,
                        'path' => $link
                    ];
                }
            }
            
            if (empty($content) && empty($resources)) {
                $errors[] = "Debes proporcionar contenido o subir al menos un recurso";
            }

            if (empty($errors)) {
                $this->pdo->beginTransaction();
                try {
                    if ($isEditing) {
                        $this->activityModel->updateSubmission($editingSubmissionId, $content);
                        
                        foreach ($editingResources as $resource) {
                            if ($resource['type'] === 'file') {
                                $oldPath = __DIR__ . '/../uploads/submissions/' . $resource['stored_name'];
                                if (file_exists($oldPath)) {
                                    unlink($oldPath);
                                }
                            }
                        }
                        $this->activityModel->deleteSubmissionResources($editingSubmissionId);
                        $submissionId = $editingSubmissionId;
                    } else {
                        $submissionId = $this->activityModel->createSubmission($activityId, $userId, $content);
                    }
                    
                    foreach ($resources as $resource) {
                        $this->activityModel->saveSubmissionResource(
                            $submissionId, 
                            $resource['type'],
                            $resource['original_name'], 
                            $resource['stored_name'], 
                            $resource['resource_type'],
                            $resource['size']
                        );
                    }
                    
                    
                    $textContent = $content;
                    foreach ($resources as $resource) {
                        if ($resource['type'] === 'file') {
                            try {
                                $fileContent = $this->plagiarismService->extractTextFromFile($resource['path']);
                                $textContent .= "\n" . $fileContent;
                            } catch (Exception $e) {
                                error_log("Error extrayendo texto de archivo: " . $e->getMessage());
                            }
                        }
                    }
                    
                    
                    $similarity = 0;
                    $report = null;
                    if (!empty(trim($textContent))) {
                        $report = $this->plagiarismService->analyzeSubmission($submissionId);
                        $similarity = $report['similarity'] ?? 0;
                        
                        
                        $this->activityModel->savePlagiarismReport($submissionId, $report);
                    }
                    
                    
                    $this->activityModel->updateSubmissionSimilarity($submissionId, $similarity);
                    
                    $this->pdo->commit();
                    
                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => ($isEditing ? 'Entrega actualizada' : 'Trabajo enviado') . '! Similitud detectada: ' . $similarity . '%'
                    ];
                    header("Location: index.php?action=view_activity&id=$activityId");
                    exit();
                    
                } catch (Exception $e) {
                    $this->pdo->rollBack();
                    foreach ($resources as $resource) {
                        if ($resource['type'] === 'file' && file_exists($resource['path'])) {
                            unlink($resource['path']);
                        }
                    }
                    $errors[] = "Error al guardar la entrega: " . $e->getMessage();
                    error_log("Error en submit: " . $e->getMessage());
                }
            }
        }
        
        $activityResources = $this->activityModel->getActivityResources($activityId);
        
        $viewData = [
            'activity' => $activity,
            'activityResources' => $activityResources,
            'errors' => $errors,
            'isEditing' => $isEditing,
            'editingResources' => $editingResources,
            'content' => $content
        ];
        
        extract($viewData);
        require 'views/activities/submit.php';
    }


    
    public function downloadFile($fileId, $type = 'activity') {
        if ($type === 'activity') {
            $file = $this->activityModel->getActivityResource($fileId);
            
            if (!$file || $file['type'] !== 'file') {
                $this->flashAndRedirect('danger', 'Archivo no válido', 'index.php');
            }
            
            $activity = $this->activityModel->getActivityByFileId($fileId);
            
            
            $filePath = __DIR__ . '/../uploads/activities/' . $file['stored_name'];
        } 
        elseif ($type === 'submission') {
            $file = $this->activityModel->getSubmissionResource($fileId);
            
            if (!$file || $file['type'] !== 'file') {
                $this->flashAndRedirect('danger', 'Archivo no válido', 'index.php');
            }
            
            $submission = $this->activityModel->getSubmissionByFileId($fileId);
            $activity = $this->activityModel->getActivityById($submission['activity_id']);
            
            
            $isOwner = ($_SESSION['user']['id'] == $submission['user_id']);
            $isTeacher = $this->isClassTeacher($activity['class_id']);
            
            if (!$file || !$activity || !($isOwner || $isTeacher)) {
                $this->denyAccess();
            }
            
            $filePath = __DIR__ . '/../uploads/submissions/' . $file['stored_name'];
        } 
        else {
            $this->flashAndRedirect('danger', 'Tipo de recurso inválido', 'index.php');
        }

        if (!file_exists($filePath)) {
            $this->flashAndRedirect('danger', 'El archivo no existe', 'index.php');
        }

        
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file['original_name']) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit();
    }

    
    public function deleteActivityResource($resourceId) {
        $resource = $this->activityModel->getActivityResource($resourceId);
        $activity = $this->activityModel->getActivityByFileId($resourceId);
        
        
        if (!$resource || !$activity || !$this->isClassTeacher($activity['class_id'])) {
            $this->denyAccess();
        }
        
        
        if ($resource['type'] === 'file') {
            $filePath = __DIR__ . '/../uploads/activities/' . $resource['stored_name'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        
        $this->activityModel->deleteActivityFile($resourceId);
        
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Recurso eliminado correctamente'
        ];
        header("Location: index.php?action=view_activity&id=" . $activity['id']);
        exit();
    }

    
    private function getClientTimezone() {
        
        if (!empty($_COOKIE['client_timezone'])) {
            return $_COOKIE['client_timezone'];
        }
        
        
        if (!empty($_SERVER['HTTP_CLIENT_TIMEZONE'])) {
            return $_SERVER['HTTP_CLIENT_TIMEZONE'];
        }
        
        
        if (!empty($_SESSION['client_timezone'])) {
            return $_SESSION['client_timezone'];
        }
        
        
        return date_default_timezone_get();
    }

    
    private function hasAccess(int $classId): bool {
        $classModel = new ClassModel($this->pdo);
        $userId = $_SESSION['user']['id'];
        $role = $_SESSION['user']['role'];

        
        if ($role === 'admin') {
            return true;
        }

        
        if ($role === 'teacher' && $classModel->isClassTeacher($classId, $userId)) {
            return true;
        }

        
        if ($role === 'student' && $classModel->isEnrolled($userId, $classId)) {
            return true;
        }

        return false;
    }

    private function denyAccess() {
        $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => 'Acceso no autorizado'
        ];
        header("Location: index.php");
        exit();
    }

    private function flashAndRedirect($type, $message, $location) {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
        header("Location: $location");
        exit();
    }

    
    public function listSubmissions($activityId) {
        $activity = $this->activityModel->getActivityById($activityId);
        
        if (!$activity || !$this->isClassTeacher($activity['class_id'])) {
            $this->denyAccess();
        }
        
        $submissions = $this->activityModel->getSubmissionsWithReports($activityId);

        require 'views/activities/submissions.php';
    }
public function viewSubmission($submissionId) {
        AuthController::checkAuth();
        
        
        $submission = $this->activityModel->getSubmission($submissionId);
        if (!$submission) {
            $this->flashAndRedirect('danger', 'Entrega no encontrada.', 'index.php');
        }

        
        $activity = $this->activityModel->getActivityById($submission['activity_id']);
        if (!$activity) {
            $this->flashAndRedirect('danger', 'Actividad no encontrada.', 'index.php');
        }

        
        $classModel = new ClassModel($this->pdo);
        $class = $classModel->getClassById($activity['class_id']);
        
        if (!$class) {
            $class = ['class_name' => 'Clase no disponible'];
        }

        
        $userId = $_SESSION['user']['id'];
        $isAdmin = ($_SESSION['user']['role'] === 'admin');
        $isTeacher = $classModel->isClassTeacher($activity['class_id'], $userId);
        $isOwner = ($submission['user_id'] == $userId);
        
        
        if (!$isAdmin && !$isTeacher && !$isOwner) {
            $this->denyAccess();
        }

        
        $submissionResources = $this->activityModel->getSubmissionResources($submissionId);
        
        
        $userModel = new UserModel($this->pdo);
        $student = $userModel->getUserById($submission['user_id']);
        
        
        $plagiarismReport = $this->activityModel->getPlagiarismReport($submissionId);
        
        
        if (!$plagiarismReport && isset($submission['similarity_score']) && $submission['similarity_score'] > 0) {
            $plagiarismReport = [
                'similarity' => $submission['similarity_score'],
                'sources' => [],
                'ai_detection' => false,
                'ai_confidence' => 0,
                'suspicious_sections' => [],
                'generated_at' => date('Y-m-d H:i:s')
            ];
        }

        
        $viewData = [
            'submission' => $submission,
            'activity' => $activity,
            'class' => $class,
            'submissionResources' => $submissionResources,
            'student' => $student,
            'isTeacher' => $isTeacher,
            'isOwner' => $isOwner,
            'plagiarismReport' => $plagiarismReport
        ];
        
        extract($viewData);
        require 'views/activities/view_submission.php';
    }

    public function generateReport($submissionId) {
        $submission = $this->activityModel->getSubmission($submissionId);
        $activity = $this->activityModel->getActivityById($submission['activity_id']);

        
        $classModel = new ClassModel($this->pdo);
        if (!$activity || !$classModel->isClassTeacher($activity['class_id'], $_SESSION['user']['id'])) {
            $this->denyAccess();
        }

        try {
            
            $resources = $this->activityModel->getSubmissionResources($submissionId);
            
            
            $textContent = $submission['content'] ?? '';
            foreach ($resources as $resource) {
                if ($resource['type'] === 'file') {
                    try {
                        $filePath = __DIR__ . '/../uploads/submissions/' . $resource['stored_name'];
                        $fileContent = $this->plagiarismService->extractTextFromFile($filePath);
                        $textContent .= "\n" . $fileContent;
                    } catch (Exception $e) {
                        error_log("Error extrayendo texto: " . $e->getMessage());
                    }
                }
            }
            
            
            $report = $this->plagiarismService->analyzeSubmission($submissionId);
            
            
            $this->activityModel->savePlagiarismReport($submissionId, $report);
            
            
            $this->activityModel->updateSubmissionSimilarity($submissionId, $report['similarity']);
            
            $_SESSION['flash'] = [
                'type' => 'success',
                'message' => 'Reporte generado exitosamente'
            ];
            
        } catch (Exception $e) {
            error_log("Error generando reporte: " . $e->getMessage());
            $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => 'Error generando reporte: ' . $e->getMessage()
            ];
        }
        
        header("Location: index.php?action=view_submission&id=$submissionId");
        exit();
    }



    
private function getFileIcon($extension) {
    $icons = [
        'pdf' => 'bi-file-earmark-pdf',
        'doc' => 'bi-file-earmark-word',
        'docx' => 'bi-file-earmark-word',
        'xls' => 'bi-file-earmark-excel',
        'xlsx' => 'bi-file-earmark-excel',
        'ppt' => 'bi-file-earmark-ppt',
        'pptx' => 'bi-file-earmark-ppt',
        'txt' => 'bi-file-earmark-text',
        'jpg' => 'bi-file-earmark-image',
        'jpeg' => 'bi-file-earmark-image',
        'png' => 'bi-file-earmark-image',
        'gif' => 'bi-file-earmark-image',
        'mp4' => 'bi-file-earmark-play',
        'mov' => 'bi-file-earmark-play',
        'avi' => 'bi-file-earmark-play',
        'mp3' => 'bi-file-earmark-music',
        'wav' => 'bi-file-earmark-music',
        'zip' => 'bi-file-earmark-zip',
        'rar' => 'bi-file-earmark-zip',
        'exe' => 'bi-gear',
        'msi' => 'bi-gear',
    ];
    
    return $icons[strtolower($extension)] ?? 'bi-file-earmark';
}
public function gradeSubmission($submissionId) {
    AuthController::checkAuth();
    
    
    $submission = $this->activityModel->getSubmission($submissionId);
    if (!$submission) {
        $this->flashAndRedirect('danger', 'Entrega no encontrada.', 'index.php');
    }

    
    $activity = $this->activityModel->getActivityById($submission['activity_id']);
    if (!$activity) {
        $this->flashAndRedirect('danger', 'Actividad no encontrada.', 'index.php');
    }

    
    $classModel = new ClassModel($this->pdo);
    $isTeacher = $classModel->isClassTeacher($activity['class_id'], $_SESSION['user']['id']);
    
    if (!$isTeacher) {
        $this->denyAccess();
    }

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $grade = isset($_POST['grade']) ? floatval($_POST['grade']) : null;
        $status = $_POST['status'] ?? 'pendiente';
        $comments = $_POST['comments'] ?? '';

        
        if ($grade !== null && ($grade < 0 || $grade > 100)) {
            $this->flashAndRedirect('danger', 'La calificación debe estar entre 0 y 100.', "index.php?action=view_submission&id=$submissionId");
        }

        try {
            
            $this->activityModel->gradeSubmission($submissionId, $grade, $status, $comments);
            
            $_SESSION['flash'] = [
                'type' => 'success',
                'message' => 'Evaluación guardada correctamente.'
            ];
        } catch (Exception $e) {
            error_log("Error al calificar entrega: " . $e->getMessage());
            $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => 'Error al guardar la evaluación.'
            ];
        }

        header("Location: index.php?action=view_submission&id=$submissionId");
        exit();
    } else {
        
        header("Location: index.php?action=view_submission&id=$submissionId");
        exit();
    }
}


    private function extractTextFromFile(string $filePath): string {
        try {
            return $this->plagiarismService->extractTextFromFile($filePath);
        } catch (Exception $e) {
            error_log("Error extrayendo texto: " . $e->getMessage());
            return '';
        }
    }

}

