<?php include PARTIALS_DIR . '/header.php'; ?>
<?php include PARTIALS_DIR . '/flash.php'; ?>
<style>
   
    .profile-section {
        padding: 4rem 0;
        background: linear-gradient(135deg, rgba(168, 208, 230, 0.05), rgba(248, 183, 216, 0.05));
        min-height: calc(100vh - 80px);
    }
    
    .profile-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }
    
    .profile-card {
        background-color: var(--color-light);
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
        transition: var(--transition);
    }
    
    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }
    
    .profile-header {
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        padding: 2.5rem;
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .profile-header::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    
.profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    margin: 0 auto 1.5rem;
    position: relative;
    z-index: 2;
    border: 4px solid rgba(255, 255, 255, 0.3);
    box-shadow: var(--box-shadow);
    color: white;
    font-weight: bold;
    overflow: hidden;
    user-select: none;
}


.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    display: block;
}


.profile-avatar.no-image {
    font-size: 4rem;
    text-transform: uppercase;
    user-select: none;
}



    

    .profile-name {
        font-weight: 700;
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
    }
    
    .profile-email {
        opacity: 0.9;
        font-size: 1.1rem;
        position: relative;
        z-index: 2;
    }
    
    .profile-body {
        padding: 2.5rem;
    }
    
    .profile-section-title {
        font-weight: 700;
        color: var(--color-dark);
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--color-primary);
        position: relative;
    }
    
    .profile-section-title::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 50px;
        height: 2px;
        background: var(--color-secondary);
    }
    
    .form-group {
        margin-bottom: 1.8rem;
        position: relative;
    }
    
    .form-row {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 1.8rem;
    }
    
    .form-col {
        flex: 1;
    }
    
    .form-label {
        display: block;
        margin-bottom: 0.7rem;
        font-weight: 600;
        color: var(--color-dark);
        display: flex;
        align-items: center;
        gap: 0.5rem;
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
    
    .btn-profile {
        padding: 0.9rem 1.8rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.7rem;
    }
    
    .btn-update {
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        color: white;
        border: none;
    }
    
    .btn-update:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    
    .btn-change-password {
        background: var(--color-accent);
        color: white;
        border: none;
    }
    
    .btn-change-password:hover {
        background: #e55e5e;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .divider {
        height: 1px;
        background: rgba(0,0,0,0.1);
        margin: 2.5rem 0;
        position: relative;
    }
    
    .divider::after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 80px;
        height: 100%;
        background: var(--color-secondary);
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
    
   
    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
            gap: 0;
        }
        
        .profile-header {
            padding: 1.8rem;
        }
        
        .profile-body {
            padding: 1.8rem;
        }
    }
</style>

<div class="profile-section">
    <div class="profile-container">
        <div class="profile-card">
            <div class="profile-header">

<?php 
$fotoPerfil = $_SESSION['user']['profile_picture'] ?? '';

$claseAvatar = empty($fotoPerfil) ? 'profile-avatar no-image' : 'profile-avatar';
?>

<div class="<?= $claseAvatar ?>">
    <?php if (!empty($fotoPerfil)): ?>
        <img src="<?= htmlspecialchars($fotoPerfil) ?>" alt="Foto de perfil" class="profile-img">
    <?php else: ?>
        <?= strtoupper(substr($_SESSION['user']['full_name'] ?? '', 0, 1)) ?>
    <?php endif; ?>
