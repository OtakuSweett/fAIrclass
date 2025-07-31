<?php
class SubmissionModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createSubmission($activityId, $studentId, $content) {
        $stmt = $this->pdo->prepare("INSERT INTO submissions 
            (activity_id, student_id, content) 
            VALUES (?, ?, ?)");
        $stmt->execute([$activityId, $studentId, $content]);
        return $this->pdo->lastInsertId();
    }

    public function getSubmissionById($submissionId) {
        $stmt = $this->pdo->prepare("SELECT * FROM submissions WHERE id = ?");
        $stmt->execute([$submissionId]);
        return $stmt->fetch();
    }

    public function getSubmissionsByActivity($activityId) {
        $stmt = $this->pdo->prepare("SELECT s.*, u.full_name 
            FROM submissions s
            JOIN users u ON s.student_id = u.id
            WHERE activity_id = ?");
        $stmt->execute([$activityId]);
        return $stmt->fetchAll();
    }

    public function updateSimilarityScore($submissionId, $score) {
        $stmt = $this->pdo->prepare("UPDATE submissions 
            SET similarity_score = ? 
            WHERE id = ?");
        return $stmt->execute([$score, $submissionId]);
    }
}
?>