<?php include PARTIALS_DIR . '/headerindex.php'; ?>
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
    
    .mb-1 { margin-bottom: 0.25rem; }
    .mb-2 { margin-bottom: 0.5rem; }
    .mb-3 { margin-bottom: 1rem; }
    
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
    
   
   
   
    .hero-section {
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        padding: 5rem 0;
        position: relative;
        overflow: hidden;
        border-radius: 0 0 30px 30px;
        margin-bottom: 4rem;
        box-shadow: var(--box-shadow);
        color: #fff;
    }
    
    .hero-section::before,
    .hero-section::after {
        content: '';
        position: absolute;
        background: rgba(255,255,255,0.15);
        border-radius: 50%;
    }
    
    .hero-section::before {
        top: -50px;
        right: -50px;
        width: 300px;
        height: 300px;
    }
    
    .hero-section::after {
        bottom: -80px;
        left: -80px;
        width: 250px;
        height: 250px;
        background: rgba(255,255,255,0.1);
    }
    
    .hero-section h1 {
        font-weight: 800;
        font-size: 3.5rem;
        letter-spacing: -0.5px;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 2;
    }
    
    .hero-section p {
        font-size: 1.4rem;
        max-width: 700px;
        margin: 0 auto 2.5rem;
        position: relative;
        z-index: 2;
    }
    
    .btn-hero {
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-size: 1.2rem;
        font-weight: 600;
        transition: var(--transition);
        position: relative;
        z-index: 2;
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
    
    .btn-hero-primary {
        background: var(--color-light);
        color: var(--color-primary);
        border: none;
    }
    
    .btn-hero-primary:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    }
    
    .btn-hero-outline {
        background: transparent;
        color: var(--color-light);
        border: 2px solid var(--color-light);
    }
    
    .btn-hero-outline:hover {
        background: rgba(255,255,255,0.15);
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    }
    
   
    .stats-section {
        margin-bottom: 5rem;
    }
    
    .stat-card {
        background: var(--color-light);
        border-radius: 20px;
        padding: 2rem;
        height: 100%;
        box-shadow: var(--box-shadow);
        transition: var(--transition);
        border: none;
        position: relative;
        overflow: hidden;
        text-align: center;
    }
    
    .stat-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, var(--color-secondary), var(--color-primary));
    }
    
    .stat-value {
        font-size: 3.5rem;
        font-weight: 800;
        color: var(--color-primary);
        margin: 1rem 0;
        line-height: 1;
    }
    
    .stat-label {
        color: var(--color-text);
        font-size: 1.1rem;
    }
    
   
    .features-section {
        margin-bottom: 5rem;
    }
    
    .feature-content {
        padding: 2rem;
    }
    
    .feature-content h2 {
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: var(--color-dark);
        font-size: 2.2rem;
    }
    
    .feature-list {
        list-style: none;
        padding: 0;
    }
    
    .feature-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1.5rem;
        padding: 1.2rem;
        background: rgba(var(--color-primary-rgb), 0.1);
        border-radius: 15px;
        transition: var(--transition);
    }
    
    .feature-item:hover {
        transform: translateX(10px);
        background: rgba(var(--color-primary-rgb), 0.2);
    }
    
    .feature-icon {
        background: linear-gradient(135deg, var(--color-primary), var(--color-accent));
        color: var(--color-light);
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-right: 1.5rem;
        flex-shrink: 0;
    }
    
    .feature-text {
        flex: 1;
    }
    
    .feature-text h3 {
        margin-top: 0;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--color-dark);
    }
    
    .feature-image {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        height: 100%;
    }
    
    .feature-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .feature-image:hover img {
        transform: scale(1.05);
    }
    
   
    .cta-section {
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        border-radius: 20px;
        padding: 4rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
        margin-bottom: 5rem;
        box-shadow: var(--box-shadow);
        color: #fff;
    }
    
    .cta-section::before,
    .cta-section::after {
        content: '';
        position: absolute;
        background: rgba(255,255,255,0.15);
        border-radius: 50%;
    }
    
    .cta-section::before {
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
    }
    
    .cta-section::after {
        bottom: -80px;
        left: -80px;
        width: 250px;
        height: 250px;
        background: rgba(255,255,255,0.1);
    }
    
    .cta-section h2 {
        font-weight: 700;
        color: var(--color-light);
        font-size: 2.5rem;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 2;
    }
    
    .cta-section p {
        color: rgba(255,255,255,0.9);
        font-size: 1.3rem;
        max-width: 700px;
        margin: 0 auto 2.5rem;
        position: relative;
        z-index: 2;
    }
    
    .btn-cta {
        background: var(--color-light);
        color: var(--color-primary);
        border: none;
        padding: 1rem 3rem;
        border-radius: 50px;
        font-size: 1.2rem;
        font-weight: 600;
        transition: var(--transition);
        position: relative;
        z-index: 2;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    
    .btn-cta:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.2);
    }
    
   
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
    }
    
    .floating {
        animation: float 4s ease-in-out infinite;
    }
    
   
    .theme-toggle {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        z-index: 1000;
        transition: var(--transition);
    }
    
    .theme-toggle:hover {
        transform: translateY(-3px) rotate(15deg);
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }
    
    .theme-toggle i {
        font-size: 1.5rem;
    }
    
   
    @media (max-width: 768px) {
        .hero-section h1 {
            font-size: 2.5rem;
        }
        
        .hero-section p {
            font-size: 1.1rem;
        }
        
        .stat-value {
            font-size: 2.5rem;
        }
        
        .feature-content h2 {
            font-size: 1.8rem;
        }
        
        .cta-section h2 {
            font-size: 2rem;
        }
        
        .theme-toggle {
            bottom: 15px;
            right: 15px;
            width: 45px;
            height: 45px;
        }
    }
