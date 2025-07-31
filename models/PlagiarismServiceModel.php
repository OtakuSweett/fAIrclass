<?php
require_once __DIR__ . '/../includes/helpers.php'; 

class PlagiarismReportModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function createReport(int $submissionId, array $reportData): bool {
        $stmt = $this->pdo->prepare("INSERT INTO plagiarism_reports (submission_id, report_data) VALUES (?, ?)");
        return $stmt->execute([$submissionId, json_encode($reportData)]);
    }

    public function getReportsBySubmission(int $submissionId): array {
        $stmt = $this->pdo->prepare("SELECT * FROM plagiarism_reports WHERE submission_id = ?");
        $stmt->execute([$submissionId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDetailedReport(int $reportId): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM plagiarism_reports WHERE id = ?");
        $stmt->execute([$reportId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result === false ? null : $result;
    }
}



class PlagiarismService {
    private $detector;
    private $pdo;

    public function __construct() {
        $this->pdo = getDatabaseConnection();
    }

    /**
     * Revisa la entrega indicada por ID y retorna un análisis de similitud.
     */
    public function checkSubmission(int $submissionId): array {
        $submission = $this->getSubmissionText($submissionId);
        if (!$submission) {
            throw new Exception("No se encontró el contenido de la entrega ID: {$submissionId}");
        }

        
        $localCheck = $this->basicLocalCheck($submission);
        $aiCheck = $this->detector->detectAIText($submission);

        return $this->formatResults($localCheck, $aiCheck);
    }

    /**
     * Extrae el contenido textual de una entrega por su ID.
     */
    private function getSubmissionText(int $id): ?string {
        $stmt = $this->pdo->prepare("SELECT content FROM submissions WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn() ?: null;
    }

    /**
     * Compara el texto con todas las demás entregas usando similar_text().
     */
    private function basicLocalCheck(string $text): array {
        $existingTexts = $this->getAllSubmissions();
        $maxSimilarity = 0.0;

        foreach ($existingTexts as $existing) {
            similar_text($text, $existing, $similarity);
            $maxSimilarity = max($maxSimilarity, $similarity);
        }

        return [
            'similarity' => round($maxSimilarity, 2),
            'warning' => $maxSimilarity > 70.0
        ];
    }

    /**
     * Obtiene todos los textos de entregas pasadas.
     */
    private function getAllSubmissions(): array {
        $stmt = $this->pdo->query("SELECT content FROM submissions");
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    /**
     * Da formato al resultado combinando local + IA.
     */
    private function formatResults(array $local, array $ai): array {
        return [
            'local_similarity' => $local['similarity'] . '%',
            'ai_detection' => !empty($ai['is_ai']) ? 'Posible IA' : 'Probable humano',
            'ai_confidence' => (isset($ai['confidence']) ? round($ai['confidence'], 2) : 0) . '%',
            'needs_review' => $local['warning'] || (!empty($ai['is_ai']))
        ];
    }
}
