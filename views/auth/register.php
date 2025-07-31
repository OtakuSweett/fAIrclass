<?php include PARTIALS_DIR . '/header.php'; ?>
<?php include PARTIALS_DIR . '/flash.php'; ?>

<style>
   
    .register-section {
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
        background: linear-gradient(135deg, rgba(168, 208, 230, 0.1), rgba(248, 183, 216, 0.1));
        position: relative;
        overflow: hidden;
    }
    
    .register-section::before {
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
    
    .register-section::after {
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
    
    .register-container {
        position: relative;
        z-index: 2;
        max-width: 500px;
        width: 100%;
    }
    
    .register-card {
        background-color: var(--color-light);
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
        transition: var(--transition);
    }
    
    .register-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }
    
    .register-header {
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        padding: 2.5rem;
        text-align: center;
        color: white;
    }
    
    .register-logo {
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
    
    .register-title {
        font-weight: 700;
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
    }
    
    .register-subtitle {
        opacity: 0.9;
        font-size: 1rem;
    }
    
    .register-body {
        padding: 2.5rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }
    
    .form-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .form-col {
        flex: 1;
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
    
    .btn-register {
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
    
    .btn-register:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    
    .register-footer {
        text-align: center;
        padding: 1.5rem 0 0;
        color: var(--color-text);
    }
    
    .register-link {
        color: var(--color-secondary);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    
    .register-link:hover {
        color: var(--color-accent);
        transform: translateX(5px);
    }
    
    .password-toggle {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--color-text);
        opacity: 0.7;
        cursor: pointer;
        transition: var(--transition);
    }
    
    .password-toggle:hover {
        opacity: 1;
        color: var(--color-secondary);
    }
    
    .terms-container {
        display: flex;
        align-items: flex-start;
        gap: 0.8rem;
        margin-bottom: 1.5rem;
    }
    
    .terms-text {
        font-size: 0.9rem;
        color: var(--color-text);
    }
    
    .terms-link {
        color: var(--color-secondary);
        text-decoration: none;
        font-weight: 600;
    }
    
    .terms-link:hover {
        text-decoration: underline;
    }
    
   
    @media (max-width: 576px) {
        .register-header {
            padding: 1.8rem;
        }
        
        .register-body {
            padding: 1.8rem;
        }
        
        .form-row {
            flex-direction: column;
            gap: 0;
        }
    }
</style>

<div class="register-section">
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <div class="register-logo">
                    <i class="bi bi-person-plus"></i>
                </div>
                <h2 class="register-title">Crea tu cuenta</h2>
                <p class="register-subtitle">Únete a nuestra comunidad educativa</p>
            </div>
            
            <div class="register-body">
                <form action="index.php?action=register" method="POST">
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="first_name" class="form-label">Nombre</label>
                                <div class="input-wrapper">
                                    <div class="input-icon">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required
                                           value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>"
                                           placeholder="Tu nombre">
                                </div>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label for="last_name" class="form-label">Apellido</label>
                                <div class="input-wrapper">
                                    <div class="input-icon">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required
                                           value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>"
                                           placeholder="Tu apellido">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <div class="input-wrapper">
                            <div class="input-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <input type="email" class="form-control" id="email" name="email" required
                                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                   placeholder="tu@correo.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-wrapper">
                            <div class="input-icon">
                                <i class="bi bi-lock"></i>
                            </div>
                            <input type="password" class="form-control" id="password" name="password" required
                                   placeholder="••••••••">
                            <span class="password-toggle" id="passwordToggle">
                                <i class="bi bi-eye"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                        <div class="input-wrapper">
                            <div class="input-icon">
                                <i class="bi bi-lock"></i>
                            </div>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required
                                   placeholder="••••••••">
                            <span class="password-toggle" id="confirmPasswordToggle">
                                <i class="bi bi-eye"></i>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Campo oculto para el rol -->
                    <input type="hidden" name="role" value="student">
                    
                    <div class="form-group">
                        <div class="terms-container">
                            <input type="checkbox" id="terms" name="terms" required>
                            <label for="terms" class="terms-text">
                                Acepto los <a href="#" class="terms-link">Términos y Condiciones</a> y la 
                                <a href="#" class="terms-link">Política de Privacidad</a>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn-register">
                            <i class="bi bi-person-plus"></i> Crear Cuenta
                        </button>
                    </div>
                </form>
                
                <div class="register-footer">
                    <a href="index.php?action=login" class="register-link">
                        <i class="bi bi-arrow-left"></i> ¿Ya tienes cuenta? Inicia Sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include PARTIALS_DIR . '/footer.php'; ?>

<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        
        const registerCard = document.querySelector('.register-card');
        registerCard.style.opacity = '0';
        registerCard.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            registerCard.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            registerCard.style.opacity = '1';
            registerCard.style.transform = 'translateY(0)';
        }, 300);
        
        
        const passwordInput = document.getElementById('password');
        const passwordToggle = document.getElementById('passwordToggle');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const confirmPasswordToggle = document.getElementById('confirmPasswordToggle');
        
        
        function togglePasswordVisibility(input, toggle) {
            if (input.type === 'password') {
                input.type = 'text';
                toggle.innerHTML = '<i class="bi bi-eye-slash"></i>';
            } else {
                input.type = 'password';
                toggle.innerHTML = '<i class="bi bi-eye"></i>';
            }
        }
        
        passwordToggle.addEventListener('click', () => {
            togglePasswordVisibility(passwordInput, passwordToggle);
        });
        
        confirmPasswordToggle.addEventListener('click', () => {
            togglePasswordVisibility(confirmPasswordInput, confirmPasswordToggle);
        });
        
        
        function validatePassword() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            
            if (password !== confirmPassword && confirmPassword !== '') {
                confirmPasswordInput.setCustomValidity('Las contraseñas no coinciden');
            } else {
                confirmPasswordInput.setCustomValidity('');
            }
        }
        
        passwordInput.addEventListener('input', validatePassword);
        confirmPasswordInput.addEventListener('input', validatePassword);
        
        
        const formControls = document.querySelectorAll('.form-control');
        formControls.forEach(control => {
            control.addEventListener('focus', function() {
                this.parentElement.querySelector('.input-icon').style.color = 'var(--color-secondary)';
            });
            
            control.addEventListener('blur', function() {
                this.parentElement.querySelector('.input-icon').style.color = 'var(--color-primary)';
            });
        });
        
        
        const registerBtn = document.querySelector('.btn-register');
        registerBtn.addEventListener('mouseenter', () => {
            registerBtn.style.transform = 'translateY(-3px) scale(1.02)';
        });
        
        registerBtn.addEventListener('mouseleave', () => {
            registerBtn.style.transform = 'translateY(0) scale(1)';
        });
    });
</script>