<?php include PARTIALS_DIR . '/header.php'; ?>
<?php include PARTIALS_DIR . '/flash.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="card-title mb-4">Entregar Trabajo: <?= htmlspecialchars($activity['title']) ?></h2>
                    
                    <!-- Corregido: usar $activity['id'] en lugar de $activityId -->
                    <form action="index.php?action=submit_activity&id=<?= $activity['id'] ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="content" class="form-label">Contenido (opcional)</label>
                            <textarea class="form-control" id="content" name="content" rows="8" 
                                      placeholder="Escribe tu trabajo aquí..."><?= $content ?? '' ?></textarea>
                            <div class="form-text">Puedes escribir tu respuesta o subir archivos/enlaces</div>
                        </div>
                        
                        <!-- Sección de recursos con pestañas -->
                        <div class="mb-4">
                            <label class="form-label">Agregar recursos:</label>
                            
                            <!-- Pestañas para seleccionar tipo -->
                            <ul class="nav nav-tabs mb-2" id="resourceTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="files-tab" data-bs-toggle="tab" data-bs-target="#files" type="button" role="tab">
                                        <i class="bi bi-file-earmark"></i> Archivos
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="links-tab" data-bs-toggle="tab" data-bs-target="#links" type="button" role="tab">
                                        <i class="bi bi-link-45deg"></i> Enlaces
                                    </button>
                                </li>
                            </ul>
                            
                            <!-- Contenido de pestañas -->
                            <div class="tab-content" id="resourceTabsContent">
                                <!-- Pestaña de archivos -->
                                <div class="tab-pane fade show active" id="files" role="tabpanel">
                                    <div class="drop-zone mb-3 p-4 border rounded text-center bg-light" id="dropZone">
                                        <p class="text-muted">Arrastra y suelta archivos aquí o haz clic para seleccionar</p>
                                        <input type="file" class="d-none" id="fileInput" name="submission_files[]" multiple>
                                        <button type="button" class="btn btn-outline-primary" id="browseBtn">
                                            <i class="bi bi-folder2-open"></i> Seleccionar archivos
                                        </button>
                                        <div class="mt-3" id="filePreview"></div>
                                    </div>
                                    <div class="form-text">Formatos permitidos: PDF, Word, Excel, imágenes, texto</div>
                                </div>
                                
                                <!-- Pestaña de enlaces -->
                                <div class="tab-pane fade" id="links" role="tabpanel">
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <input type="url" class="form-control" placeholder="https://ejemplo.com" id="linkInput">
                                            <button type="button" class="btn btn-primary" id="addLinkBtn">
                                                <i class="bi bi-plus"></i> Agregar
                                            </button>
                                        </div>
                                        <div class="mt-3" id="linksPreview"></div>
                                        <input type="hidden" name="links[]" id="linksHidden">
                                    </div>
                                    <div class="form-text">Ej: enlace a Google Docs, GitHub, Figma, etc.</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i> 
                            Recuerda que todos los recursos serán analizados para detectar similitudes con otros trabajos.
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-send-check"></i> Enviar Trabajo
                            </button>
                            <!-- Corregido: usar $activity['id'] -->
                            <a href="index.php?action=view_activity&id=<?= $activity['id'] ?>" 
                               class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const browseBtn = document.getElementById('browseBtn');
    const filePreview = document.getElementById('filePreview');
    const linkInput = document.getElementById('linkInput');
    const addLinkBtn = document.getElementById('addLinkBtn');
    const linksPreview = document.getElementById('linksPreview');
    const linksHidden = document.getElementById('linksHidden');
    const links = [];
    
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight() {
        dropZone.classList.add('border-primary', 'bg-white');
    }
    
    function unhighlight() {
        dropZone.classList.remove('border-primary', 'bg-white');
    }
    
    
    dropZone.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }
    
    
    browseBtn.addEventListener('click', () => fileInput.click());
    fileInput.addEventListener('change', () => handleFiles(fileInput.files));
    
    function handleFiles(files) {
        [...files].forEach(file => {
            if (!file) return;
            
            const fileElement = document.createElement('div');
            fileElement.className = 'd-flex justify-content-between align-items-center mb-2 p-2 border rounded bg-light';
            fileElement.innerHTML = `
                <div>
                    <i class="bi bi-file-earmark me-2"></i>
                    ${file.name} (${formatFileSize(file.size)})
                </div>
                <button type="button" class="btn btn-sm btn-danger remove-file">
                    <i class="bi bi-trash"></i>
                </button>
            `;
            
            filePreview.appendChild(fileElement);
            
            
            fileElement.querySelector('.remove-file').addEventListener('click', () => {
                fileElement.remove();
            });
        });
    }
    
    
    addLinkBtn.addEventListener('click', () => {
        const url = linkInput.value.trim();
        if (url && isValidUrl(url)) {
            links.push(url);
            updateLinksPreview();
            linkInput.value = '';
        } else {
            alert('Por favor ingrese una URL válida');
        }
    });
    
    function isValidUrl(url) {
        try {
            new URL(url);
            return true;
        } catch (e) {
            return false;
        }
    }
    
    function updateLinksPreview() {
        linksPreview.innerHTML = '';
        linksHidden.value = JSON.stringify(links);
        
        links.forEach((link, index) => {
            const linkElement = document.createElement('div');
            linkElement.className = 'd-flex justify-content-between align-items-center mb-2 p-2 border rounded bg-light';
            linkElement.innerHTML = `
                <div>
                    <i class="bi bi-link-45deg me-2"></i>
                    <a href="${link}" target="_blank">${link}</a>
                </div>
                <button type="button" class="btn btn-sm btn-danger remove-link" data-index="${index}">
                    <i class="bi bi-trash"></i>
                </button>
            `;
            
            linksPreview.appendChild(linkElement);
            
            
            linkElement.querySelector('.remove-link').addEventListener('click', (e) => {
                const index = parseInt(e.target.closest('button').dataset.index);
                links.splice(index, 1);
                updateLinksPreview();
            });
        });
    }
    
    
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
});
</script>

<style>
.drop-zone {
    transition: all 0.3s ease;
    cursor: pointer;
}
.drop-zone:hover {
    background-color: rgba(13, 110, 253, 0.05) !important;
}
.highlight {
    border: 2px dashed #0d6efd !important;
    background-color: rgba(13, 110, 253, 0.1) !important;
}
.remove-file, .remove-link {
    transition: all 0.2s;
}
.remove-file:hover, .remove-link:hover {
    transform: scale(1.1);
}
</style>

<?php include PARTIALS_DIR . '/footer.php'; ?>