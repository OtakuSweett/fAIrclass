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
    
    .btn-back-activity {
        background: linear-gradient(135deg, #6c757d, #5a6268);
    }
    
    .btn-teacher-action:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    
    .activity-content {
        display: grid;
        grid-template-columns: 1fr;
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
    
   
    .table-container {
        overflow-x: auto;
        border-radius: var(--border-radius);
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05);
    }
    
    .submissions-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 800px;
    }
    
    .submissions-table thead {
        background: linear-gradient(135deg, #4e73df, #5a8cff);
        color: white;
    }
    
    .submissions-table th {
        padding: 1rem 1.25rem;
        text-align: left;
        font-weight: 600;
        border-bottom: 2px solid rgba(255,255,255,0.2);
    }
    
    .submissions-table th:first-child {
        border-top-left-radius: var(--border-radius);
    }
    
    .submissions-table th:last-child {
        border-top-right-radius: var(--border-radius);
    }
    
    .submissions-table tbody tr {
        transition: var(--transition);
    }
    
    .submissions-table tbody tr:nth-child(even) {
        background-color: rgba(168, 208, 230, 0.05);
    }
    
    .submissions-table tbody tr:hover {
        background-color: rgba(248, 183, 216, 0.08);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }
    
    .submissions-table td {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        color: var(--color-text);
    }
    
    .badge {
        display: inline-block;
        padding: 0.5em 0.75em;
        border-radius: 50rem;
        font-weight: 600;
    }
    
    .bg-danger {
        background: #e74a3b !important;
        color: white;
    }
    
    .bg-success {
        background: #1cc88a !important;
        color: white;
    }
    
    .btn-group {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-table {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
        font-size: 0.9rem;
    }
    
    .btn-view {
        background: rgba(78, 115, 223, 0.1);
        color: var(--color-primary);
    }
    
    .btn-view:hover {
        background: rgba(78, 115, 223, 0.2);
    }
    
    .btn-report {
        background: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }
    
    .btn-report:hover {
        background: rgba(255, 193, 7, 0.2);
    }
    
    .no-submissions {
        text-align: center;
        padding: 2rem;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    
    .no-submissions-icon {
        font-size: 3rem;
        color: #d1d3e2;
        margin-bottom: 1rem;
    }
    
    .no-submissions-title {
        font-weight: 600;
        color: var(--color-dark);
        margin-bottom: 0.5rem;
    }
    
    .no-submissions-text {
        color: var(--color-text);
        max-width: 500px;
        margin: 0 auto 1.5rem;
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
    }
</style>

<div class="activity-view-section">
    <div class="activity-view-container">
        <div class="activity-header">
            <div class="activity-title-container">
                <div class="activity-icon">
                    <i class="bi bi-card-checklist"></i>
                </div>
                <h1 class="activity-title">Envíos - <?= htmlspecialchars($activity['title'] ?? 'Actividad', ENT_QUOTES, 'UTF-8') ?></h1>
            </div>
            
            <div class="teacher-actions">
                <a href="index.php?action=view_activity&id=<?= urlencode($activity['id'] ?? '') ?>" 
                   class="btn-teacher-action btn-back-activity">
                    <i class="bi bi-arrow-left"></i> Volver a la Actividad
                </a>
            </div>
        </div>
        
        <div class="activity-content">
            <div class="activity-details-card">
                <div class="activity-details-header">
                    <h3 class="activity-details-title">
                        <i class="bi bi-list-check"></i> Lista de Entregas
                    </h3>
                </div>
                <div class="activity-details-body">
                    <?php if (empty($submissions)): ?>
                        <div class="no-submissions">
                            <div class="no-submissions-icon">
                                <i class="bi bi-inbox"></i>
                            </div>
                            <h4 class="no-submissions-title">No hay envíos para esta actividad</h4>
                            <p class="no-submissions-text">
                                Aún no se han realizado entregas para esta actividad. Los envíos aparecerán aquí 
                                cuando los estudiantes presenten sus trabajos.
                            </p>
                        </div>
                    <?php else: ?>
                        <div class="table-container">
                            <table class="submissions-table">
                                <thead>
                                    <tr>
                                        <th>Estudiante</th>
                                        <th>Fecha</th>
                                        <th>Plagio</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($submissions as $submission): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($submission['full_name'] ?? 'Nombre no disponible', ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($submission['submitted_at'])) ?></td>
                                            <td>
                                                <?php $score = $submission['similarity_score'] ?? 0; ?>
                                                <span class="badge bg-<?= $score > 50 ? 'danger' : 'success' ?>">
                                                    <?= $score ?>%
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="index.php?action=view_submission&id=<?= $submission['id'] ?>" 
                                                       class="btn-table btn-view">
                                                        <i class="bi bi-eye"></i> Ver
                                                    </a>
                                                    <a href="index.php?action=generate_report&id=<?= $submission['id'] ?>" 
                                                       class="btn-table btn-report">
                                                        <i class="bi bi-file-earmark-text"></i> Reporte
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include PARTIALS_DIR . '/footer.php'; ?>

<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        
        const tableRows = document.querySelectorAll('.submissions-table tbody tr');
        tableRows.forEach((row, index) => {
            row.style.opacity = '0';
            row.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                row.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                row.style.opacity = '1';
                row.style.transform = 'translateY(0)';
            }, 200 + (index * 100));
        });
        
        
        const emptyState = document.querySelector('.no-submissions');
        if (emptyState) {
            emptyState.style.opacity = '0';
            setTimeout(() => {
                emptyState.style.transition = 'opacity 0.8s ease';
                emptyState.style.opacity = '1';
            }, 500);
        }
    });
</script>