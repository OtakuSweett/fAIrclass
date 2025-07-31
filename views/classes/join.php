<?php include PARTIALS_DIR . '/header.php'; ?>
<?php include PARTIALS_DIR . '/flash.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Unirse a Clase</h2>
                    
                    <form action="index.php?action=join_class" method="POST">
                        <div class="mb-3">
                            <label for="class_code" class="form-label">Código de la Clase</label>
                            <input type="text" class="form-control" id="class_code" name="class_code" 
                                   placeholder="Ej: ABC123" required>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Unirse</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include PARTIALS_DIR . '/footer.php'; ?>