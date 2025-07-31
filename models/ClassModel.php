<?php
class ClassModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function createClass(int $teacherId, string $name, string $code, string $description): int {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO classes (teacher_id, class_name, class_code, description)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([$teacherId, $name, $code, $description]);
            $classId = $this->pdo->lastInsertId();
            $this->enrollUser($teacherId, $classId);
            $this->pdo->commit();
            return $classId;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Error al crear clase: " . $e->getMessage());
            return 0;
        }
    }

    public function codeExists(string $code): bool {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM classes WHERE class_code = ?");
        $stmt->execute([$code]);
        return (bool)$stmt->fetchColumn();
    }

    public function getClassById(int $classId): ?array {
        $stmt = $this->pdo->prepare("
            SELECT c.*, u.full_name AS teacher_name 
            FROM classes c
            JOIN users u ON c.teacher_id = u.id
            WHERE c.id = ?
        ");
        $stmt->execute([$classId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getTotalClasses(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM classes");
        return (int)$stmt->fetchColumn();
    }

    public function getClassesByTeacher(int $teacherId): array {
        $stmt = $this->pdo->prepare("SELECT * FROM classes WHERE teacher_id = ?");
        $stmt->execute([$teacherId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getClassesByStudent(int $studentId): array {
        $stmt = $this->pdo->prepare("
            SELECT c.* 
            FROM classes c
            JOIN enrollments e ON c.id = e.class_id
            WHERE e.user_id = ?
        ");
        $stmt->execute([$studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
public function getUserClasses(int $userId): array {
    $stmt = $this->pdo->prepare("
        SELECT c.*, u.full_name AS teacher_name, 
               u.id AS teacher_id,  -- Añade el ID del profesor
               (SELECT COUNT(*) FROM activities WHERE class_id = c.id) AS activity_count
        FROM classes c
        JOIN users u ON c.teacher_id = u.id
        WHERE c.teacher_id = ?
        
        UNION
        
        SELECT c.*, u.full_name AS teacher_name, 
               u.id AS teacher_id,  -- Añade el ID del profesor
               (SELECT COUNT(*) FROM activities WHERE class_id = c.id) AS activity_count
        FROM enrollments e
        JOIN classes c ON e.class_id = c.id
        JOIN users u ON c.teacher_id = u.id
        WHERE e.user_id = ?
    ");
    $stmt->execute([$userId, $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function getClassByCode(string $classCode): ?array {
        $stmt = $this->pdo->prepare("
            SELECT c.*, u.full_name AS teacher_name 
            FROM classes c
            JOIN users u ON c.teacher_id = u.id
            WHERE class_code = ?
        ");
        $stmt->execute([$classCode]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function deleteClass(int $classId): bool {
        $this->pdo->beginTransaction();
        try {
            
            $stmt = $this->pdo->prepare("DELETE FROM enrollments WHERE class_id = ?");
            $stmt->execute([$classId]);
            
            
            $activities = $this->getClassActivities($classId);
            $activityModel = new ActivityModel($this->pdo);
            foreach ($activities as $activity) {
                $activityModel->deleteActivity($activity['id']);
            }
            
            
            $stmt = $this->pdo->prepare("DELETE FROM classes WHERE id = ?");
            $stmt->execute([$classId]);
            
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Error al eliminar clase: " . $e->getMessage());
            return false;
        }
    }

    public function isEnrolled(int $userId, int $classId): bool {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) 
            FROM enrollments 
            WHERE user_id = ? AND class_id = ?
        ");
        $stmt->execute([$userId, $classId]);
        return (bool)$stmt->fetchColumn();
    }

    public function enrollUser(int $userId, int $classId): bool {
        $stmt = $this->pdo->prepare("
            INSERT INTO enrollments (user_id, class_id)
            VALUES (?, ?)
        ");
        return $stmt->execute([$userId, $classId]);
    }

    public function removeEnrollment(int $userId, int $classId): bool {
        $stmt = $this->pdo->prepare("
            DELETE FROM enrollments 
            WHERE user_id = ? AND class_id = ?
        ");
        return $stmt->execute([$userId, $classId]);
    }
public function getClassActivities(int $classId, int $userId = null): array {
    $localTimezone = 'America/Mexico_City';
    date_default_timezone_set($localTimezone);

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
    $now = time();

    foreach ($results as &$activity) {
        $activity['deadline_ts'] = isset($activity['deadline_ts']) ? (int)$activity['deadline_ts'] : null;
        $activity['user_submitted'] = (int)($activity['user_submitted'] ?? 0);
        $deadline = $activity['deadline_ts'];

        
        if ($deadline) {
            $dt = new DateTime("@$deadline");
            $dt->setTimezone(new DateTimeZone($localTimezone));
            $activity['deadline_display'] = $dt->format('d/m/Y H:i');
        } else {
            $activity['deadline_display'] = 'No definida';
        }

        
        if ($activity['user_submitted'] > 0) {
            $activity['user_status'] = 'entregada';
            $activity['days_text'] = 'Entregada';
        } elseif ($deadline && $deadline < $now) {
            $activity['user_status'] = 'vencida';
            $activity['days_text'] = 'Vencida';
        } elseif ($deadline) {
            
            $seconds = $deadline - $now;
            $text = '';

            if ($seconds < 60) {
                $text = 'menos de 1 minuto';
            } elseif ($seconds < 3600) {
                $m = floor($seconds / 60);
                $text = $m . ' minuto' . ($m === 1 ? '' : 's');
            } elseif ($seconds < 86400) {
                $h = floor($seconds / 3600);
                $text = $h . ' hora' . ($h === 1 ? '' : 's');
            } elseif ($seconds < 604800) {
                $d = floor($seconds / 86400);
                $text = $d . ' día' . ($d === 1 ? '' : 's');
            } elseif ($seconds < 2592000) {
                $w = floor($seconds / 604800);
                $text = $w . ' semana' . ($w === 1 ? '' : 's');
            } else {
                $mo = floor($seconds / 2592000);
                $text = $mo . ' mes' . ($mo === 1 ? '' : 'es');
            }

            $activity['user_status'] = 'pendiente';
            $activity['days_text'] = $text;
        } else {
            $activity['user_status'] = ($activity['user_submitted'] > 0) ? 'entregada' : 'pendiente';
            $activity['days_text'] = 'Sin fecha límite';
        }
    }

    return $results;
}





    public function getEnrolledStudents(int $classId): array {
        $stmt = $this->pdo->prepare("
            SELECT u.id, u.full_name, u.email, u.role
            FROM enrollments e
            JOIN users u ON e.user_id = u.id
            WHERE e.class_id = ?
        ");
        $stmt->execute([$classId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isClassTeacher(int $classId, int $userId): bool {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) 
            FROM classes 
            WHERE id = ? AND teacher_id = ?
        ");
        $stmt->execute([$classId, $userId]);
        return (bool)$stmt->fetchColumn();
    }
    
    public function getUsersNotEnrolled(int $classId): array {
        $stmt = $this->pdo->prepare("
            SELECT u.id, u.full_name, u.email
            FROM users u
            WHERE u.role = 'student'
            AND u.id NOT IN (
                SELECT user_id 
                FROM enrollments 
                WHERE class_id = ?
            )
        ");
        $stmt->execute([$classId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
public function updateClass(int $id, array $data): bool {
    $sql = "UPDATE classes 
            SET class_name = :class_name, description = :description 
            WHERE id = :id";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':class_name', $data['class_name']);
    $stmt->bindParam(':description', $data['description']);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    return $stmt->execute();
}



}