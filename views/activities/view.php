<?php
include PARTIALS_DIR . '/header.php';
include PARTIALS_DIR . '/flash.php';


if (!isset($_SESSION['user'])) {
    header("Location: index.php?action=login");
    exit;
}


if (!isset($userSubmission)) {
    $userSubmission = null;
}


$isClassTeacher = (isset($_SESSION['user']['id']) && isset($class['teacher_id']) && 
                  $_SESSION['user']['id'] === $class['teacher_id']);


function formatFileSize($bytes) {
    if ($bytes === 0) return '0 Bytes';
    $k = 1024;
    $sizes = ['Bytes', 'KB', 'MB', 'GB'];
    $i = floor(log($bytes) / log($k));
    return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
}


$now = time();
$deadlinePassed = ($now > $activity['deadline_timestamp']);
$hasSubmission = ($userSubmission && !empty($userSubmission['id']));
?>

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
        position: relative;
    }
    
    .activity-title {
        font-weight: 700;
        font-size: 2rem;
        color: var(--color-dark);
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-right: 1.5rem;
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
    
    .teacher-actions {
        display: flex;
        gap: 1rem;
    }
    
    .btn-teacher-action {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        padding: 0.8rem 1.5rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
        color: white;
        border: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .btn-new-activity {
        background: linear-gradient(135deg, var(--color-success), #2a9d8f);
    }
    
    .btn-manage-students {
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
    }
    
    .btn-edit-class {
        background: linear-gradient(135deg, #6c757d, #5a6268);
    }
    
    .btn-teacher-action:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    
    .activity-content {
        display: grid;
        grid-template-columns: 8fr 4fr;
        gap: 2rem;
    }
    
    .activity-details-card {
        background-color: var(--color-light);
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .activity-details-header {
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        padding: 1.5rem;
        color: white;
        position: relative;
    }
    
    .activity-details-title {
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
    }
    
    .activity-details-body {
        padding: 1.5rem;
    }
    
    .activity-description {
        color: var(--color-text);
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }
    
    .deadline-alert {
        background: rgba(168, 208, 230, 0.1);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        position: relative;
        border-left: 4px solid;
    }
    
    .deadline-alert.abierta {
        border-left-color: #28a745;
        background: rgba(40, 167, 69, 0.1);
    }
    
    .deadline-alert.vencida {
        border-left-color: #dc3545;
        background: rgba(220, 53, 69, 0.1);
    }
    
    .deadline-info {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }
    
    .deadline-status {
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .resources-section {
        margin-top: 1.5rem;
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
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    .resource-card {
        background-color: white;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: var(--transition);
    }
    
    .resource-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    
    .resource-preview {
        height: 180px;
        overflow: hidden;
        position: relative;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .resource-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .resource-preview iframe {
        width: 100%;
        height: 100%;
        border: none;
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
        transition: var(--transition);
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
    
    .btn-delete {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        width: 36px;
        flex: none;
    }
    
    .btn-delete:hover {
        background: rgba(220, 53, 69, 0.2);
    }
    
    .submission-panel {
        background-color: var(--color-light);
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .submission-header {
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        padding: 1.5rem;
        color: white;
        position: relative;
    }
    
    .submission-title {
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
    }
    
    .submission-body {
        padding: 1.5rem;
    }
    
    .submission-status {
        padding: 1.2rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .status-icon {
        font-size: 2rem;
        flex-shrink: 0;
    }
    
    .status-content {
        flex: 1;
    }
    
    .status-title {
        font-weight: 600;
        margin-bottom: 0.3rem;
    }
    
    .status-meta {
        font-size: 0.9rem;
    }
    
    .status-abierta, .status-entregada {
        background-color: rgba(40, 167, 69, 0.15);
        color: #28a745;
    }
    
    .status-cerrada, .status-vencida {
        background-color: rgba(220, 53, 69, 0.15);
        color: #dc3545;
    }
    
    .status-pendiente {
        background-color: rgba(255, 193, 7, 0.15);
        color: #ffc107;
    }
    
    .btn-submission {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.7rem;
        padding: 0.8rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
        margin-bottom: 0.8rem;
        width: 100%;
    }
    
    .btn-view-submission {
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        color: white;
    }
    
    .btn-edit-submission {
        background: linear-gradient(135deg, #ffc107, #fd7e14);
        color: white;
    }
    
    .btn-cancel-submission {
        background: linear-gradient(135deg, #dc3545, #bd2130);
        color: white;
    }
    
    .btn-submit-activity {
        background: linear-gradient(135deg, var(--color-success), #2a9d8f);
        color: white;
    }
    
    .btn-submission:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    
    .btn-group-vertical {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
    }
    
   
    @media (max-width: 992px) {
        .activity-content {
            grid-template-columns: 1fr;
        }
        
        .teacher-actions {
            flex-wrap: wrap;
            justify-content: flex-end;
        }
    }
    
    @media (max-width: 768px) {
        .activity-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1.5rem;
        }
        
        .teacher-actions {
            width: 100%;
            justify-content: center;
        }
        
        .resources-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="activity-view-section">
    <div class="activity-view-container">
        <div class="activity-header">
            <div class="activity-title-container">
                <div class="activity-icon">
                    <i class="bi bi-card-checklist"></i>
                </div>
                <h1 class="activity-title"><?= htmlspecialchars($activity['title'] ?? 'Actividad no disponible', ENT_QUOTES, 'UTF-8') ?></h1>
            </div>
            
            <?php if ($isClassTeacher): ?>
                <div class="teacher-actions">
                    <a href="index.php?action=edit_activity&id=<?= urlencode($activity['id'] ?? '') ?>" 
                       class="btn-teacher-action btn-edit-class">
                        <i class="bi bi-pencil"></i> Editar Actividad
                    </a>
                    <a href="index.php?action=submissions&id=<?= urlencode($activity['id'] ?? '') ?>" 
                       class="btn-teacher-action btn-manage-students">
                        <i class="bi bi-list-check"></i> Ver Envíos
                    </a>
                </div>
            <?php else: ?>
                <a href="index.php?action=submit_activity&id=<?= urlencode($activity['id'] ?? '') ?>" 
                   class="btn-teacher-action btn-submit-activity">
                    <i class="bi bi-upload"></i> Entregar Trabajo
                </a>
            <?php endif; ?>
        </div>
        
        <div class="activity-content">
            <!-- Sección principal de detalles -->
            <div class="activity-details-card">
                <div class="activity-details-header">
                    <h3 class="activity-details-title">
                        <i class="bi bi-info-circle"></i> Detalles de la Actividad
                    </h3>
                </div>
                <div class="activity-details-body">
                    <p class="activity-description">
                        <?= !empty($activity['description'] ?? '') 
                            ? nl2br(htmlspecialchars($activity['description'], ENT_QUOTES, 'UTF-8'))
                            : 'No hay descripción disponible para esta actividad.' ?>
                    </p>
                    
                    <div class="deadline-alert <?= $deadlinePassed ? 'vencida' : 'abierta' ?>">
                        <div class="deadline-status">
                            <?php if ($deadlinePassed): ?>
                                <i class="bi bi-exclamation-circle"></i>
                                <span class="text-danger">La fecha límite ha pasado</span>
                            <?php else: ?>
                                <i class="bi bi-check-circle"></i>
                                <span class="text-success">Tiempo restante: 
                                    <?php 
                                        $remaining = ($activity['deadline_timestamp'] ?? time()) - $now;
                                        $days = floor($remaining / (60 * 60 * 24));
                                        $hours = floor(($remaining % (60 * 60 * 24)) / (60 * 60));
                                        $minutes = floor(($remaining % (60 * 60)) / 60);
                                        echo $days > 0 ? $days . ' días ' : '';
                                        echo $hours . ' horas ';
                                        echo $minutes . ' minutos';
                                    ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Sección para Recursos Adjuntos -->
                    <?php if (!empty($activityResources)): ?>
                        <div class="resources-section">
                            <h4 class="resources-title">
                                <i class="bi bi-paperclip"></i> Recursos Adjuntos
                            </h4>
                            
                            <div class="resources-grid">
                                <?php foreach ($activityResources as $resource): ?>
                                    <div class="resource-card">
                                        <div class="resource-preview">
                                            <?php if ($resource['type'] === 'file'): ?>
                                                <?php if (strpos($resource['file_type'], 'image/') === 0): ?>
                                                    <img src="/uploads/activities/<?= $resource['stored_name'] ?>" 
                                                         alt="<?= htmlspecialchars($resource['original_name']) ?>">
                                                <?php elseif ($resource['file_type'] === 'application/pdf'): ?>
                                                    <div class="resource-icon">
                                                        <i class="bi bi-file-earmark-pdf"></i>
                                                    </div>
                                                <?php elseif (strpos($resource['file_type'], 'text/') === 0): ?>
                                                    <div class="resource-icon">
                                                        <i class="bi bi-file-earmark-text"></i>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="resource-icon">
                                                        <i class="bi bi-file-earmark"></i>
                                                    </div>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <div class="resource-icon">
                                                    <i class="bi bi-link-45deg"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="resource-body">
                                            <h5 class="resource-name">
                                                <i class="bi bi-<?= $resource['type'] === 'file' ? 'file-earmark' : 'link-45deg' ?>"></i>
                                                <?= htmlspecialchars($resource['original_name'], ENT_QUOTES, 'UTF-8') ?>
                                            </h5>
                                            
                                            <?php if ($resource['type'] === 'file'): ?>
                                                <div class="resource-meta">
                                                    <?= $resource['file_type'] ?> · 
                                                    <?= formatFileSize($resource['size']) ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="resource-actions">
                                                <?php if ($resource['type'] === 'file'): ?>
                                                    <a href="index.php?action=download_file&file_id=<?= $resource['id'] ?>&type=activity" 
                                                       class="btn-resource btn-download">
                                                        <i class="bi bi-download"></i> Descargar
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?= $resource['original_name'] ?>" 
                                                       target="_blank" 
                                                       class="btn-resource btn-view">
                                                        <i class="bi bi-box-arrow-up-right"></i> Ver
                                                    </a>
                                                <?php endif; ?>
                                                
                                                <?php if ($isClassTeacher): ?>
                                                    <a href="index.php?action=delete_activity_resource&resource_id=<?= $resource['id'] ?>" 
                                                       class="btn-resource btn-delete"
                                                       onclick="return confirm('¿Eliminar este recurso?')">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Panel de entrega para estudiantes -->
            <?php if (!$isClassTeacher): ?>
                <div class="submission-panel">
                    <div class="submission-header">
                        <h3 class="submission-title">
                            <i class="bi bi-send"></i> Tu Entrega
                        </h3>
                    </div>
                    <div class="submission-body">
                        <?php if ($hasSubmission): ?>
                            <div class="submission-status status-entregada">
                                <div class="status-icon">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <div class="status-content">
                                    <div class="status-title">Entregado</div>
                                    <div class="status-meta">
                                        Fecha: <?= date('d/m/Y H:i:s', $userSubmission['submitted_timestamp']) ?>
                                    </div>
                                    <?php if (isset($userSubmission['similarity'])): ?>
                                        <div class="status-meta">
                                            Similitud: 
                                            <span class="badge bg-<?= $userSubmission['similarity'] > 50 ? 'danger' : 'success' ?>">
                                                <?= $userSubmission['similarity'] ?>%
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="btn-group-vertical">
                                <a href="index.php?action=view_submission&id=<?= $userSubmission['id'] ?>" 
                                   class="btn-submission btn-view-submission">
                                    <i class="bi bi-eye"></i> Ver mi entrega
                                </a>
                                
                                <?php if (!$deadlinePassed): ?>
                                    
                                    <a href="index.php?action=cancel_submission&id=<?= $userSubmission['id'] ?>" 
                                       class="btn-submission btn-cancel-submission"
                                       onclick="return confirm('¿Estás seguro de anular esta entrega?')">
                                        <i class="bi bi-trash"></i> Anular entrega
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div class="submission-status <?= $deadlinePassed ? 'status-vencida' : 'status-pendiente' ?>">
                                <div class="status-icon">
                                    <i class="bi bi-<?= $deadlinePassed ? 'exclamation-triangle' : 'clock' ?>"></i>
                                </div>
                                <div class="status-content">
                                    <div class="status-title">
                                        <?= $deadlinePassed ? 'Vencida' : 'Pendiente' ?>
                                    </div>
                                    <div class="status-meta">
                                        <?= $deadlinePassed 
                                            ? 'La fecha límite ha pasado' 
                                            : 'Aún no has entregado esta actividad' ?>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if (!$deadlinePassed): ?>
                                <a href="index.php?action=submit_activity&id=<?= $activity['id'] ?>" 
                                   class="btn-submission btn-submit-activity">
                                    <i class="bi bi-upload"></i> Entregar trabajo
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include PARTIALS_DIR . '/footer.php'; ?>

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
        
        
        const submissionPanel = document.querySelector('.submission-panel');
        if (submissionPanel) {
            submissionPanel.style.opacity = '0';
            setTimeout(() => {
                submissionPanel.style.transition = 'opacity 0.8s ease';
                submissionPanel.style.opacity = '1';
            }, 500);
        }
    });
</script>