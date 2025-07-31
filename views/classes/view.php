<?php include PARTIALS_DIR . '/header.php'; ?>
<?php include PARTIALS_DIR . '/flash.php'; ?>
<style>
   
    .class-view-section {
        padding: 2rem 0;
        min-height: calc(100vh - 80px);
        background: linear-gradient(135deg, rgba(168, 208, 230, 0.05), rgba(248, 183, 216, 0.05));
    }
    
    .class-view-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }
    
    .class-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--color-primary);
        position: relative;
    }
    
    .class-header::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 80px;
        height: 2px;
        background: var(--color-secondary);
    }
    
    .class-title-container {
        display: flex;
        align-items: center;
        gap: 1rem;
        position: relative;
    }
    
    .class-title {
        font-weight: 700;
        font-size: 2rem;
        color: var(--color-dark);
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-right: 1.5rem;
    }
    
    .class-icon {
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
    }
    
    .btn-new-activity {
        background: linear-gradient(135deg, var(--color-success), #2a9d8f);
        color: white;
        border: none;
    }
    
    .btn-manage-students {
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        color: white;
        border: none;
    }
    
    .btn-edit-class {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        color: white;
        border: none;
    }
    
    .btn-teacher-action:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    
    .class-content {
        display: grid;
        grid-template-columns: 8fr 4fr;
        gap: 2rem;
    }
    
   
    .activities-section {
        margin-bottom: 3rem;
    }
    
    .section-title {
        font-weight: 700;
        font-size: 1.6rem;
        color: var(--color-dark);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }
    
    .activities-list {
        background-color: var(--color-light);
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
    }
    
    .activity-item {
        display: flex;
        padding: 1.5rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        transition: var(--transition);
        text-decoration: none;
        color: var(--color-text);
        position: relative;
    }
    
    .activity-item:hover {
        background-color: rgba(168, 208, 230, 0.1);
    }
    
    .activity-content-container {
        display: flex;
        width: 100%;
        gap: 1.5rem;
    }
    
    .activity-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    
    .activity-content {
        flex: 1;
    }
    
    .activity-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.5rem;
    }
    
    .activity-title {
        font-weight: 600;
        color: var(--color-dark);
        margin-right: 1rem;
    }
    
    .activity-top-right {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
    
    .activity-status {
        font-size: 0.8rem;
        font-weight: 600;
        padding: 0.3rem 0.8rem;
        border-radius: 50px;
    }
    
    .activity-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        color: var(--color-text);
        font-size: 0.9rem;
        align-items: center;
    }
    
    .activity-deadline {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .activity-deadline .badge {
        padding: 0.3rem 0.8rem;
        border-radius: 50px;
        font-weight: 500;
    }
    
    .activity-submissions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .activity-submissions .badge {
        padding: 0.3rem 0.8rem;
        border-radius: 50px;
        font-weight: 500;
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
    
    .badge-abierta, .badge-entregada {
        background-color: rgba(40, 167, 69, 0.15);
        color: #28a745;
    }
    
    .badge-cerrada, .badge-vencida {
        background-color: rgba(220, 53, 69, 0.15);
        color: #dc3545;
    }
    
    .badge-pendiente {
        background-color: rgba(255, 193, 7, 0.15);
        color: #ffc107;
    }
    
    .icon-abierta, .icon-entregada {
        background-color: rgba(40, 167, 69, 0.15);
        color: #28a745;
    }
    
    .icon-cerrada, .icon-vencida {
        background-color: rgba(220, 53, 69, 0.15);
        color: #dc3545;
    }
    
    .icon-pendiente {
        background-color: rgba(255, 193, 7, 0.15);
        color: #ffc107;
    }
    
   
    .class-info-card {
        background-color: var(--color-light);
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .class-info-header {
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        padding: 1.5rem;
        color: white;
        position: relative;
    }
    
    .class-info-title {
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
    }
    
    .class-info-body {
        padding: 1.5rem;
    }
    
    .class-description {
        color: var(--color-text);
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }
    
    .class-code-container {
        background: rgba(168, 208, 230, 0.1);
        padding: 1rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        position: relative;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .class-code-container:hover {
        background: rgba(168, 208, 230, 0.2);
        transform: translateY(-2px);
    }
    
    .class-code-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
    }
    
    .class-code-value {
        font-size: 1.2rem;
        font-weight: 700;
        letter-spacing: 1px;
        background: rgba(255,255,255,0.2);
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius);
        display: inline-block;
        transition: all 0.3s ease;
    }
    
    .copy-indicator {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 0.8rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .students-section {
        margin-top: 1.5rem;
    }
    
    .students-list {
        max-height: 300px;
        overflow-y: auto;
    }
    
    .student-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.8rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        transition: var(--transition);
    }
    
    .student-item:hover {
        background-color: rgba(168, 208, 230, 0.05);
    }
    
    .empty-activities {
        text-align: center;
        padding: 3rem;
        background: rgba(168, 208, 230, 0.05);
        border-radius: var(--border-radius);
        margin: 2rem 0;
    }
    
    .empty-icon {
        font-size: 3rem;
        color: var(--color-primary);
        opacity: 0.3;
        margin-bottom: 1.5rem;
    }
    
    .empty-text {
        font-size: 1.1rem;
        color: var(--color-text);
        max-width: 500px;
        margin: 0 auto;
    }
    
    .btn-edit-activity {
        background: rgba(255,255,255,0.2);
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-dark);
        transition: var(--transition);
    }
    
    .btn-edit-activity:hover {
        background: var(--color-primary);
        color: white;
    }
    
   
    @media (max-width: 992px) {
        .class-content {
            grid-template-columns: 1fr;
        }
        
        .teacher-actions {
            flex-wrap: wrap;
            justify-content: flex-end;
        }
    }
    .student-item {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
        padding: 8px;
        border-radius: 8px;
        transition: background-color 0.2s;
    }

    .student-item:hover {
        background-color: #f5f5f5;
    }

    .student-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #e0e0e0;
        position: relative;
        margin-right: 12px;
        flex-shrink: 0;
    }

    .student-initials {
        display: none;
        z-index: 1;
        font-size: 18px;
        font-weight: bold;
    }

    .student-avatar.no-image .student-initials {
        display: block;
    }

    .student-profile-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0;
        left: 0;
    }

    .student-name {
        font-size: 16px;
        color: var(--color-text);
    }
    @media (max-width: 768px) {
        .class-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1.5rem;
        }
        
        .teacher-actions {
            width: 100%;
            justify-content: center;
        }
        
        .activity-meta {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .activity-top-right {
            flex-direction: column;
            align-items: flex-end;
            gap: 0.5rem;
        }
    }
