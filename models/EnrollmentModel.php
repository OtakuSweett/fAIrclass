<?php
class EnrollmentModel {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    
    public function enrollStudent(int $studentId, int $classId): bool {
        
        if ($this->isEnrolled($studentId, $classId)) {
            return false;
        }
        
        $stmt = $this->pdo->prepare("INSERT INTO class_members (student_id, class_id) VALUES (?, ?)");
        return $stmt->execute([$studentId, $classId]);
    }

    
    public function isEnrolled(int $studentId, int $classId): bool {
        $stmt = $this->pdo->prepare("SELECT 1 FROM class_members WHERE student_id = ? AND class_id = ? LIMIT 1");
        $stmt->execute([$studentId, $classId]);
        return (bool) $stmt->fetchColumn();
    }

    
    public function getEnrolledStudents(int $classId): array {
        $stmt = $this->pdo->prepare("
            SELECT u.id, u.full_name, u.email 
            FROM users u
            INNER JOIN class_members cm ON u.id = cm.student_id
            WHERE cm.class_id = ?
            ORDER BY u.full_name ASC
        ");
        $stmt->execute([$classId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function removeEnrollment(int $studentId, int $classId): bool {
        $stmt = $this->pdo->prepare("DELETE FROM class_members WHERE student_id = ? AND class_id = ?");
        return $stmt->execute([$studentId, $classId]);
    }

    
    public function getUsersNotEnrolled(int $classId): array {
        $stmt = $this->pdo->prepare("
            SELECT u.id, u.full_name, u.email 
            FROM users u
            WHERE u.role = 'student'
            AND u.id NOT IN (
                SELECT student_id FROM class_members WHERE class_id = ?
            )
            ORDER BY u.full_name ASC
        ");
        $stmt->execute([$classId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getStudentByEmail(string $email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ? AND role = 'student' LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
    }

    
    public function getClassesForStudent(int $studentId): array {
        $stmt = $this->pdo->prepare("
            SELECT c.id, c.class_name, c.description, c.teacher_id
            FROM classes c
            INNER JOIN class_members cm ON c.id = cm.class_id
            WHERE cm.student_id = ?
        ");
        $stmt->execute([$studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function getUserByEmail(string $email) {
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
}

    
    public function getEnrollmentCount(int $classId): int {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) 
            FROM class_members 
            WHERE class_id = ?
        ");
        $stmt->execute([$classId]);
        return (int) $stmt->fetchColumn();
    }
}