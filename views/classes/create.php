<?php include PARTIALS_DIR . '/header.php'; ?>
<?php include PARTIALS_DIR . '/flash.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="card-title mb-4">Crear Nueva Clase</h2>
                    
                    <form action="index.php?action=create_class" method="POST">
                        <div class="mb-3">
                            <label for="class_name" class="form-label">Nombre de la Clase</label>
                            <input type="text" class="form-control" id="class_name" name="class_name" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Crear Clase</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include PARTIALS_DIR . '/footer.php'; ?>