</style>

<?php

$isClassTeacher = (isset($_SESSION['user']['id']) && isset($class['teacher_id']) && 
                  $_SESSION['user']['id'] === $class['teacher_id']);


$activities = $activities ?? [];
?>

<div class="class-view-section">
    <div class="class-view-container">
        <div class="class-header">
            <div class="class-title-container">
                <div class="class-icon">
                    <i class="bi bi-journal-bookmark"></i>
                </div>
                <h1 class="class-title"><?= htmlspecialchars($class['class_name'] ?? 'Clase no disponible', ENT_QUOTES, 'UTF-8') ?></h1>
                
                <?php if ($isClassTeacher): ?>
                    <a href="index.php?action=edit_class&id=<?= urlencode($class['id'] ?? '') ?>" 
                       class="btn-teacher-action btn-edit-class">
                        <i class="bi bi-pencil"></i> Editar Clase
                    </a>
                <?php endif; ?>
            </div>
            
            <?php if ($isClassTeacher): ?>
                <div class="teacher-actions">
                    <a href="index.php?action=create_activity&class_id=<?= urlencode($class['id'] ?? '') ?>" 
                       class="btn-teacher-action btn-new-activity">
                        <i class="bi bi-plus-lg"></i> Nueva Actividad
                    </a>
                    <a href="index.php?action=manage_enrollments&class_id=<?= urlencode($class['id'] ?? '') ?>" 
                       class="btn-teacher-action btn-manage-students">
                        <i class="bi bi-people-fill"></i> Gestionar Alumnos
                    </a>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="class-content">
            <!-- Sección principal de actividades -->
            <div class="activities-section">
                <h2 class="section-title">
                    <i class="bi bi-list-task"></i> Actividades
                </h2>
                
                <?php if (!empty($activities)): ?>
