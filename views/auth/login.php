<?php include PARTIALS_DIR . '/header.php'; ?>
<?php include PARTIALS_DIR . '/flash.php'; ?>

<style>
   
    .login-section {
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
        background: linear-gradient(135deg, rgba(168, 208, 230, 0.1), rgba(248, 183, 216, 0.1));
        position: relative;
        overflow: hidden;
    }
    
    .login-section::before {
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
    
    .login-section::after {
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
    
    .login-container {
        position: relative;
        z-index: 2;
        max-width: 450px;
        width: 100%;
    }
    
    .login-card {
        background-color: var(--color-light);
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
        transition: var(--transition);
    }
    
    .login-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }
    
    .login-header {
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        padding: 2.5rem;
        text-align: center;
        color: white;
    }
    
    .login-logo {
        width: 80px;
        height: 80px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
    }
    
    .login-title {
        font-weight: 700;
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
    }
    
    .login-subtitle {
        opacity: 0.9;
        font-size: 1rem;
    }
    
    .login-body {
        padding: 2.5rem;
    }
    
    .form-group {
        margin-bottom: 1.8rem;
        position: relative;
    }
    
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--color-dark);
    }
    
    .input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--color-primary);
        font-size: 1.2rem;
    }
    
    .form-control {
        width: 100%;
        padding: 0.9rem 1.5rem 0.9rem 45px;
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
    
    .btn-login {
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        color: white;
        border: none;
        padding: 1rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        font-size: 1.1rem;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.8rem;
        width: 100%;
    }
    
    .btn-login:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    
    .login-footer {
        text-align: center;
        padding: 1.5rem 0 0;
        color: var(--color-text);
    }
    
    .login-link {
        color: var(--color-secondary);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    
    .login-link:hover {
        color: var(--color-accent);
        transform: translateX(5px);
    }
    
    .divider {
        display: flex;
        align-items: center;
        margin: 1.5rem 0;
        color: var(--color-text);
        opacity: 0.7;
    }
    
    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: rgba(0,0,0,0.1);
    }
    
    .divider-text {
        padding: 0 1rem;
    }
    
    .social-login {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .btn-social {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.8rem;
        border-radius: var(--border-radius);
        background: rgba(255,255,255,0.7);
        border: 1px solid #e0e0e0;
        transition: var(--transition);
        color: var(--color-text);
        font-weight: 500;
    }
    
    .btn-social:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    
    .btn-google:hover {
        background: rgba(234, 67, 53, 0.1);
        border-color: rgba(234, 67, 53, 0.3);
    }
    
    .btn-microsoft:hover {
        background: rgba(0, 120, 215, 0.1);
        border-color: rgba(0, 120, 215, 0.3);
    }
    
   
    @media (max-width: 576px) {
        .login-header {
            padding: 1.8rem;
        }
        
        .login-body {
            padding: 1.8rem;
        }
        
        .social-login {
            flex-direction: column;
        }
    }
</style>

<div class="login-section">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <i class="bi bi-shield-lock"></i>
                </div>
                <h2 class="login-title">Bienvenido de vuelta</h2>
                <p class="login-subtitle">Ingresa a tu cuenta para continuar</p>
            </div>
            
            <div class="login-body">
                <?php include PARTIALS_DIR . '/flash.php'; ?>
                
                <form action="index.php?action=login" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                    <div class="form-group">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <div class="input-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <input type="email" class="form-control" id="email" name="email" required
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                               placeholder="tu@correo.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-icon">
                            <i class="bi bi-lock"></i>
                        </div>
                        <input type="password" class="form-control" id="password" name="password" required
                               placeholder="••••••••">
                    </div>
                    
                    <?php if (env('CF_TURNSTILE_SITEKEY')): ?>
                        <div class="cf-turnstile" data-sitekey="<?= htmlspecialchars(env('CF_TURNSTILE_SITEKEY')) ?>"></div>
                    <?php endif; ?>
                    <div class="form-group">
                        <button type="submit" class="btn-login">
                            <i class="bi bi-box-arrow-in-right"></i> Ingresar
                        </button>
                    </div>
                </form>
                
                
                <div class="login-footer">
                    <a href="index.php?action=register" class="login-link">
                        ¿No tienes cuenta? Regístrate aquí <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include PARTIALS_DIR . '/footer.php'; ?>

<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        
        const loginCard = document.querySelector('.login-card');
        loginCard.style.opacity = '0';
        loginCard.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            loginCard.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            loginCard.style.opacity = '1';
            loginCard.style.transform = 'translateY(0)';
        }, 300);
        
        
        const formControls = document.querySelectorAll('.form-control');
        formControls.forEach(control => {
            control.addEventListener('focus', function() {
                this.parentElement.querySelector('.input-icon').style.color = 'var(--color-secondary)';
            });
            
            control.addEventListener('blur', function() {
                this.parentElement.querySelector('.input-icon').style.color = 'var(--color-primary)';
            });
        });
        
        
        const passwordInput = document.getElementById('password');
        const passwordIcon = passwordInput.parentElement.querySelector('.input-icon');
        
        passwordIcon.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.innerHTML = '<i class="bi bi-unlock"></i>';
            } else {
                passwordInput.type = 'password';
                passwordIcon.innerHTML = '<i class="bi bi-lock"></i>';
            }
        });
    });
</script>