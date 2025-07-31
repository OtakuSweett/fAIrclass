<?php include PARTIALS_DIR . '/header.php'; ?>
<?php include PARTIALS_DIR . '/flash.php'; ?>

<style>
    .edit-class-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 2rem;
        background-color: var(--color-light);
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--color-dark);
    }

    .form-control {
        width: 100%;
        padding: 0.8rem 1rem;
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

    .btn-submit {
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        color: white;
        border: none;
        padding: 0.8rem 1.5rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        font-size: 1.1rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
</style>

<div class="edit-class-container">
    <h1 class="mb-4">Editar Actividad: <?= htmlspecialchars($activityData['title'] ?? '') ?></h1>

    <form action="index.php?action=edit_activity&id=<?= $activityId ?>" method="POST">
        <div class="form-group">
            <label for="title" class="form-label">Título</label>
            <input type="text" class="form-control" id="title" name="title" required
                   value="<?= htmlspecialchars($activityData['title'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="4"><?= 
                htmlspecialchars($activityData['description'] ?? '') 
            ?></textarea>
        </div>

        <div class="form-group">
            <label for="due_date" class="form-label">Fecha de entrega</label>
            <input type="datetime-local" class="form-control" id="due_date" name="due_date" required
                   <?= isset($activityData['due_date']) && strtotime($activityData['due_date']) > 0 
    ? 'value="' . date('Y-m-d\TH:i', strtotime($activityData['due_date'])) . '"' 
    : '' ?>

            >
        </div>

        <button type="submit" class="btn-submit">Guardar Cambios</button>
        <a href="index.php?action=view_class&id=<?= $activity['class_id'] ?>" class="btn btn-secondary">
            Cancelar
        </a>
    </form>
</div>

<?php include PARTIALS_DIR . '/footer.php'; ?>