</div>

                <h2 class="profile-name"><?= htmlspecialchars($_SESSION['user']['full_name']) ?></h2>
                <p class="profile-email"><?= htmlspecialchars($_SESSION['user']['email']) ?></p>
            </div>
            
            <div class="profile-body">
                <h3 class="profile-section-title">
                    <i class="bi bi-person-circle me-2"></i> Información del Perfil y Contraseña
                </h3>
                
                <form action="index.php?action=update_profile" method="POST" enctype="multipart/form-data" id="profileForm">
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="full_name" class="form-label">
                                    <i class="bi bi-person"></i> Nombre Completo
                                </label>
                                <div class="input-icon">
                                    <i class="bi bi-person"></i>
                                </div>
                                <input type="text" class="form-control" id="full_name" name="full_name" 
                                       value="<?= htmlspecialchars($_SESSION['user']['full_name']) ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-col">
                            <div class="form-group">
                                <label for="email" class="form-label">
                                    <i class="bi bi-envelope"></i> Correo Electrónico
                                </label>
                                <div class="input-icon">
                                    <i class="bi bi-envelope"></i>
                                </div>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="<?= htmlspecialchars($_SESSION['user']['email']) ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="profile_picture" class="form-label">
                            <i class="bi bi-image"></i> Foto de Perfil (Opcional)
                        </label>
                        <input type="file" class="form-control" id="profile_picture" name="profile_picture" 
                               accept=".jpg,.jpeg,.png,.webp">
                    </div>
                    
                    <div class="divider"></div>

                    <h4 class="profile-section-subtitle">
                        <i class="bi bi-shield-lock me-2"></i> Cambiar Contraseña (Opcional)
                    </h4>

                    <div class="form-group">
                        <label for="current_password" class="form-label">
                            <i class="bi bi-lock"></i> Contraseña Actual
                        </label>
                        <div class="input-icon">
                            <i class="bi bi-lock"></i>
                        </div>
                        <input type="password" class="form-control" id="current_password" name="current_password"
                               placeholder="Ingresa tu contraseña actual">
                        <span class="password-toggle" id="currentPasswordToggle" style="cursor:pointer;">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="new_password" class="form-label">
                                    <i class="bi bi-key"></i> Nueva Contraseña
                                </label>
                                <div class="input-icon">
                                    <i class="bi bi-key"></i>
                                </div>
                                <input type="password" class="form-control" id="new_password" name="new_password"
                                       placeholder="Crea una nueva contraseña">
                                <span class="password-toggle" id="newPasswordToggle" style="cursor:pointer;">
                                    <i class="bi bi-eye"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-col">
                            <div class="form-group">
                                <label for="confirm_password" class="form-label">
                                    <i class="bi bi-key-fill"></i> Confirmar Contraseña
                                </label>
                                <div class="input-icon">
                                    <i class="bi bi-key-fill"></i>
                                </div>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                       placeholder="Repite tu nueva contraseña">
                                <span class="password-toggle" id="confirmPasswordToggle" style="cursor:pointer;">
                                    <i class="bi bi-eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group text-end">
                        <button type="submit" class="btn-profile btn-update">
                            <i class="bi bi-check-circle"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include PARTIALS_DIR . '/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        const profileCard = document.querySelector('.profile-card');
        profileCard.style.opacity = '0';
        profileCard.style.transform = 'translateY(20px)';
        setTimeout(() => {
            profileCard.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            profileCard.style.opacity = '1';
            profileCard.style.transform = 'translateY(0)';
        }, 300);

        
        function setupPasswordToggle(inputId, toggleId) {
            const passwordInput = document.getElementById(inputId);
            const passwordToggle = document.getElementById(toggleId);
            passwordToggle.addEventListener('click', () => {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    passwordToggle.innerHTML = '<i class="bi bi-eye-slash"></i>';
                } else {
                    passwordInput.type = 'password';
                    passwordToggle.innerHTML = '<i class="bi bi-eye"></i>';
                }
            });
        }
        setupPasswordToggle('current_password', 'currentPasswordToggle');
        setupPasswordToggle('new_password', 'newPasswordToggle');
        setupPasswordToggle('confirm_password', 'confirmPasswordToggle');

        
        const form = document.getElementById('profileForm');
        const currentPassword = document.getElementById('current_password');
        const newPassword = document.getElementById('new_password');
        const confirmPassword = document.getElementById('confirm_password');

        form.addEventListener('submit', function(event) {
            
            if (
                currentPassword.value !== '' ||
                newPassword.value !== '' ||
                confirmPassword.value !== ''
            ) {
                if (newPassword.value.length < 6) {
                    alert("La nueva contraseña debe tener al menos 6 caracteres");
                    newPassword.focus();
                    event.preventDefault();
                    return;
                }
                if (newPassword.value !== confirmPassword.value) {
                    alert("Las contraseñas no coinciden");
                    confirmPassword.focus();
                    event.preventDefault();
                    return;
                }
                if (currentPassword.value === '') {
                    alert("Debes ingresar tu contraseña actual para cambiar la contraseña");
                    currentPassword.focus();
                    event.preventDefault();
                    return;
                }
            }
        });

        
        const buttons = document.querySelectorAll('.btn-profile');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', () => button.style.transform = 'translateY(-3px)');
            button.addEventListener('mouseleave', () => button.style.transform = 'translateY(0)');
        });
    });
</script>
