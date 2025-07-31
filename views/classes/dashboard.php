<?php include PARTIALS_DIR . '/header.php'; ?>
<?php include PARTIALS_DIR . '/flash.php'; ?>

<style>
   
    :root {
        --color-primary: #a8d0e6; 
        --color-secondary: #f8b7d8;
        --color-accent: #ff6b6b;   
        --color-light: #ffffff;    
        --color-dark: #32325d;     
        --color-text: #525f7f;     
        --color-bg: #f9f7fe;       
        --border-radius: 15px;
        --box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        --transition: all 0.3s ease;
    }

    [data-theme="dark"] {
        --color-light: #1e2a3a;
        --color-bg: #121826;
        --color-text: #e0e0e0;
        --color-dark: #e0e0e0;
        --color-primary: #2a4365;
        --color-secondary: #553c9a;
    }

    body {
        background-color: var(--color-bg);
        color: var(--color-text);
        transition: background-color 0.3s ease, color 0.3s ease;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
    }
    
    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px;
        flex: 1;
    }
    
   
    .btn-grad {
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        border: none;
        color: var(--color-light);
        border-radius: 50px;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        transition: var(--transition);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-grad:hover {
        transform: translateY(-3px);
        box-shadow: 0 7px 14px rgba(0,0,0,0.1);
    }
    
   
    .card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--box-shadow);
        margin-bottom: 1.5rem;
        transition: var(--transition);
        background-color: var(--color-light);
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
   
    .page-title {
        font-weight: 700;
        color: var(--color-dark);
        position: relative;
        padding-bottom: 10px;
        margin-bottom: 1.5rem;
        font-size: 2.2rem;
    }
    
    .page-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 4px;
        background: linear-gradient(90deg, var(--color-secondary), var(--color-primary));
        border-radius: 2px;
    }
    
    .section-title {
        font-weight: 700;
        font-size: 1.6rem;
        color: var(--color-dark);
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }
    
   
    .theme-switch-wrapper {
        position: absolute;
        top: 20px;
        right: 20px;
        display: flex;
        align-items: center;
        z-index: 1000;
    }
    
    .theme-switch {
        display: inline-block;
        height: 28px;
        position: relative;
        width: 50px;
    }
    
    .theme-switch input {
        display: none;
    }
    
    .slider {
        background-color: #ccc;
        bottom: 0;
        cursor: pointer;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        transition: .4s;
        border-radius: 34px;
    }
    
    .slider:before {
        background-color: white;
        bottom: 4px;
        content: "";
        height: 20px;
        left: 4px;
        position: absolute;
        transition: .4s;
        width: 20px;
        border-radius: 50%;
    }
    
    input:checked + .slider {
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
    }
    
    input:checked + .slider:before {
        transform: translateX(22px);
    }
    
   
    @media (max-width: 768px) {
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 1rem;
        }
        
        .theme-switch-wrapper {
            position: relative;
            top: 0;
            right: 0;
            margin-bottom: 1rem;
            justify-content: flex-end;
        }
        
        .classes-grid {
            grid-template-columns: 1fr;
        }
    }
    
   
    .dashboard-section {
        padding: 2rem 0;
        min-height: calc(100vh - 80px);
        background: linear-gradient(135deg, rgba(168, 208, 230, 0.05), rgba(248, 183, 216, 0.05));
    }
    
    .welcome-header {
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        border-radius: var(--border-radius);
        padding: 2.5rem;
        margin-bottom: 2.5rem;
        color: var(--color-light);
        box-shadow: var(--box-shadow);
        position: relative;
        overflow: hidden;
    }
    
    .welcome-header::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    
    .welcome-header::after {
        content: '';
        position: absolute;
        bottom: -80px;
        left: -80px;
        width: 250px;
        height: 250px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    
    .welcome-title {
        font-weight: 700;
        font-size: 2.2rem;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
    }
    
    .welcome-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        max-width: 700px;
        position: relative;
        z-index: 2;
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 0.8rem;
        border-bottom: 2px solid var(--color-primary);
        position: relative;
    }
    
    .section-header::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 80px;
        height: 2px;
        background: var(--color-secondary);
    }
    
    .view-all {
        color: var(--color-secondary);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .view-all:hover {
        color: var(--color-accent);
        transform: translateX(5px);
    }
    
   
    
    .classes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.8rem;
        margin-bottom: 3rem;
    }
    
    .class-card {
        background-color: var(--color-light);
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--box-shadow);
        transition: var(--transition);
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .class-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.12);
    }
    
    .class-card-header {
        padding: 1.5rem;
        background: linear-gradient(135deg, var(--color-primary), #825ee4);
        color: var(--color-light);
        position: relative;
    }
    
    .class-card-title {
        font-weight: 700;
        font-size: 1.4rem;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
    }
    
    .class-card-instructor {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        position: relative;
        z-index: 2;
    }
    
.instructor-avatar img.profile-img {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    object-fit: cover;
    object-position: center;
    image-rendering: -webkit-optimize-contrast;
    display: block;
    background: rgba(255, 255, 255, 0.2);
    font-size: 0.9rem;
}

    
    .class-card-body {
        padding: 1.5rem;
        flex: 1;
    }
    
    .class-card-description {
        color: var(--color-text);
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }
    
    .class-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 1.5rem 1.5rem;
    }
    
    .activity-count {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--color-text);
        font-size: 0.9rem;
    }
    
    .btn-view-class {
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        color: var(--color-light);
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }
    
    .btn-view-class:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
   
    .view-more-card {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        background: linear-gradient(135deg, rgba(168, 208, 230, 0.1), rgba(248, 183, 216, 0.1));
        border: 2px dashed var(--color-primary);
        cursor: pointer;
        transition: var(--transition);
    }
    
    .view-more-card:hover {
        background: linear-gradient(135deg, rgba(168, 208, 230, 0.2), rgba(248, 183, 216, 0.2));
        transform: translateY(-8px);
    }
    
    .view-more-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: var(--color-primary);
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
    }
    
    .activity-item:hover {
        background-color: rgba(168, 208, 230, 0.05);
    }
    
    .activity-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: rgba(168, 208, 230, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--color-primary);
        flex-shrink: 0;
        margin-right: 1.5rem;
    }
    
    .activity-content {
        flex: 1;
    }
    
    .activity-title {
        font-weight: 600;
        margin-bottom: 0.3rem;
        color: var(--color-dark);
    }
    
    .activity-meta {
        display: flex;
        gap: 1.5rem;
        color: var(--color-text);
        font-size: 0.9rem;
    }
    
    .activity-class {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .activity-deadline {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .activity-deadline .badge {
        background: rgba(247, 108, 108, 0.15);
        color: var(--color-accent);
        padding: 0.3rem 0.8rem;
        border-radius: 50px;
        font-weight: 500;
    }
    
   
    .empty-state {
        text-align: center;
        padding: 3rem;
        background: rgba(168, 208, 230, 0.05);
        border-radius: var(--border-radius);
        margin: 2rem 0;
    }
    
    .empty-icon {
        font-size: 4rem;
        color: var(--color-primary);
        opacity: 0.3;
        margin-bottom: 1.5rem;
    }
    
    .empty-text {
        font-size: 1.2rem;
        color: var(--color-text);
        max-width: 500px;
        margin: 0 auto;
    }
    
    .empty-action-btn {
        margin-top: 1.5rem;
        padding: 1rem 2rem;
        font-size: 1.1rem;
    }
</style>


<div class="dashboard-section">
    <div class="container">
        <!-- Cambio 1: Mostrar ambos botones siempre -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">Dashboard</h2>
            <div>
                <a href="index.php?action=create_class" class="btn btn-grad me-2">
                    <i class="bi bi-plus-lg me-1"></i> Nueva Clase
                </a>
                <a href="index.php?action=join_class" class="btn btn-grad">
                    <i class="bi bi-door-open me-1"></i> Unirse a Clase
                </a>
            </div>
        </div>
        
        <div class="welcome-header">
            <h1 class="welcome-title">Bienvenido, <?= htmlspecialchars($_SESSION['user']['full_name'] ?? 'Usuario') ?></h1>
            <p class="welcome-subtitle">Aquí puedes ver tus clases y actividades recientes</p>
        </div>
        
        <!-- Sección de Mis Clases -->
        <div class="section-header">
            <h2 class="section-title">
                <i class="bi bi-journals"></i> Mis Clases
            </h2>
        </div>
        
        <?php
        
        $classesToShow = [];
        
        
        if (isset($user_classes)) {
            $classesToShow = $user_classes;
        } 
        
        elseif (isset($classes)) {
            $classesToShow = $classes;
        }
        
        elseif (isset($data['user_classes'])) {
            $classesToShow = $data['user_classes'];
        }
        
        elseif (isset($data['classes'])) {
            $classesToShow = $data['classes'];
        }
        
        
        $hasClasses = !empty($classesToShow) && is_array($classesToShow);
        ?>
<?php
require_once __DIR__ . '/../../helpers/UserHelper.php';
global $pdo;
?>

<?php if ($hasClasses): ?>
    <div class="classes-grid">
        <?php 
        $displayedClasses = array_slice($classesToShow, 0);
        $totalClasses = count($classesToShow);
        
        foreach ($displayedClasses as $class): 
            $classId = $class['id'] ?? $class['class_id'] ?? null;
            $className = $class['class_name'] ?? $class['name'] ?? 'Sin nombre';
            $instructorName = $class['teacher_name'] ?? $class['instructor_name'] ?? 'Instructor';
            
            $instructorId = $class['teacher_id'] ?? $class['instructor_id'] ?? null;
            $description = $class['description'] ?? 'Descripción no disponible';
            $activityCount = $class['activity_count'] ?? $class['activities'] ?? 0;
        ?>
            <div class="class-card">
                <div class="class-card-header">
                    <h3 class="class-card-title"><?= htmlspecialchars($className) ?></h3>
                    <div class="class-card-instructor">
                        <?php 
                        $fotoInstructor = null;
                        if (!empty($instructorId)) {
                            $fotoInstructor = obtenerFotoPerfil($instructorId, $pdo, false);
                        }
                        
                        $claseAvatar = empty($fotoInstructor) ? 'profile-avatar no-image' : 'profile-avatar';
                        $iniciales = !empty($instructorName) ? strtoupper(substr($instructorName, 0, 1)) : '';
                        ?>
                        
                        <div class="instructor-avatar <?= $claseAvatar ?>">
                            <?php if (!empty($fotoInstructor)): ?>
                                <img src="<?= htmlspecialchars($fotoInstructor) ?>" 
                                     alt="Foto de <?= htmlspecialchars($instructorName) ?>" 
                                     class="profile-img"
                                     onerror="this.onerror=null; this.parentElement.classList.add('no-image'); this.style.display='none';">
                            <?php endif; ?>
                            
                            <?php if (empty($fotoInstructor)): ?>
                                <span class="avatar-initials"><?= $iniciales ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <span><?= htmlspecialchars($instructorName) ?></span>
                    </div>
                </div>
                
                <div class="class-card-body">
                    <p class="class-card-description">
                        <?= htmlspecialchars($description) ?>
                    </p>
                </div>
                
                <div class="class-card-footer">
                    <div class="activity-count">
                        <i class="bi bi-list-task"></i>
                        <span><?= $activityCount ?> actividades</span>
                    </div>
                    <?php if ($classId): ?>
                        <a href="index.php?action=view_class&id=<?= $classId ?>" class="btn-view-class">
                            <i class="bi bi-box-arrow-in-right"></i> Ver clase
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="empty-state">
        <div class="empty-icon">
            <i class="bi bi-journal-x"></i>
        </div>
        <p class="empty-text">
            <?php if ($_SESSION['user']['role'] === 'teacher'): ?>
                Aún no has creado ninguna clase. ¡Comienza ahora!
            <?php else: ?>
                No estás inscrito en ninguna clase todavía. ¡Explora nuestras clases y comienza a aprender!
            <?php endif; ?>
        </p>
        <div style="display: flex; gap: 1rem; justify-content: center;">
            <a href="index.php?action=create_class" class="btn btn-grad empty-action-btn">
                <i class="bi bi-plus-lg me-1"></i> Crear mi primera clase
            </a>
            <a href="index.php?action=join_class" class="btn btn-grad empty-action-btn">
                <i class="bi bi-door-open me-1"></i> Unirme a una clase
            </a>
        </div>
    </div>
<?php endif; ?>

        
        <!-- Sección de Actividades Recientes -->
        <div class="section-header">
            <h2 class="section-title">
                <i class="bi bi-list-task"></i> Actividades Recientes
            </h2>
            <a href="#" class="view-all">
                Ver todas <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        
        <?php if (!empty($activities)): ?>
            <div class="activities-list">
                <?php foreach ($activities as $activity): ?>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="bi bi-card-checklist"></i>
                        </div>
                        <div class="activity-content">
                            <h3 class="activity-title"><?= htmlspecialchars($activity['title'] ?? 'Sin título') ?></h3>
                            <div class="activity-meta">
                                <div class="activity-class">
                                    <i class="bi bi-journal"></i>
                                    <span><?= htmlspecialchars($activity['class_name'] ?? 'Sin clase') ?></span>
                                </div>
                                <div class="activity-deadline">
                                    <i class="bi bi-calendar"></i>
                                    <span>Entrega: </span>
                                    <div class="badge">
                                        <?= !empty($activity['deadline']) ? date('d/m/Y H:i', strtotime($activity['deadline'])) : 'Sin fecha' ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-check2-circle"></i>
                </div>
                <p class="empty-text">¡No tienes actividades pendientes! Buen trabajo.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include PARTIALS_DIR . '/footer.php'; ?>

<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        
        
        const classCards = document.querySelectorAll('.class-card');
        classCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 200 * index);
        });
        
        
        classCards.forEach(card => {
            if (card.querySelector('.btn-view-class')) {
                card.addEventListener('mouseenter', function() {
                    this.querySelector('.btn-view-class').style.transform = 'translateY(-3px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.querySelector('.btn-view-class').style.transform = 'translateY(0)';
                });
            }
        });
    });
</script>