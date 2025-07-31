<?php include PARTIALS_DIR . '/header.php'; ?>
<?php include PARTIALS_DIR . '/flash.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Reporte de Originalidad</h2>
        <a href="index.php?action=view_submission&id=<?= $submissionId ?>" class="btn btn-primary">
            Volver al Envío
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <h4 class="card-title mb-4">Resumen del Análisis</h4>
            
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="alert alert-primary">
                        <h5>Similitud Total</h5>
                        <p class="display-4 mb-0"><?= $report['total_similarity'] ?>%</p>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="alert alert-info">
                        <h5>Detalles</h5>
                        <p class="mb-1">Fuentes detectadas: <?= count($report['sources']) ?></p>
                        <p class="mb-0">Última actualización: <?= date('d/m/Y H:i') ?></p>
                    </div>
                </div>
            </div>

            <h4 class="mb-3">Coincidencias Detectadas</h4>
            <?php foreach ($report['detailed_matches'] as $match): ?>
                <div class="card mb-3">
                    <div class="card-header bg-<?= $match['similarity'] > 50 ? 'danger' : 'warning' ?> text-white">
                        <?= $match['source'] ?> (<?= $match['similarity'] ?>% de similitud)
                    </div>
                    <div class="card-body">
                        <?php foreach ($match['sections'] as $section): ?>
                            <div class="mb-2 p-2 bg-light">
                                <small class="text-muted">Posición <?= $section['position'] ?></small>
                                <p class="mb-0 font-monospace"><?= htmlspecialchars($section['content']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include PARTIALS_DIR . '/footer.php'; ?>