<?php include PARTIALS_DIR . '/header.php'; ?>
<?php include PARTIALS_DIR . '/flash.php'; ?>

<style>
   
    .manage-enrollments-section {
        padding: 2rem 0;
        min-height: calc(100vh - 80px);
        background: linear-gradient(135deg, rgba(168, 208, 230, 0.05), rgba(248, 183, 216, 0.05));
    }
    
    .manage-enrollments-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }
    
    .manage-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--color-primary);
        position: relative;
    }
    
    .manage-header::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 80px;
        height: 2px;
        background: var(--color-secondary);
    }
    
    .manage-title {
        font-weight: 700;
        font-size: 2rem;
        color: var(--color-dark);
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .manage-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.8rem;
    }
    
    .manage-actions {
        display: flex;
        gap: 1rem;
    }
    
    .btn-manage-action {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        padding: 0.8rem 1.5rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
    }
    
    .btn-back-class {
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        color: white;
        border: none;
    }
    
    .btn-manage-action:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    
    .manage-content {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
   
    .add-student-section {
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
    
    .add-student-card {
        background-color: var(--color-light);
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
    }
    
    .add-student-header {
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        padding: 1.5rem;
        color: white;
    }
    
    .add-student-title {
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
    }
    
    .add-student-body {
        padding: 1.5rem;
    }
    
    .add-form {
        display: flex;
        gap: 1rem;
        align-items: center;
    }
    
    .form-control {
        flex: 1;
        padding: 0.9rem 1.5rem;
        border: 1px solid #e0e0e0;
        border-radius: var(--border-radius);
        background-color: rgba(255,255,255,0.7);
        transition: var(--transition);
        font-size: 1rem;
        color: var(--color-text);
    }
    
    .form-control:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(168, 208, 230, 0.3);
        outline: none;
    }
    
    .btn-add-student {
        background: linear-gradient(135deg, var(--color-success), #2a9d8f);
        color: white;
        border: none;
        padding: 0.9rem 1.8rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.7rem;
    }
    
    .btn-add-student:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    
   
    .students-list-section {
        margin-bottom: 3rem;
    }
    
    .students-list-card {
        background-color: var(--color-light);
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
    }
    
    .students-list-header {
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        padding: 1.5rem;
        color: white;
    }
    
    .students-list-title {
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
    }
    
    .students-list-body {
        padding: 1.5rem;
    }
    
    .student-list {
        max-height: 500px;
        overflow-y: auto;
    }
    
    .student-row {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        transition: var(--transition);
    }
    
    .student-row:hover {
        background-color: rgba(168, 208, 230, 0.1);
    }
    
    .student-info {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    
    .student-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
    }
    
    .student-details {
        flex: 1;
    }
    
    .student-name {
        font-weight: 600;
        color: var(--color-dark);
        margin-bottom: 0.2rem;
    }
    
    .student-email {
        color: var(--color-text);
        font-size: 0.9rem;
    }
    
    .student-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-remove-student {
        background-color: rgba(220, 53, 69, 0.15);
        color: #dc3545;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius);
        font-weight: 500;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-remove-student:hover {
        background-color: rgba(220, 53, 69, 0.25);
        transform: translateY(-2px);
    }
    
    .empty-students {
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
    
   
    @media (max-width: 992px) {
        .manage-content {
            grid-template-columns: 1fr;
        }
        
        .manage-actions {
            flex-wrap: wrap;
            justify-content: flex-end;
        }
    }
    
    @media (max-width: 768px) {
        .manage-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1.5rem;
        }
        
        .manage-actions {
            width: 100%;
            justify-content: center;
        }
        
        .add-form {
            flex-direction: column;
            gap: 1rem;
        }
        
        .form-control {
            width: 100%;
        }
        
        .btn-add-student {
            width: 100%;
            justify-content: center;
        }
        
        .student-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .student-info {
            width: 100%;
        }
        
        .student-actions {
            width: 100%;
            justify-content: flex-end;
        }
    }
</style>

<div class="manage-enrollments-section">
    <div class="manage-enrollments-container">
        <div class="manage-header">
            <div class="d-flex align-items-center">
                <div class="manage-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <h1 class="manage-title">Gestión de Alumnos - <?= htmlspecialchars($class['class_name'], ENT_QUOTES, 'UTF-8') ?></h1>
            </div>
            
            <div class="manage-actions">
                <a href="index.php?action=view_class&id=<?= urlencode($class['id']) ?>" 
                   class="btn-manage-action btn-back-class">
                    <i class="bi bi-arrow-left me-1"></i> Volver a la Clase
                </a>
            </div>
        </div>
        
        <div class="manage-content">
            <!-- Sección para agregar alumnos -->
            <div class="add-student-section">
                <h2 class="section-title">
                    <i class="bi bi-person-plus"></i> Agregar Alumno
                </h2>
                
                <div class="add-student-card">
                    <div class="add-student-header">
                        <h3 class="add-student-title">
                            <i class="bi bi-envelope"></i> Agregar por Correo Electrónico
                        </h3>
                    </div>
                    <div class="add-student-body">
                        <form method="POST" action="index.php?action=manage_enrollments&class_id=<?= urlencode($class['id']) ?>" class="add-form">
                            <input type="email" name="student_email" class="form-control" placeholder="Correo electrónico del alumno" required>
                            <button type="submit" name="action_add_email" class="btn-add-student">
                                <i class="bi bi-person-plus"></i> Agregar Alumno
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Sección de lista de alumnos -->
            <div class="students-list-section">
                <h2 class="section-title">
                    <i class="bi bi-people"></i> Alumnos Inscritos
                </h2>
                
                <div class="students-list-card">
                    <div class="students-list-header">
                        <h3 class="students-list-title">
                            <i class="bi bi-list"></i> Lista de Alumnos
                            <span class="badge bg-light text-dark rounded-pill ms-2"><?= count($enrolledStudents) ?></span>
                        </h3>
                    </div>
                    <div class="students-list-body">
                        <?php if (!empty($enrolledStudents)): ?>
                            <div class="student-list">
                                <?php foreach ($enrolledStudents as $student): ?>
                                    <div class="student-row">
                                        <div class="student-info">
                                            <div class="student-avatar">
                                                <?= strtoupper(substr($student['full_name'], 0, 1)) ?>
                                            </div>
                                            <div class="student-details">
                                                <div class="student-name"><?= htmlspecialchars($student['full_name'], ENT_QUOTES, 'UTF-8') ?></div>
                                                <div class="student-email"><?= htmlspecialchars($student['email'], ENT_QUOTES, 'UTF-8') ?></div>
                                            </div>
                                        </div>
                                        <div class="student-actions">
                                            <form method="POST" action="index.php?action=manage_enrollments&class_id=<?= urlencode($class['id']) ?>">
                                                <input type="hidden" name="student_id" value="<?= htmlspecialchars($student['id']) ?>">
                                                <button type="submit" name="action_remove" class="btn-remove-student">
                                                    <i class="bi bi-trash"></i> Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="empty-students">
                                <div class="empty-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                                <p class="empty-text">No hay alumnos inscritos en esta clase</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include PARTIALS_DIR . '/footer.php'; ?>

<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        
        const cards = document.querySelectorAll('.add-student-card, .students-list-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 300 + (index * 100));
        });
        
        
        const studentRows = document.querySelectorAll('.student-row');
        studentRows.forEach((row, index) => {
            row.style.opacity = '0';
            row.style.transform = 'translateX(20px)';
            
            setTimeout(() => {
                row.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                row.style.opacity = '1';
                row.style.transform = 'translateX(0)';
            }, 500 + (index * 50));
        });
        
        
        const buttons = document.querySelectorAll('.btn-manage-action, .btn-add-student');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
        
        
        studentRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.05)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });
        });
    });
</script>