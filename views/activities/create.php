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
        --color-success: #4ade80;
        --color-warning: #fbbf24;
        --color-danger: #f87171;
        --color-info: #60a5fa;
        
        --color-primary-rgb: 168, 208, 230;
        --color-secondary-rgb: 248, 183, 216;
        --color-accent-rgb: 255, 107, 107;
        --color-dark-rgb: 50, 50, 93;
        --color-text-rgb: 82, 95, 127;
        
        --border-radius: 15px;
        --box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        --transition: all 0.3s ease;
        
        --font-main: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    [data-theme="dark"] {
        --color-light: #1e2a3a;
        --color-bg: #0d1117;
        --color-dark: #e0e0e0;
        --color-text: #d1d5db;
        --color-success: #16a34a;
        --color-warning: #ca8a04;
        --color-danger: #dc2626;
        --color-info: #2563eb;
        
        --color-primary: #4a9fe3;
        --color-secondary: #d86cb8;
        --color-accent: #ff8a8a;
        
        --color-primary-rgb: 74, 159, 227;
        --color-secondary-rgb: 216, 108, 184;
        --color-accent-rgb: 255, 138, 138;
        --color-dark-rgb: 224, 224, 224;
        --color-text-rgb: 209, 213, 219;
        
        --box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
    
   
   
   
    body {
        background-color: var(--color-bg);
        color: var(--color-text);
        font-family: var(--font-main);
        transition: background-color 0.3s ease, color 0.3s ease;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        padding-top: 80px;
        line-height: 1.6;
    }
    
   
   
   
    .btn-outline {
        background: transparent;
        color: var(--color-dark);
        border: 1px solid var(--color-dark);
        transition: var(--transition);
    }
    
    .btn-outline:hover {
        background: rgba(var(--color-dark-rgb), 0.1);
        color: var(--color-dark);
    }
    
    .btn-primary {
        background: var(--color-primary);
        border-color: var(--color-primary);
        color: var(--color-light);
        transition: var(--transition);
        font-weight: 600;
    }
    
    .btn-primary:hover {
        background: var(--color-secondary);
        border-color: var(--color-secondary);
        color: var(--color-light);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .btn-grad {
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        color: var(--color-light);
        border-radius: 50px;
        transition: var(--transition);
        border: none;
        font-weight: 600;
        text-shadow: 0 1px 1px rgba(0,0,0,0.2);
    }
    
    .btn-grad:hover {
        transform: translateY(-3px);
        box-shadow: 0 7px 14px rgba(0,0,0,0.15);
    }
    
    .card {
        background-color: var(--color-light);
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 1.5rem;
        transition: var(--transition);
        border: none;
        color: var(--color-text);
    }
    
    .card h1, .card h2, .card h3, .card h4, .card h5, .card h6 {
        color: var(--color-dark);
    }
    
    .page-title {
        color: var(--color-dark);
        position: relative;
        padding-bottom: 15px;
        margin-bottom: 2rem;
        border-bottom: 2px solid rgba(var(--color-dark-rgb), 0.1);
        font-weight: 700;
    }
    
   
   
   
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left  { text-align: left;  }
    
    .mt-1 { margin-top: 0.25rem; }
    .mt-2 { margin-top: 0.5rem; }
    .mt-3 { margin-top: 1rem; }
    .mt-4 { margin-top: 1.5rem; }
    .mt-5 { margin-top: 3rem; }
    
    .mb-1 { margin-bottom: 0.25rem; }
    .mb-2 { margin-bottom: 0.5rem; }
    .mb-3 { margin-bottom: 1rem; }
    .mb-4 { margin-bottom: 1.5rem; }
    .mb-5 { margin-bottom: 3rem; }
    
    .p-1 { padding: 0.25rem; }
    .p-2 { padding: 0.5rem; }
    .p-3 { padding: 1rem; }
    
    .rounded { border-radius: var(--border-radius); }
    .shadow { box-shadow: var(--box-shadow); }
    
   
   
   
    ::-webkit-scrollbar {
        width: 8px;
    }
    ::-webkit-scrollbar-thumb {
        background-color: rgba(var(--color-dark-rgb), 0.3);
        border-radius: 4px;
    }
    [data-theme="dark"] ::-webkit-scrollbar-thumb {
        background-color: rgba(255,255,255,0.15);
    }
    
   
   
   
    .form-label {
        font-weight: 600;
        color: var(--color-dark);
        margin-bottom: 0.5rem;
    }
    
    .form-control, .form-select {
        background-color: rgba(var(--color-dark-rgb), 0.05);
        border: 1px solid rgba(var(--color-dark-rgb), 0.15);
        color: var(--color-text);
        border-radius: var(--border-radius);
        padding: 0.75rem 1rem;
        transition: var(--transition);
    }
    
    .form-control:focus, .form-select:focus {
        background-color: rgba(var(--color-primary-rgb), 0.1);
        border-color: var(--color-primary);
        box-shadow: 0 0 0 0.25rem rgba(var(--color-primary-rgb), 0.15);
        color: var(--color-dark);
    }
    
    .form-text {
        color: rgba(var(--color-text-rgb), 0.8);
        font-size: 0.9rem;
    }
    
    .alert {
        border-radius: var(--border-radius);
        padding: 1rem;
    }
    
    .alert-danger {
        background-color: rgba(var(--color-danger-rgb), 0.1);
        border: 1px solid var(--color-danger);
        color: var(--color-danger);
    }
    
   
   
   
    .nav-tabs {
        border-bottom: 1px solid rgba(var(--color-dark-rgb), 0.1);
        margin-bottom: 1.5rem;
    }
    
    .nav-tabs .nav-link {
        color: var(--color-text);
        border: none;
        border-bottom: 3px solid transparent;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: var(--transition);
        border-radius: var(--border-radius) var(--border-radius) 0 0;
    }
    
    .nav-tabs .nav-link:hover {
        color: var(--color-primary);
        background-color: rgba(var(--color-primary-rgb), 0.1);
    }
    
    .nav-tabs .nav-link.active {
        color: var(--color-primary);
        border-bottom: 3px solid var(--color-primary);
        background-color: transparent;
    }
    
   
   
   
    .drop-zone {
        border: 2px dashed rgba(var(--color-primary-rgb), 0.5);
        border-radius: var(--border-radius);
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: var(--transition);
        background-color: rgba(var(--color-primary-rgb), 0.05);
        position: relative;
        overflow: hidden;
    }
    
    .drop-zone:hover, .drop-zone.highlight {
        background-color: rgba(var(--color-primary-rgb), 0.1);
        border-color: var(--color-primary);
    }
    
    .drop-zone p {
        margin-bottom: 1rem;
        color: rgba(var(--color-text-rgb), 0.8);
    }
    
    .browse-btn {
        background: transparent;
        color: var(--color-primary);
        border: 1px solid var(--color-primary);
        padding: 0.5rem 1.5rem;
        border-radius: 50px;
        font-weight: 500;
        transition: var(--transition);
    }
    
    .browse-btn:hover {
        background-color: rgba(var(--color-primary-rgb), 0.1);
        transform: translateY(-2px);
    }
    
   
   
   
    .preview-container {
        margin-top: 1.5rem;
    }
    
    .preview-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 1rem;
        background-color: rgba(var(--color-dark-rgb), 0.05);
        border-radius: 12px;
        margin-bottom: 0.75rem;
        transition: var(--transition);
    }
    
    .preview-item:hover {
        background-color: rgba(var(--color-dark-rgb), 0.08);
        transform: translateY(-2px);
    }
    
    .preview-content {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        overflow: hidden;
    }
    
    .preview-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .file-icon {
        background: linear-gradient(135deg, var(--color-primary), var(--color-info));
        color: var(--color-light);
    }
    
    .link-icon {
        background: linear-gradient(135deg, var(--color-secondary), var(--color-accent));
        color: var(--color-light);
    }
    
    .preview-info {
        overflow: hidden;
    }
    
    .preview-name {
        font-weight: 500;
        color: var(--color-dark);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .preview-meta {
        font-size: 0.85rem;
        color: rgba(var(--color-text-rgb), 0.7);
    }
    
    .preview-actions .btn {
        padding: 0.25rem 0.5rem;
        border-radius: 8px;
    }
    
   
   
   
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .fade-in {
        animation: fadeIn 0.4s ease forwards;
    }
    
   
   
   
    @media (max-width: 768px) {
        .card {
            padding: 1rem;
        }
        
        .nav-tabs .nav-link {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
        
        .drop-zone {
            padding: 1.5rem 1rem;
        }
    }
</style>
<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="flex-grow-1">
                            <h2 class="card-title mb-1">Crear Nueva Actividad</h2>
                            <p class="text-muted mb-0">Completa los detalles para crear una nueva actividad</p>
                        </div>
                        <div>
                            <a href="index.php?action=view_class&id=<?= $classId ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Volver
                            </a>
                        </div>
                    </div>
                    
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger mb-4 fade-in">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <form action="index.php?action=create_activity&class_id=<?= $classId ?>" method="POST" enctype="multipart/form-data" id="activityForm">
                        <div class="mb-4">
                            <label for="title" class="form-label">Título de la Actividad *</label>
                            <input type="text" class="form-control form-control-lg" id="title" name="title" 
                                   value="<?= htmlspecialchars($title ?? '') ?>" placeholder="Ej: Ensayo sobre inteligencia artificial" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label">Descripción *</label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="4" placeholder="Describe la actividad en detalle..." required><?= htmlspecialchars($description ?? '') ?></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label for="deadline" class="form-label">Fecha Límite *</label>
                            <input type="datetime-local" class="form-control" id="deadline" 
                                   name="deadline" value="<?= htmlspecialchars($deadline ?? date('Y-m-d\TH:i')) ?>" required>
                            <div class="form-text mt-1">
                                <i class="bi bi-clock me-1"></i> Hora local: <?= $clientTimezone ?>
                            </div>
                        </div>
                        
                        <!-- Sección de recursos con pestañas -->
                        <div class="mb-4">
                            <label class="form-label mb-3">Recursos Adicionales (opcional):</label>
                            
                            <!-- Pestañas para seleccionar tipo -->
                            <ul class="nav nav-tabs" id="resourceTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="files-tab" data-bs-toggle="tab" data-bs-target="#files" type="button" role="tab">
                                        <i class="bi bi-file-earmark me-1"></i> Archivos
                                    </button>
                                </li>
                            </ul>
                            
                            <!-- Contenido de pestañas -->
                            <div class="tab-content p-3 border border-top-0 rounded-bottom" id="resourceTabsContent">
                                <!-- Pestaña de archivos -->
                                <div class="tab-pane fade show active" id="files" role="tabpanel">
                                    <div class="drop-zone mb-3" id="dropZone">
                                        <p class="text-muted mb-3"><i class="bi bi-cloud-arrow-up me-2"></i> Arrastra y suelta archivos aquí o haz clic para seleccionar</p>
                                        <input type="file" class="d-none" id="fileInput" name="activity_files[]" multiple>
                                        <button type="button" class="browse-btn" id="browseBtn">
                                            <i class="bi bi-folder2-open me-2"></i> Seleccionar archivos
                                        </button>
                                    </div>
                                    <div class="preview-container" id="filePreview"></div>
                                </div>
                                
                                <!-- Pestaña de enlaces -->
                                <div class="tab-pane fade" id="links" role="tabpanel">
                                    <div class="mb-4">
                                        <div class="input-group">
                                            <input type="url" class="form-control" placeholder="https://ejemplo.com" id="linkInput">
                                            <button type="button" class="btn btn-primary" id="addLinkBtn">
                                                <i class="bi bi-plus-lg me-1"></i> Agregar
                                            </button>
                                        </div>
                                    </div>
                                    <div class="preview-container" id="linksPreview"></div>
                                    <input type="hidden" name="links[]" id="linksHidden">
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-3 mt-5">
                            <button type="submit" class="btn btn-primary btn-lg py-3">
                                <i class="bi bi-plus-circle me-2"></i> Crear Actividad
                            </button>
                            <a href="index.php?action=view_class&id=<?= $classId ?>" class="btn btn-outline-secondary">
                                Cancelar
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
        dropZone.classList.add('highlight');
    }
    
    function unhighlight() {
        dropZone.classList.remove('highlight');
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
            fileElement.className = 'preview-item fade-in';
            fileElement.innerHTML = `
                <div class="preview-content">
                    <div class="preview-icon file-icon">
                        <i class="bi bi-file-earmark"></i>
                    </div>
                    <div class="preview-info">
                        <div class="preview-name">${file.name}</div>
                        <div class="preview-meta">${formatFileSize(file.size)}</div>
                    </div>
                </div>
                <div class="preview-actions">
                    <button type="button" class="btn btn-sm btn-danger remove-file">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;
            
            filePreview.appendChild(fileElement);
            
            
            fileElement.querySelector('.remove-file').addEventListener('click', () => {
                fileElement.remove();
            });
        });
    }
    
    
    addLinkBtn.addEventListener('click', function(e) {
        e.preventDefault(); 
        
        const url = linkInput.value.trim();
        if (url && isValidUrl(url)) {
            links.push(url);
            updateLinksPreview();
            linkInput.value = '';
        } else {
            showToast('Por favor ingrese una URL válida', 'warning');
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
            const domain = extractDomain(link);
            
            const linkElement = document.createElement('div');
            linkElement.className = 'preview-item fade-in';
            linkElement.innerHTML = `
                <div class="preview-content">
                    <div class="preview-icon link-icon">
                        <i class="bi bi-link-45deg"></i>
                    </div>
                    <div class="preview-info">
                        <div class="preview-name">${domain}</div>
                        <a href="${link}" target="_blank" class="preview-meta text-truncate d-block">${link}</a>
                    </div>
                </div>
                <div class="preview-actions">
                    <button type="button" class="btn btn-sm btn-danger remove-link" data-index="${index}">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;
            
            linksPreview.appendChild(linkElement);
            
            
            linkElement.querySelector('.remove-link').addEventListener('click', function() {
                const indexToRemove = parseInt(this.getAttribute('data-index'));
                links.splice(indexToRemove, 1);
                updateLinksPreview();
            });
        });
    }
    
    function extractDomain(url) {
        try {
            const parsedUrl = new URL(url);
            let domain = parsedUrl.hostname;
            
            if (domain.startsWith('www.')) {
                domain = domain.substring(4);
            }
            return domain;
        } catch (e) {
            
            return url.length > 30 ? url.substring(0, 30) + '...' : url;
        }
    }
    
    
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type} border-0 position-fixed bottom-0 end-0 m-3`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
    
    
    if (!document.cookie.match(/client_timezone/)) {
        const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        document.cookie = `client_timezone=${timezone}; path=/; max-age=${60*60*24*365}`;
    }
});
</script>

<?php include PARTIALS_DIR . '/footer.php'; ?>