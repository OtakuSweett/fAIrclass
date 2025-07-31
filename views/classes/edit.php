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
    <h1 class="mb-4">Editar Clase: <?= htmlspecialchars($class['class_name'] ?? '') ?></h1>
    
    <form action="index.php?action=edit_class&id=<?= $classId ?>" method="POST">
        <div class="form-group">
            <label for="class_name" class="form-label">Nombre de la Clase</label>
            <input type="text" class="form-control" id="class_name" name="class_name" required
                   value="<?= htmlspecialchars($classData['class_name'] ?? '') ?>">
        </div>
        
        <div class="form-group">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="4"><?= 
                htmlspecialchars($classData['description'] ?? '') 
            ?></textarea>
        </div>
        
        
        <button type="submit" class="btn-submit">Guardar Cambios</button>
        <a href="index.php?action=view_class&id=<?= $classId ?>" class="btn btn-secondary">
            Cancelar
        </a>
    </form>
</div>

<?php include PARTIALS_DIR . '/footer.php'; ?>