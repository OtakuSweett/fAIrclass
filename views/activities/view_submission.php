<?php include PARTIALS_DIR . '/header.php'; ?>
<?php include PARTIALS_DIR . '/flash.php'; ?>

<style>
   
    .activity-view-section {
        padding: 2rem 0;
        min-height: calc(100vh - 80px);
        background: linear-gradient(135deg, rgba(168, 208, 230, 0.05), rgba(248, 183, 216, 0.05));
    }
    
    .activity-view-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }
    
    .activity-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--color-primary);
        position: relative;
    }
    
    .activity-header::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 80px;
        height: 2px;
        background: var(--color-secondary);
    }
    
    .activity-title-container {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .activity-title {
        font-weight: 700;
        font-size: 2rem;
        color: var(--color-dark);
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .activity-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.8rem;
        flex-shrink: 0;
    }
    
    .activity-content {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .details-card {
        background-color: var(--color-light);
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .card-header {
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        padding: 1.5rem;
        color: white;
        position: relative;
    }
    
    .card-title {
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    .detail-item {
        margin-bottom: 1.2rem;
    }
    
    .detail-label {
        font-weight: 600;
        color: var(--color-dark);
        margin-bottom: 0.3rem;
    }
    
    .detail-value {
        color: var(--color-text);
        padding: 0.5rem;
        background: rgba(168, 208, 230, 0.1);
        border-radius: var(--border-radius);
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
    }
    
    .status-pendiente {
        background-color: rgba(255, 193, 7, 0.15);
        color: #ffc107;
    }
    
    .status-calificada {
        background-color: rgba(40, 167, 69, 0.15);
        color: #28a745;
    }
    
    .status-rechazada {
        background-color: rgba(220, 53, 69, 0.15);
        color: #dc3545;
    }
    
    .similarity-progress {
        height: 20px;
        border-radius: 10px;
        overflow: hidden;
        background-color: #e9ecef;
    }
    
    .similarity-progress-bar {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 600;
        color: white;
    }
    
    .bg-similarity-low {
        background-color: #28a745;
    }
    
    .bg-similarity-medium {
        background-color: #ffc107;
    }
    
    .bg-similarity-high {
        background-color: #dc3545;
    }
    
    .resources-section {
        margin-top: 2rem;
    }
    
    .resources-title {
        font-weight: 700;
        font-size: 1.3rem;
        color: var(--color-dark);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid rgba(0,0,0,0.1);
    }
    
    .resources-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }
    
    .resource-card {
        background-color: white;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    
    .resource-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    
    .resource-preview {
        height: 160px;
        overflow: hidden;
        position: relative;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    
    .resource-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .resource-icon {
        font-size: 3rem;
        color: var(--color-primary);
        opacity: 0.3;
    }
    
    .resource-body {
        padding: 1.2rem;
    }
    
    .resource-name {
        font-weight: 600;
        color: var(--color-dark);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .resource-meta {
        font-size: 0.85rem;
        color: var(--color-text);
        margin-bottom: 1rem;
    }
    
    .resource-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-resource {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.5rem;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-download {
        background: rgba(168, 208, 230, 0.15);
        color: var(--color-primary);
    }
    
    .btn-download:hover {
        background: rgba(168, 208, 230, 0.3);
    }
    
    .btn-view {
        background: rgba(248, 183, 216, 0.15);
        color: var(--color-secondary);
    }
    
    .btn-view:hover {
        background: rgba(248, 183, 216, 0.3);
    }
    
    .plagiarism-card {
        margin-top: 2rem;
    }
    
    .plagiarism-alert {
        padding: 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
    }
    
    .bg-plagiarism-low {
        background-color: rgba(40, 167, 69, 0.15);
        color: #28a745;
    }
    
    .bg-plagiarism-medium {
        background-color: rgba(255, 193, 7, 0.15);
        color: #ffc107;
    }
    
    .bg-plagiarism-high {
        background-color: rgba(220, 53, 69, 0.15);
        color: #dc3545;
    }
    
    .evaluation-form {
        margin-top: 2rem;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }
    
    .form-actions {
        margin-top: 1.5rem;
    }
    
   
    @media (max-width: 992px) {
        .details-grid {
            grid-template-columns: 1fr;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 768px) {
        .resources-grid {
            grid-template-columns: 1fr;
        }
    }
    
   
    .submission-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }
    
    @media (max-width: 992px) {
        .submission-info {
            grid-template-columns: 1fr;
        }
    }
    
    .student-card {
        display: flex;
        flex-direction: column;
    }
    
.student-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    position: relative;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
}


.student-avatar img.student-profile-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}


.student-avatar .student-initials {
    color: white;
    font-size: 2rem;
    font-weight: bold;
    display: none;
    text-transform: uppercase;
}


.student-avatar.no-image .student-initials {
    display: flex;
}


.student-avatar.no-image img {
    display: none !important;
}


    .student-details {
        flex: 1;
    }
    
 
.plagiarism-details {
    background-color: var(--color-light);
    border-radius: 8px;
    padding: 20px;
    margin-top: 20px;
    box-shadow: var(--box-shadow);
}

.plagiarism-section-title {
    font-weight: 700;
    font-size: 1.2rem;
    color: var(--color-primary);
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid var(--color-secondary);
}

.sources-table {
    width: 100%;
    border-collapse: collapse;
}

.sources-table th, .sources-table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid var(--color-border);
    color: var(--color-text);
}

.sources-table th {
    background-color: var(--color-light);
    font-weight: 600;
    color: var(--color-primary);
}

.sources-table tr:hover {
    background-color: rgba(168, 208, 230, 0.1);
}

.suspicious-sentence {
    background-color: rgba(255, 243, 205, 0.2);
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 10px;
    border-left: 4px solid var(--color-warning);
    color: var(--color-text);
}

.suspicious-reason {
    font-size: 0.9rem;
    color: var(--color-warning);
    margin-top: 8px;
}

.ai-detection-badge {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
    color: white;
}

.ai-detected {
    background-color: var(--color-danger);
}

.ai-not-detected {
    background-color: var(--color-success);
}

.report-metadata {
    background-color: rgba(226, 240, 255, 0.2);
    padding: 15px;
    border-radius: 8px;
    font-size: 0.9rem;
    margin-top: 20px;
    color: var(--color-text);
    border: 1px solid var(--color-border);
}


.progress {
    background-color: var(--color-border);
}

.progress-bar {
    color: #fff;
    font-weight: 600;
}


.plagiarism-section p,
.plagiarism-section strong,
.report-metadata p {
    color: var(--color-text);
}


@media (max-width: 768px) {
    .similarity-progress-bar {
        font-size: 0.65rem;
    }
}
</style>

<?php 

function formatFileSize($bytes) {
    if ($bytes === 0) return '0 Bytes';
    $k = 1024;
    $sizes = ['Bytes', 'KB', 'MB', 'GB'];
    $i = floor(log($bytes) / log($k));
    return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
}
?>

<div class="activity-view-section">
    <div class="activity-view-container">
        <div class="activity-header">
            <div class="activity-title-container">
                <div class="activity-icon">
                    <i class="bi bi-send-check"></i>
                </div>
                <h1 class="activity-title">Detalles de Entrega</h1>
            </div>
            
            <a href="index.php?action=view_activity&id=<?= $activity['id'] ?? '' ?>" 
               class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver a la actividad
            </a>
        </div>
        
        <div class="activity-content">
            <div class="details-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-info-circle"></i> Información General
                    </h3>
                </div>
                <div class="card-body">
                    <div class="submission-info">
                        <!-- Información del estudiante -->
                        <div class="details-card student-card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="bi bi-person"></i> Estudiante
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="d-flex">
                                    <?php
                                        $studentId = $student['id'] ?? '';
                                        $studentName = $student['full_name'] ?? 'Nombre no disponible';
                                        $fotoEstudiante = function_exists('obtenerFotoPerfil') 
                                            ? obtenerFotoPerfil($studentId, $pdo, false) 
                                            : '';
                                        $hasImage = !empty($fotoEstudiante);
                                    ?>
                                    <div class="student-avatar <?= !$hasImage ? 'no-image' : '' ?>">
                                        <?php if ($hasImage): ?>
                                            <img src="<?= htmlspecialchars($fotoEstudiante) ?>" 
                                                 alt="Foto de <?= htmlspecialchars($studentName) ?>" 
                                                 class="student-profile-img"
                                                 onerror="this.onerror=null; this.parentElement.classList.add('no-image'); this.style.display='none';">
                                        <?php endif; ?>
                                        
                                        <span class="student-initials">
                                            <?php
                                                $initials = '';
                                                if (!empty($studentName)) {
                                                    $nameParts = explode(' ', trim($studentName));
                                                    $initials .= strtoupper(substr($nameParts[0] ?? '', 0, 1));
                                                }
                                                echo htmlspecialchars($initials);
                                            ?>
                                        </span>
                                    </div>

                                    <div class="student-details">
                                        <h4><?= htmlspecialchars(($student['first_name'] ?? '') . ' ' . ($student['full_name']) )?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Detalles de entrega -->
                        <div class="details-card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="bi bi-clock-history"></i> Detalles de Entrega
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="details-grid">
                                    <div class="detail-item">
                                        <div class="detail-label">Actividad</div>
                                        <div class="detail-value"><?= htmlspecialchars($activity['title'] ?? 'Actividad no disponible') ?></div>
                                    </div>
                                    
                                    <div class="detail-item">
                                        <div class="detail-label">Fecha de entrega</div>
                                        <div class="detail-value">
                                            <?= !empty($submission['submitted_timestamp']) 
                                                ? date('d/m/Y H:i:s', $submission['submitted_timestamp']) 
                                                : 'No disponible' ?>
                                        </div>
                                    </div>
                                    
                                    <div class="detail-item">
                                        <div class="detail-label">Estado</div>
                                        <div class="detail-value">
                                            <?php
                                            $status = $submission['status'] ?? 'desconocido';
                                            $statusClass = match(strtolower($status)) {
                                                'calificada' => 'status-calificada',
                                                'pendiente' => 'status-pendiente',
                                                'rechazada' => 'status-rechazada',
                                                default => 'status-pendiente'
                                            };
                                            ?>
                                            <span class="status-badge <?= $statusClass ?>">
                                                <i class="bi 
                                                    <?= $status === 'calificada' ? 'bi-check-circle' : 
                                                       ($status === 'pendiente' ? 'bi-clock' : 'bi-x-circle') ?>">
                                                </i>
                                                <?= ucfirst($status) ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="detail-item">
                                        <div class="detail-label">Calificación</div>
                                        <div class="detail-value">
                                            <?= isset($submission['grade']) && $submission['grade'] !== null 
                                                ? $submission['grade'] 
                                                : 'Sin calificar' ?>
                                        </div>
                                    </div>
                                    
                                    <div class="detail-item">
                                        <div class="detail-label">Similitud</div>
                                        <div class="detail-value">
                                            <?php 
                                            $similarity = $submission['similarity_score'] ?? 0;
                                            $progressClass = $similarity < 30 ? 'bg-similarity-low' : 
                                                           ($similarity < 70 ? 'bg-similarity-medium' : 'bg-similarity-high');
                                            ?>
                                            <div class="similarity-progress">
                                                <div class="similarity-progress-bar <?= $progressClass ?>" 
                                                     style="width: <?= $similarity ?>%">
                                                    <?= $similarity ?>%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido y comentarios -->
                    <div class="details-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="bi bi-chat-left-text"></i> Contenido y Comentarios
                            </h3>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($submission['content'])): ?>
                                <div class="detail-item">
                                    <div class="detail-label">Contenido de la entrega</div>
                                    <div class="detail-value border rounded p-3 bg-light">
                                        <div style="color: black;">
                                            <?= nl2br(htmlspecialchars($submission['content'])) ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="detail-item">
                                <div class="detail-label">Comentarios del profesor</div>
                                <div class="detail-value border rounded p-3 bg-light">
                                    <div style="color: black;"><?= !empty($submission['comments']) 
                                        ? nl2br(htmlspecialchars($submission['comments'])) 
                                        : '<em>Sin comentarios</em>' ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Archivos adjuntos -->
                    <?php if (!empty($submissionResources)): ?>
                        <div class="details-card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="bi bi-paperclip"></i> Archivos Adjuntos
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="resources-grid">
                                    <?php foreach ($submissionResources as $resource): 
                                        $fileExtension = pathinfo($resource['original_name'], PATHINFO_EXTENSION);
                                        $icon = match(strtolower($fileExtension)) {
                                            'pdf' => 'bi-file-earmark-pdf',
                                            'doc', 'docx' => 'bi-file-earmark-word',
                                            'xls', 'xlsx' => 'bi-file-earmark-excel',
                                            'ppt', 'pptx' => 'bi-file-earmark-ppt',
                                            'jpg', 'jpeg', 'png', 'gif' => 'bi-file-earmark-image',
                                            'zip', 'rar' => 'bi-file-earmark-zip',
                                            'mp3', 'wav' => 'bi-file-earmark-music',
                                            'mp4', 'mov' => 'bi-file-earmark-play',
                                            default => 'bi-file-earmark'
                                        };
                                    ?>
                                        <div class="resource-card">
                                            <div class="resource-preview">
                                                <div class="resource-icon">
                                                    <i class="bi <?= $icon ?>"></i>
                                                </div>
                                            </div>
                                            
                                            <div class="resource-body">
                                                <h5 class="resource-name">
                                                    <?= htmlspecialchars($resource['original_name']) ?>
                                                </h5>
                                                
                                                <div class="resource-meta">
                                                    <?= strtoupper($fileExtension) ?> · 
                                                    <?= formatFileSize($resource['size']) ?>
                                                </div>
                                                
                                                <div class="resource-actions">
                                                    <a href="index.php?action=download_file&file_id=<?= $resource['id'] ?>" 
                                                       class="btn-resource btn-download">
                                                        <i class="bi bi-download"></i> Descargar
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Reporte de plagio -->
                    <?php if (!empty($plagiarismReport)): ?>
                        <div class="details-card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="bi bi-file-bar-graph"></i> Reporte de Plagio
                                </h3>
                            </div>
                            <div class="card-body plagiarism-details">
                                <!-- Similitud y detección de IA -->
                                <div class="plagiarism-section">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="plagiarism-section-title">Resumen</h4>
                                            <div class="mb-4">
                                                <p><strong>Similitud:</strong></p>
                                                <div class="progress" style="height: 25px;">
                                                    <div class="progress-bar 
                                                        <?= $plagiarismReport['similarity'] < 30 ? 'bg-success' : 
                                                            ($plagiarismReport['similarity'] < 70 ? 'bg-warning' : 'bg-danger') ?>" 
                                                        role="progressbar" 
                                                        style="width: <?= $plagiarismReport['similarity'] ?>%;"
                                                        aria-valuenow="<?= $plagiarismReport['similarity'] ?>" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                        <?= $plagiarismReport['similarity'] ?>%
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-4">
                                                <p><strong>Detección de IA:</strong></p>
                                                <div class="ai-detection-badge 
                                                    <?= $plagiarismReport['ai_detection'] ? 'ai-detected' : 'ai-not-detected' ?>">
                                                    <i class="bi 
                                                        <?= $plagiarismReport['ai_detection'] ? 'bi-robot' : 'bi-person' ?>"></i>
                                                    <?= $plagiarismReport['ai_detection'] ? 'Posible IA' : 'Probable humano' ?>
                                                    (Confianza: <?= $plagiarismReport['ai_confidence'] ?>%)
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="report-metadata">
                                                <p><strong>Reporte ID:</strong> <?= $plagiarismReport['report_id'] ?? 'N/A' ?></p>
                                                <p><strong>Generado el:</strong> <?= $plagiarismReport['generated_at'] ?? 'N/A' ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Fuentes similares -->
                                <?php if (!empty($plagiarismReport['sources'])): ?>
                                    <div class="plagiarism-section">
                                        <h4 class="plagiarism-section-title">Fuentes similares</h4>
                                        <div class="table-responsive">
                                            <table class="table table-bordered sources-table">
                                                <thead>
                                                    <tr>
                                                        <th>Estudiante</th>
                                                        <th>Archivo</th>
                                                        <th>Similitud</th>
                                                        <th>Fecha</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($plagiarismReport['sources'] as $source): ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($source['student_name'] ?? 'Desconocido') ?></td>
                                                            <td><?= htmlspecialchars($source['file_name'] ?? '') ?></td>
                                                            <td><?= $source['similarity'] ?? '0' ?>%</td>
                                                            <td><?= !empty($source['submission_date']) 
                                                                ? date('d/m/Y', strtotime($source['submission_date'])) 
                                                                : 'N/A' ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Secciones sospechosas -->
                                <?php if (!empty($plagiarismReport['suspicious_sections'])): ?>
                                    <div class="plagiarism-section">
                                        <h4 class="plagiarism-section-title">Secciones sospechosas</h4>
                                        <div class="suspicious-sentences">
                                            <?php foreach ($plagiarismReport['suspicious_sections'] as $index => $section): ?>
                                                <div class="suspicious-sentence">
                                                    <p><strong>Sección #<?= $index + 1 ?>:</strong></p>
                                                    <p><?= htmlspecialchars($section['sentence'] ?? '') ?></p>
                                                    <div class="suspicious-reason">
                                                        <strong>Razón:</strong> <?= $section['reason'] ?? '' ?>
                                                        <span class="badge bg-secondary ms-2">Score: <?= $section['score'] ?? '0.0' ?></span>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php elseif ($isTeacher): ?>
                        <div class="details-card">
                            <div class="card-body text-center">
                                <p class="mb-3">No hay un reporte de plagio disponible para esta entrega.</p>
                                <a href="index.php?action=generate_report&id=<?= $submission['id'] ?>" 
                                   class="btn btn-primary">
                                    <i class="bi bi-file-earmark-bar-graph me-1"></i> Generar Reporte
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Evaluación (solo para profesores) -->
                    <?php if ($isTeacher): ?>
                        <div class="details-card evaluation-form">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="bi bi-check-square"></i> Evaluación
                                </h3>
                            </div>
                            <div class="card-body">
                                <form action="index.php?action=grade_submission&id=<?= $submission['id'] ?>" method="post">
                                    <div class="form-grid">
                                        <div class="detail-item">
                                            <label for="grade" class="detail-label">Calificación</label>
                                            <input type="number" class="form-control" id="grade" name="grade" 
                                                   min="0" max="100" step="0.1"
                                                   value="<?= $submission['grade'] ?? '' ?>">
                                        </div>
                                        
                                        <div class="detail-item">
                                            <label for="status" class="detail-label">Estado</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="pendiente" <?= ($submission['status'] ?? '') === 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                                <option value="calificada" <?= ($submission['status'] ?? '') === 'calificada' ? 'selected' : '' ?>>Calificada</option>
                                                <option value="rechazada" <?= ($submission['status'] ?? '') === 'rechazada' ? 'selected' : '' ?>>Rechazada</option>
                                            </select>
                                        </div>
                                        
                                        <div class="detail-item" style="grid-column: span 2;">
                                            <label for="comments" class="detail-label">Comentarios</label>
                                            <textarea class="form-control" id="comments" name="comments" rows="4"><?= $submission['comments'] ?? '' ?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="bi bi-save me-1"></i> Guardar Evaluación
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        
        const resourceCards = document.querySelectorAll('.resource-card');
        resourceCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 300 + (index * 100));
        });
        
        
        const detailItems = document.querySelectorAll('.detail-item');
        detailItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateX(-20px)';
            
            setTimeout(() => {
                item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                item.style.opacity = '1';
                item.style.transform = 'translateX(0)';
            }, 200 + (index * 100));
        });
    });
</script>

<?php include PARTIALS_DIR . '/footer.php'; ?>