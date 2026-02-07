<?php
class ActivityModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createActivity($classId, $title, $description, $deadlineTimestamp) {
        $stmt = $this->pdo->prepare("INSERT INTO activities 
            (class_id, title, description, deadline) 
            VALUES (?, ?, ?, FROM_UNIXTIME(?))");
        $stmt->execute([$classId, $title, $description, $deadlineTimestamp]);
        return $this->pdo->lastInsertId();
    }

    

    public function getPlagiarismReport(int $submissionId): ?array {
        $stmt = $this->pdo->prepare("
            SELECT plagiarism_report 
            FROM submissions 
            WHERE id = ?
        ");
        $stmt->execute([$submissionId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result && $result['plagiarism_report']) {
            return json_decode($result['plagiarism_report'], true);
        }
        
        return null;
    }


    

    public function getActivityById($activityId) {
        $stmt = $this->pdo->prepare("SELECT *, UNIX_TIMESTAMP(deadline) as deadline_timestamp FROM activities WHERE id = ?");
        $stmt->execute([$activityId]);
        return $stmt->fetch();
    }
public function isActivityDelivered(int $activityId, int $userId): bool {
    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM submissions WHERE activity_id = :activity_id AND user_id = :user_id");
    $stmt->execute([
        ':activity_id' => $activityId,
        ':user_id' => $userId
    ]);

    return $stmt->fetchColumn() > 0;
}


public function getClassActivities(int $classId, ?int $userId = null): array {
    $stmt = $this->pdo->prepare("
        SELECT 
            a.id, 
            a.title, 
            a.description, 
            UNIX_TIMESTAMP(a.deadline) AS deadline_ts,
            (SELECT COUNT(*) FROM submissions s WHERE s.activity_id = a.id) AS submission_count,
            (SELECT COUNT(*) FROM submissions s2 
             WHERE s2.activity_id = a.id AND s2.user_id = ?) AS user_submitted
        FROM activities a 
        WHERE a.class_id = ?
        ORDER BY a.deadline ASC
    ");
    
    $params = [$userId, $classId];
    
    if (!$stmt->execute($params)) {
        error_log("Error en la consulta: " . print_r($stmt->errorInfo(), true));
        return [];
    }
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    
    foreach ($results as &$activity) {
        $activity['deadline_ts'] = isset($activity['deadline_ts']) ? (int)$activity['deadline_ts'] : null;
        $activity['user_submitted'] = (int)($activity['user_submitted'] ?? 0);
        
        $now = time();
        $deadline = $activity['deadline_ts'];
        
        
        if ($deadline) {
            $diff = $deadline - $now;
            
            
            if ($activity['user_submitted'] > 0) {
                $activity['days_text'] = 'Entregada';
                $activity['user_status'] = 'entregada';
            } 
            
            elseif ($diff <= 0) {
                $activity['days_text'] = 'Vencida';
                $activity['user_status'] = 'vencida';
            } 
            
            else {
                $days = ceil($diff / (60 * 60 * 24));
                
                
                if ($days == 1) {
                    $activity['days_text'] = '1 día';
                } else {
                    $activity['days_text'] = $days . ' días';
                }
                
                $activity['user_status'] = 'pendiente';
            }
            
            $activity['deadline_display'] = date('d/m/Y H:i', $deadline);
        } else {
            
            $activity['days_text'] = 'Sin fecha límite';
            $activity['deadline_display'] = 'No definida';
            $activity['user_status'] = ($activity['user_submitted'] > 0) 
                ? 'entregada' 
                : 'pendiente';
        }
    }
    
    return $results;
}

    public function updateActivity($activityId, $data) {
        $sql = "UPDATE activities SET ";
        $params = [];
        foreach ($data as $key => $value) {
            if ($key === 'deadline') {
                $sql .= "deadline = FROM_UNIXTIME(?), ";
                $params[] = $value;
            } else {
                $sql .= "$key = ?, ";
                $params[] = $value;
            }
        }
        $sql = rtrim($sql, ', ') . " WHERE id = ?";
        $params[] = $activityId;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
public function deleteSubmissionResources($submissionId) {
    $sql = "DELETE FROM submission_files WHERE submission_id = ?";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([$submissionId]);
}

public function deleteSubmission($submissionId) {
    $sql = "DELETE FROM submissions WHERE id = ?";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([$submissionId]);
}

public function updateSubmission($submissionId, $content) {
    $sql = "UPDATE submissions SET content = ?, submitted_at = NOW() WHERE id = ?";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([$content, $submissionId]);
}
    public function deleteActivity($activityId) {
        $this->pdo->beginTransaction();
        try {
            
            $stmt = $this->pdo->prepare("DELETE FROM activity_files WHERE activity_id = ?");
            $stmt->execute([$activityId]);
            
            
            $stmt = $this->pdo->prepare("DELETE FROM activities WHERE id = ?");
            $stmt->execute([$activityId]);
            
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Error al eliminar actividad: " . $e->getMessage());
            return false;
        }
    }

    public function getTotalActivities() {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM activities");
        return $stmt->fetchColumn();
    }

    public function getSubmissions($activityId) {
        $stmt = $this->pdo->prepare("
            SELECT
                s.*,
                u.full_name        AS student_name,
                u.id               AS user_id,
                UNIX_TIMESTAMP(s.submitted_at) as submitted_timestamp
            FROM submissions s
            JOIN users u ON s.user_id = u.id
            WHERE s.activity_id = ?
            ORDER BY s.submitted_at DESC
        ");
        $stmt->execute([$activityId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createSubmission(int $activityId, int $userId, string $content): int {
        $sql = "INSERT INTO submissions (activity_id, user_id, content, submitted_at) 
                VALUES (?, ?, ?, NOW())";  
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$activityId, $userId, $content]);
        return $this->pdo->lastInsertId();
    }

    public function getRecentActivities(int $limit = 5): array {
        $stmt = $this->pdo->prepare("
            SELECT * 
            FROM activities 
            ORDER BY created_at DESC 
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    
    public function saveActivityResource($activityId, $type, $originalName, $storedName, $fileType, $size) {
        $sql = "INSERT INTO activity_files 
                (activity_id, type, original_name, stored_name, file_type, size) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$activityId, $type, $originalName, $storedName, $fileType, $size]);
    }

    public function getActivityResources($activityId) {
        $sql = "SELECT * FROM activity_files WHERE activity_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$activityId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActivityResource($fileId) {
        $sql = "SELECT * FROM activity_files WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$fileId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getActivityByFileId($fileId) {
        $sql = "SELECT a.*, UNIX_TIMESTAMP(a.deadline) as deadline_timestamp 
                FROM activity_files af
                JOIN activities a ON af.activity_id = a.id
                WHERE af.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$fileId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteActivityResource($fileId) {
        $sql = "DELETE FROM activity_files WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$fileId]);
    }

    public function saveSubmissionResource($submissionId, $type, $originalName, $storedName, $resourceType, $size) {
        $sql = "INSERT INTO submission_files 
                (submission_id, type, original_name, stored_name, resource_type, size) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$submissionId, $type, $originalName, $storedName, $resourceType, $size]);
    }

    public function getSubmissionResources($submissionId) {
        $sql = "SELECT * FROM submission_files WHERE submission_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$submissionId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubmissionResource($resourceId) {
        $sql = "SELECT * FROM submission_files WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$resourceId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getSubmissionByFileId($fileId) {
        $sql = "SELECT s.*, UNIX_TIMESTAMP(s.submitted_at) as submitted_timestamp 
                FROM submission_files sf
                JOIN submissions s ON sf.submission_id = s.id
                WHERE sf.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$fileId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public function updateSubmissionSimilarity($submissionId, $similarity) {
        $sql = "UPDATE submissions SET similarity = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$similarity, $submissionId]);
    }


public function getSubmissionsWithReports($activityId) {
    $sql = "SELECT 
                s.id,
                s.activity_id,
                s.user_id,
                s.content,
                s.submitted_at,
                s.similarity AS similarity_score,  
                s.plagiarism_report,
                u.full_name,                    
                UNIX_TIMESTAMP(s.submitted_at) as submitted_timestamp
            FROM submissions s
            JOIN users u ON s.user_id = u.id
            WHERE s.activity_id = ?
            ORDER BY s.submitted_at DESC";
    
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$activityId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getUserSubmission($activityId, $userId) {
    $sql = "SELECT *, UNIX_TIMESTAMP(submitted_at) as submitted_timestamp 
            FROM submissions 
            WHERE activity_id = ? AND user_id = ?
            ORDER BY submitted_at DESC
            LIMIT 1";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$activityId, $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function getStudentSubmission($activityId, $userId) {
    $sql = "SELECT *, UNIX_TIMESTAMP(submitted_at) as submitted_timestamp 
            FROM submissions 
            WHERE activity_id = ? AND user_id = ?
            ORDER BY submitted_at DESC
            LIMIT 1";  
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$activityId, $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
    
public function getSubmission($submissionId) {
    $sql = "SELECT *, 
            UNIX_TIMESTAMP(submitted_at) as submitted_timestamp,
            CASE
                WHEN status IS NOT NULL THEN status
                WHEN grade IS NOT NULL THEN 'Calificada'
                ELSE 'Pendiente'
            END as status
        FROM submissions WHERE id = ?";
    
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$submissionId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function getClassInfo($classId) {
    $sql = "SELECT id, class_name AS name FROM classes WHERE id = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$classId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    
    public function hasStudentSubmitted($activityId, $userId) {
        $sql = "SELECT COUNT(*) FROM submissions 
                WHERE activity_id = ? AND user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$activityId, $userId]);
        return $stmt->fetchColumn() > 0;
    }


    public function gradeSubmission($submissionId, $grade, $status, $comments) {
    $sql = "UPDATE submissions 
            SET grade = ?, status = ?, comments = ?, graded_at = NOW() 
            WHERE id = ?";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([$grade, $status, $comments, $submissionId]);
}



    /**
     * Procesa una entrega con el servicio de plagio
     * 
     * @param int $submissionId ID de la entrega
     * @param string|null $filePath Ruta al archivo (opcional)
     * @return array Reporte de plagio
     */
    public function processPlagiarism(int $submissionId, ?string $filePath = null): array {
        $plagiarismService = new PlagiarismService($this->pdo);
        $report = $plagiarismService->analyzeSubmission($submissionId, $filePath);
        
        
        $this->savePlagiarismReport($submissionId, $report);
        
        return $report;
    }

    /**
     * Guarda el reporte de plagio en la base de datos
     */
    public function savePlagiarismReport(int $submissionId, array $report): bool {
        $jsonReport = json_encode($report, JSON_PRETTY_PRINT);
        
        $stmt = $this->pdo->prepare("
            UPDATE submissions 
            SET plagiarism_report = ?, similarity_score = ?
            WHERE id = ?
        ");
        
        return $stmt->execute([
            $jsonReport,
            $report['similarity'],
            $submissionId
        ]);
    }


    
}