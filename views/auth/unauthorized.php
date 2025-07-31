<?php include PARTIALS_DIR . '/header.php'; ?>
<?php include PARTIALS_DIR . '/flash.php'; ?>

<style>
   
    .unauthorized-section {
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        background: linear-gradient(135deg, rgba(168, 208, 230, 0.1), rgba(248, 183, 216, 0.1));
        position: relative;
        overflow: hidden;
    }
    
    .unauthorized-section::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 300px;
        height: 300px;
        background: rgba(168, 208, 230, 0.1);
        border-radius: 50%;
        z-index: 0;
    }
    
    .unauthorized-section::after {
        content: '';
        position: absolute;
        bottom: -100px;
        left: -100px;
        width: 300px;
        height: 300px;
        background: rgba(248, 183, 216, 0.1);
        border-radius: 50%;
        z-index: 0;
    }
    
    .unauthorized-container {
        position: relative;
        z-index: 2;
        max-width: 600px;
        width: 100%;
        text-align: center;
    }
    
    .unauthorized-card {
        background-color: var(--color-light);
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
        transition: var(--transition);
        padding: 3rem 2rem;
    }
    
    .unauthorized-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }
    
    .unauthorized-icon {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, rgba(245, 108, 108, 0.1), rgba(248, 183, 216, 0.2));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        font-size: 3.5rem;
        color: #f76c6c;
        border: 8px solid rgba(247, 108, 108, 0.2);
    }
    
    .unauthorized-title {
        font-weight: 800;
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: #f76c6c;
        position: relative;
        display: inline-block;
    }
    
    .unauthorized-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, var(--color-primary), var(--color-secondary));
        border-radius: 2px;
    }
    
    .unauthorized-message {
        font-size: 1.3rem;
        color: var(--color-text);
        margin-bottom: 2.5rem;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
    }
    
    .btn-unauthorized {
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        color: white;
        border: none;
        padding: 1rem 2.5rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        font-size: 1.1rem;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.8rem;
        text-decoration: none;
    }
    
    .btn-unauthorized:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    
    .suggestions {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(0,0,0,0.1);
    }
    
    .suggestions-title {
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: var(--color-dark);
    }
    
    .suggestions-list {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }
    
    .suggestion-item {
        background: rgba(168, 208, 230, 0.1);
        border-radius: var(--border-radius);
        padding: 1rem;
        transition: var(--transition);
        width: 160px;
    }
    
    .suggestion-item:hover {
        transform: translateY(-5px);
        background: rgba(168, 208, 230, 0.2);
    }
    
    .suggestion-icon {
        font-size: 1.8rem;
        color: var(--color-primary);
        margin-bottom: 0.8rem;
    }
    
    .suggestion-text {
        font-size: 0.9rem;
        color: var(--color-text);
    }
    
   
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .pulse {
        animation: pulse 2s infinite;
    }
    
   
    @media (max-width: 768px) {
        .unauthorized-title {
            font-size: 2rem;
        }
        
        .unauthorized-message {
            font-size: 1.1rem;
        }
        
        .unauthorized-icon {
            width: 100px;
            height: 100px;
            font-size: 2.5rem;
        }
    }
</style>

<div class="unauthorized-section">
    <div class="unauthorized-container">
        <div class="unauthorized-card">
            <div class="unauthorized-icon pulse">
                <i class="bi bi-shield-exclamation"></i>
            </div>
            
            <h1 class="unauthorized-title">Acceso No Autorizado</h1>
            
            <p class="unauthorized-message">
                Lo sentimos, no tienes los permisos necesarios para acceder a esta sección. 
                Si crees que esto es un error, por favor contacta con el administrador del sistema.
            </p>
            
            <a href="index.php?action=dashboard" class="btn-unauthorized">
                <i class="bi bi-house-door"></i> Volver al Dashboard
            </a>
            
            <div class="suggestions">
                <h4 class="suggestions-title">También puedes:</h4>
                <div class="suggestions-list">
                    <div class="suggestion-item">
                        <div class="suggestion-icon">
                            <i class="bi bi-arrow-left-circle"></i>
                        </div>
                        <div class="suggestion-text">Ir a la página anterior</div>
                    </div>
                    
                    <div class="suggestion-item">
                        <div class="suggestion-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        <div class="suggestion-text">Ver tu perfil</div>
                    </div>
                    
                    <div class="suggestion-item">
                        <div class="suggestion-icon">
                            <i class="bi bi-question-circle"></i>
                        </div>
                        <div class="suggestion-text">Solicitar ayuda</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include PARTIALS_DIR . '/footer.php'; ?>

<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        
        const card = document.querySelector('.unauthorized-card');
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 300);
        
        
        const suggestionItems = document.querySelectorAll('.suggestion-item');
        suggestionItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.querySelector('.suggestion-icon').style.transform = 'scale(1.2)';
                this.querySelector('.suggestion-icon').style.color = 'var(--color-secondary)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.querySelector('.suggestion-icon').style.transform = 'scale(1)';
                this.querySelector('.suggestion-icon').style.color = 'var(--color-primary)';
            });
        });
        
        
        const btn = document.querySelector('.btn-unauthorized');
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px) scale(1.05)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
</script>