</style>



<!-- Hero Section -->
<div class="hero-section text-white">
    <div class="container text-center">
        <h1 class="display-4 mb-4 floating">Bienvenido a fAIrclass</h1>
        <p class="lead mb-4">La plataforma educativa con detección inteligente de originalidad</p>
        
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="index.php?action=register" class="btn btn-hero btn-hero-primary">
                <i class="bi bi-person-plus me-2"></i> Regístrate Gratis
            </a>
            <a href="index.php?action=login" class="btn btn-hero btn-hero-outline">
                <i class="bi bi-box-arrow-in-right me-2"></i> Ingresar
            </a>
        </div>
    </div>
</div>

<div class="container">
    <!-- Estadísticas principales -->
    <div class="stats-section">
        <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
            <div class="col">
                <div class="stat-card">
                    <h2 class="stat-value"><?= $stats['total_classes'] ?></h2>
                    <p class="stat-label">Clases Activas</p>
                </div>
            </div>
            <div class="col">
                <div class="stat-card">
                    <h2 class="stat-value"><?= $stats['total_activities'] ?></h2>
                    <p class="stat-label">Actividades Realizadas</p>
                </div>
            </div>
            <div class="col">
                <div class="stat-card">
                    <h2 class="stat-value"><?= $stats['total_users'] ?></h2>
                    <p class="stat-label">Usuarios Registrados</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Características principales -->
    <section class="features-section">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="feature-content">
                    <h2>Detección Inteligente de Originalidad</h2>
                    <ul class="feature-list">
                        <li class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div class="feature-text">
                                <h3>Análisis en tiempo real con IA</h3>
                                <p class="mb-0">Tecnología avanzada para detectar similitudes de contenido al instante.</p>
                            </div>
                        </li>
                        <li class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <div class="feature-text">
                                <h3>Revisiones automáticas de similitud</h3>
                                <p class="mb-0">Procesamiento eficiente que ahorra tiempo y recursos.</p>
                            </div>
                        </li>
                        <li class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <div class="feature-text">
                                <h3>Reportes detallados en un clic</h3>
                                <p class="mb-0">Resultados claros con análisis exhaustivos de originalidad.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="feature-image">
                    <img src="../assets/img/features.png" alt="Características de fAIrclass">
                </div>
            </div>
        </div>
    </section>

    <!-- Llamado a la acción -->
    <div class="cta-section">
        <h2 class="mb-4">¿Listo para comenzar?</h2>
        <p class="lead mb-4">Únete a nuestra comunidad educativa hoy mismo</p>
        <a href="index.php?action=register" class="btn btn-cta">
            <i class="bi bi-rocket-takeoff me-2"></i> Crear Cuenta Gratis
        </a>
    </div>
</div>

<?php include PARTIALS_DIR . '/footer.php'; ?>

<script>
    
    function toggleTheme() {
        const html = document.documentElement;
        const currentTheme = html.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        html.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        
        
        const themeIcon = document.getElementById('themeIcon');
        if (newTheme === 'dark') {
            themeIcon.className = 'bi bi-sun';
        } else {
            themeIcon.className = 'bi bi-moon-stars';
        }
    }
    
    
    function applySavedTheme() {
        const savedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        if (savedTheme) {
            document.documentElement.setAttribute('data-theme', savedTheme);
        } else if (prefersDark) {
            document.documentElement.setAttribute('data-theme', 'dark');
        }
        
        
        const themeIcon = document.getElementById('themeIcon');
        const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
        if (currentTheme === 'dark') {
            themeIcon.className = 'bi bi-sun';
        } else {
            themeIcon.className = 'bi bi-moon-stars';
        }
    }
    
    
    applySavedTheme();
    
    
    document.getElementById('themeToggle').addEventListener('click', toggleTheme);
    
    
    document.addEventListener('DOMContentLoaded', function() {
        
        const statCards = document.querySelectorAll('.stat-card');
        statCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 300 + (index * 200));
        });
        
        
        const featureItems = document.querySelectorAll('.feature-item');
        featureItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateX(-20px)';
            
            setTimeout(() => {
                item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                item.style.opacity = '1';
                item.style.transform = 'translateX(0)';
            }, 500 + (index * 200));
        });
        
        
        const ctaBtn = document.querySelector('.btn-cta');
        if (ctaBtn) {
            ctaBtn.addEventListener('mouseenter', () => {
                ctaBtn.style.transform = 'scale(1.05)';
            });
            
            ctaBtn.addEventListener('mouseleave', () => {
                ctaBtn.style.transform = 'scale(1)';
            });
        }
    });
</script>