<?php
require_once 'vendor/autoload.php';

class PlagiarismService {
    private $pdo;
    private $aiDetectorEnabled;
    private $apiKey;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->aiDetectorEnabled = true;
        $this->apiKey = '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';
    }

    public function analyzeSubmission(int $submissionId, string $filePath = null): array {
        
        $submission = $this->getSubmissionData($submissionId);
        
        
        if ($filePath) {
            $content = $this->extractTextFromFile($filePath);
        } else {
            $content = $submission['content'];
        }
        
        
        $metadata = [
            'submission_id' => $submissionId,
            'activity_id' => $submission['activity_id'],
            'student_id' => $submission['user_id'],
            'student_name' => $submission['student_name'],
            'file_name' => $filePath ? basename($filePath) : $submission['file_name']
        ];
        
        
        $localResult = $this->calculateLocalSimilarity($content, $submission['activity_id']);
        $aiResult = $this->detectAIGeneratedContent($content);
        $suspiciousSections = $this->findSuspiciousSections($content);
        
        
        $report = [
            'similarity' => round($localResult['similarity'], 2),
            'sources' => $localResult['sources'],
            'ai_detection' => $aiResult > 0.5,
            'ai_confidence' => round($aiResult * 100, 2),
            'suspicious_sections' => $suspiciousSections,
            'metadata' => $metadata,
            'generated_at' => date('Y-m-d H:i:s'),
            'report_id' => uniqid('report_')
        ];
        
        return $report;
    }

    public function extractTextFromFile(string $filePath): string {
        if (!file_exists($filePath)) {
            throw new Exception("Archivo no encontrado: $filePath");
        }
        
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        
        switch ($extension) {
            case 'pdf':
                return $this->extractFromPDF($filePath);
            case 'docx':
                return $this->extractFromDOCX($filePath);
            case 'txt':
                return file_get_contents($filePath);
            case 'doc':
                return $this->extractFromDOC($filePath);
            default:
                throw new Exception("Formato no soportado: $extension");
        }
    }

    private function extractFromPDF(string $filePath): string {
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($filePath);
        return $pdf->getText();
    }

    private function extractFromDOCX(string $filePath): string {
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($filePath);
        $content = '';
        
        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                    foreach ($element->getElements() as $text) {
                        if ($text instanceof \PhpOffice\PhpWord\Element\Text) {
                            $content .= $text->getText() . ' ';
                        }
                    }
                }
            }
        }
        
        return $content;
    }

    private function extractFromDOC(string $filePath): string {
        
        if (!function_exists('shell_exec')) {
            throw new Exception("La función shell_exec no está habilitada");
        }
        
        $output = shell_exec("antiword \"$filePath\"");
        return $output ?: '';
    }

    /**
     * Calcula similitud con fuentes identificadas
     */
    private function calculateLocalSimilarity(string $text, int $activityId): array {
        $result = [
            'similarity' => 0.0,
            'sources' => []
        ];
        
        if (str_word_count($text) < 10) return $result;
        
        $existingTexts = $this->getActivitySubmissions($activityId);
        $text = strtolower($text);
        
        foreach ($existingTexts as $submission) {
            if (!$submission['content']) continue;
            
            $submissionText = strtolower($submission['content']);
            similar_text($text, $submissionText, $similarity);
            
            if ($similarity > $result['similarity']) {
                $result['similarity'] = $similarity;
            }
            
            if ($similarity > 20) {
                $result['sources'][] = [
                    'student_id' => $submission['user_id'],
                    'student_name' => $submission['student_name'],
                    'file_name' => $submission['file_name'],
                    'similarity' => round($similarity, 2),
                    'submission_date' => $submission['submitted_at']
                ];
            }
        }
        
        return $result;
    }

    /**
     * Obtiene entregas anteriores con metadatos para una actividad
     */
    private function getActivitySubmissions(int $activityId): array {
        $stmt = $this->pdo->prepare("
            SELECT s.id, s.content, s.file_name, s.submitted_at, 
                   u.id AS user_id, u.full_name AS student_name
            FROM submissions s
            JOIN users u ON s.user_id = u.id
            WHERE s.activity_id = ?
            AND LENGTH(s.content) > 50
            ORDER BY s.submitted_at DESC
        ");
        $stmt->execute([$activityId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Detecta contenido generado por IA
     */
    private function detectAIGeneratedContent(string $text): float {
        
        if ($_SERVER['SERVER_NAME'] === 'localhost' || !$this->aiDetectorEnabled) {
            
            $length = strlen($text);
            $score = min(1, $length / 5000);
            return round($score * 0.7, 2);
        }
        
        
        try {
            $url = 'https://api-inference.huggingface.co/models/Hello-SimpleAI/chatgpt-detector-roberta';
            $headers = [
                'Authorization: Bearer ' . $this->apiKey,
                'Content-Type: application/json'
            ];
            
            $data = json_encode(['inputs' => $text]);
            
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYPEER => false
            ]);
            
            $response = curl_exec($ch);
            curl_close($ch);
            
            $result = json_decode($response, true);
            
            if (isset($result[0])) {
                foreach ($result[0] as $item) {
                    if ($item['label'] === 'AI') {
                        return min(1, max(0, $item['score']));
                    }
                }
            }
        } catch (Exception $e) {
            error_log("Error en detección de IA: " . $e->getMessage());
        }
        
        return 0.0;
    }

    /**
     * Identifica secciones sospechosas con comparación
     */
    private function findSuspiciousSections(string $text): array {
        $suspicious = [];
        $sentences = preg_split('/(?<=[.?!])\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        
        foreach ($sentences as $sentence) {
            
            if ($this->detectAIPatterns($sentence)) {
                $suspicious[] = [
                    'sentence' => $sentence,
                    'reason' => 'patron_ia',
                    'score' => 0.7
                ];
            }
            
            
            if (str_word_count($sentence) > 50) {
                $suspicious[] = [
                    'sentence' => $sentence,
                    'reason' => 'frase_muy_larga',
                    'score' => 0.4
                ];
            }
        }
        
        return $suspicious;
    }

    private function detectAIPatterns(string $sentence): bool {
        $aiPatterns = [
            '/\b(en conclusión|es evidente que|como podemos ver|a lo largo de la historia)\b/i',
            '/\b(sin embargo|no obstante|por otro lado|en resumen|además)\b/i',
            '/\b(es importante destacar|vale la pena mencionar|cabe señalar)\b/i'
        ];
        
        foreach ($aiPatterns as $pattern) {
            if (preg_match($pattern, $sentence)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Obtiene datos completos de una entrega
     */
    private function getSubmissionData(int $submissionId): array {
        $stmt = $this->pdo->prepare("
            SELECT s.*, u.full_name AS student_name
            FROM submissions s
            JOIN users u ON s.user_id = u.id
            WHERE s.id = ?
        ");
        $stmt->execute([$submissionId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$result) {
            throw new Exception("Entrega no encontrada: $submissionId");
        }
        
        return $result;
    }
}