<div class="activities-list">
    <?php foreach ($activities as $activity): 
        
        $daysText = $activity['days_text'] ?? 'Sin fecha límite';
        $submissionCount = $activity['submission_count'] ?? 0;
        $deadlineDisplay = $activity['deadline_display'] ?? null;
        
        
        $now = time();
        $deadlineTimestamp = $activity['deadline_ts'] ?? null;
        $isClosed = ($deadlineTimestamp && $now > $deadlineTimestamp);
        
        if ($isClassTeacher) {
            
            $statusClass = $isClosed ? 'status-cerrada' : 'status-abierta';
            $iconClass = $isClosed ? 'icon-cerrada' : 'icon-abierta';
            $badgeClass = $isClosed ? 'badge-cerrada' : 'badge-abierta';

            $statusIcon = $isClosed ? 'bi-lock' : 'bi-unlock';
            $statusText = $isClosed ? 'Cerrada' : 'Abierta';
        } else {
            
            if (($activity['entregada'] ?? false) === true) {
                $userStatus = 'entregada';
            } elseif ($isClosed) {
                $userStatus = 'vencida';
            } else {
                $userStatus = 'pendiente';
            }

            $statusClass = 'status-' . $userStatus;
            $iconClass = 'icon-' . $userStatus;
            $badgeClass = 'badge-' . $userStatus;

            switch ($userStatus) {
                case 'entregada':
                    $statusIcon = 'bi-check-circle';
                    $statusText = 'Entregada';
                    break;
                case 'vencida':
                    $statusIcon = 'bi-exclamation-triangle';
                    $statusText = 'Vencida';
                    break;
                default:
                    $statusIcon = 'bi-clock';
                    $statusText = 'Pendiente';
            }
        }
    ?>
        <a href="index.php?action=view_activity&id=<?= urlencode($activity['id'] ?? '') ?>" 
           class="activity-item" role="listitem">
            <div class="activity-content-container">
                <div class="activity-icon <?= $iconClass ?>">
                    <i class="bi bi-card-checklist"></i>
                </div>
                
                <div class="activity-content">
                    <div class="activity-header">
                        <h3 class="activity-title"><?= htmlspecialchars($activity['title'] ?? 'Sin título', ENT_QUOTES, 'UTF-8') ?></h3>
                        
                        <div class="activity-top-right">
                            <?php if ($isClassTeacher): ?>
                                <!-- Puedes agregar controles para profesor aquí si quieres -->
                            <?php endif; ?>
                            
                            <div class="activity-status <?= $statusClass ?>">
                                <i class="bi <?= $statusIcon ?> me-1"></i> <?= $statusText ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="activity-meta">
                        <div class="activity-deadline">
                            <i class="bi bi-calendar"></i>
                            <span>Entrega: </span>
                            <div class="badge <?= $badgeClass ?>">
                                <?php if (!empty($deadlineDisplay)): ?>
                                    <?= $deadlineDisplay ?>
                                    <?php if ($daysText && $daysText != 'Entregada'): ?>
                                        <span class="ms-2">(<?= $daysText ?>)</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?= $daysText ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <?php if ($isClassTeacher): ?>
                            <div class="activity-submissions">
                                <i class="bi bi-send-check"></i>
                                <div class="badge">
                                    <?= (int)$submissionCount ?> Envío<?= $submissionCount != 1 ? 's' : '' ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
</div>

                <?php else: ?>
                    <div class="empty-activities">
                        <div class="empty-icon">
                            <i class="bi bi-journal-x"></i>
                        </div>
                        <p class="empty-text">No hay actividades creadas en esta clase</p>
                        <?php if ($isClassTeacher): ?>
                            <a href="index.php?action=create_activity&class_id=<?= urlencode($class['id'] ?? '') ?>" 
                               class="btn-teacher-action btn-new-activity mt-3">
                                <i class="bi bi-plus-lg"></i> Crear primera actividad
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Sección lateral de información -->
            <div class="class-info-section">
                <div class="class-info-card">
                    <div class="class-info-header">
                        <h3 class="class-info-title">
                            <i class="bi bi-info-circle"></i> Información de la Clase
                        </h3>
                    </div>
                    <div class="class-info-body">
                        <p class="class-description">
                            <?= !empty($class['description'] ?? '') 
                                ? htmlspecialchars($class['description'], ENT_QUOTES, 'UTF-8') 
                                : 'No hay descripción disponible para esta clase.' ?>
                        </p>
                        
                        <!-- Mostrar código de clase solo para el profesor -->
                        <?php if ($isClassTeacher): ?>
                            <div class="class-code-container" id="classCodeContainer">
                                <span class="class-code-label">Código de la clase:</span>
                                <div class="class-code-value" id="classCodeValue">
                                    <?= htmlspecialchars($class['class_code'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?>
                                </div>
                                <span class="copy-indicator" id="copyIndicator">¡Copiado!</span>
                            </div>
                        <?php endif; ?>
                        
                        <div class="students-section">
                            <h4 class="section-title">
                                <i class="bi bi-people"></i> Alumnos Inscritos
                                <span class="badge bg-primary rounded-pill ms-2"><?= count($enrolledStudents ?? []) ?></span>
                            </h4>
                            
                            <div class="students-list">
                                <?php if (!empty($enrolledStudents)): ?>
                                    <?php foreach ($enrolledStudents as $student): 
                                        $studentId = $student['id'] ?? '';
                                        $studentName = $student['full_name'] ?? 'Nombre no disponible';
                                        $fotoEstudiante = function_exists('obtenerFotoPerfil') 
                                            ? obtenerFotoPerfil($studentId, $pdo, false) 
                                            : '';
                                    ?>
                                        <div class="student-item">
                                            <div class="student-avatar <?= empty($fotoEstudiante) ? 'no-image' : '' ?>">
                                                <?php if (!empty($fotoEstudiante)): ?>
                                                    <img src="<?= htmlspecialchars($fotoEstudiante) ?>" 
                                                         alt="Foto de <?= htmlspecialchars($studentName) ?>" 
                                                         class="student-profile-img"
                                                         onerror="this.onerror=null; this.parentElement.classList.add('no-image'); this.style.display='none';">
                                                <?php else: ?>
                                                    <span class="student-initials">
                                                        <?= strtoupper(substr($studentName, 0, 1)) ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="student-name">
                                                <?= htmlspecialchars($studentName, ENT_QUOTES, 'UTF-8') ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>No hay alumnos inscritos en esta clase</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include PARTIALS_DIR . '/footer.php'; ?>

<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        
        const activityItems = document.querySelectorAll('.activity-item');
        activityItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateX(20px)';
            
            setTimeout(() => {
                item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                item.style.opacity = '1';
                item.style.transform = 'translateX(0)';
            }, 300 + (index * 100));
        });
        
        
        const classCodeContainer = document.getElementById('classCodeContainer');
        const classCodeValue = document.getElementById('classCodeValue');
        const copyIndicator = document.getElementById('copyIndicator');
        
        if (classCodeContainer) {
            classCodeContainer.addEventListener('click', function() {
                const textToCopy = classCodeValue.textContent;
                
                
                navigator.clipboard.writeText(textToCopy)
                    .then(() => {
                        copyIndicator.style.opacity = '1';
                        setTimeout(() => {
                            copyIndicator.style.opacity = '0';
                        }, 2000);
                    })
                    .catch(err => {
                        console.error('Error al copiar: ', err);
                        
                        const textArea = document.createElement('textarea');
                        textArea.value = textToCopy;
                        document.body.appendChild(textArea);
                        textArea.select();
                        document.execCommand('copy');
                        document.body.removeChild(textArea);
                        
                        copyIndicator.style.opacity = '1';
                        setTimeout(() => {
                            copyIndicator.style.opacity = '0';
                        }, 2000);
                    });
            });
        }
    });
</script>