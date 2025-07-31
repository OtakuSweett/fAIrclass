<?php
defined('SITE_NAME') or define('SITE_NAME', 'fAIrclass');
defined('BASE_URL') or define('BASE_URL', '/');
defined('ASSETS_URL') or define('ASSETS_URL', '/assets');
?>

<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= htmlspecialchars($title ?? SITE_NAME, ENT_QUOTES, 'UTF-8') ?></title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" />
    
    <style>
        :root {
           
            --color-primary: #a8d0e6;
            --color-secondary: #f8b7d8;
            --color-accent: #f76c6c;
            --color-light: #f9f7f7;
            --color-dark: #374785;
            --color-text: #25274d;
            --color-success: #88d8b0;
            
           
            --border-radius: 12px;
            --box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            --transition: all 0.3s ease;
        }

        [data-theme="dark"] {
            --color-primary: #2a4365;
            --color-secondary: #553c9a;
            --color-accent: #e53e3e;
            --color-light: #1a202c;
            --color-dark: #e2e8f0;
            --color-text: #e2e8f0;
            --color-success: #38a169;
        }

        body {
            background-color: var(--color-light);
            color: var(--color-text);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: var(--transition);
        }
        
       
        .index-header {
            background: linear-gradient(135deg, rgba(168, 208, 230, 0.9), rgba(248, 183, 216, 0.8));
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: var(--transition);
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        
        [data-theme="dark"] .index-header {
            background: linear-gradient(135deg, rgba(42, 67, 101, 0.9), rgba(85, 60, 154, 0.8));
        }
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .logo {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.8rem;
            box-shadow: var(--box-shadow);
        }
        
        .logo-text {
            font-weight: 800;
            font-size: 1.8rem;
            color: var(--color-dark);
            letter-spacing: -0.5px;
        }
        
        .logo-text span {
            color: var(--color-secondary);
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        
        .nav-link {
            color: var(--color-dark);
            font-weight: 600;
            text-decoration: none;
            position: relative;
            transition: var(--transition);
            padding: 0.5rem 0;
        }
        
        .nav-link:hover {
            color: var(--color-secondary);
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 3px;
            background: var(--color-secondary);
            border-radius: 2px;
            transition: var(--transition);
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        .auth-buttons {
            display: flex;
            gap: 1rem;
        }
        
        .btn-auth {
            padding: 0.7rem 1.8rem;
            border-radius: 50px;
            font-weight: 600;
            transition: var(--transition);
            border: 2px solid transparent;
        }
        
        .btn-login {
            background: transparent;
            color: var(--color-dark);
            border-color: var(--color-dark);
        }
        
        .btn-login:hover {
            background: rgba(255,255,255,0.1);
            transform: translateY(-3px);
        }
        
        .btn-register {
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
            color: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        
        .theme-toggle {
            background: rgba(255,255,255,0.2);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-dark);
            transition: var(--transition);
            cursor: pointer;
        }
        
        .theme-toggle:hover {
            background: rgba(255,255,255,0.3);
            transform: rotate(15deg);
        }
        
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.8rem;
            color: var(--color-dark);
            cursor: pointer;
        }
        
       
        @media (max-width: 992px) {
            .nav-links {
                position: fixed;
                top: 80px;
                left: 0;
                right: 0;
                background: linear-gradient(135deg, rgba(168, 208, 230, 0.95), rgba(248, 183, 216, 0.9));
                backdrop-filter: blur(10px);
                flex-direction: column;
                padding: 2rem;
                gap: 1.5rem;
                clip-path: polygon(0 0, 100% 0, 100% 0, 0 0);
                transition: clip-path 0.5s ease;
            }
            
            [data-theme="dark"] .nav-links {
                background: linear-gradient(135deg, rgba(42, 67, 101, 0.95), rgba(85, 60, 154, 0.9));
            }
            
            .nav-links.active {
                clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
            }
            
            .mobile-menu-btn {
                display: block;
            }
            
            .auth-buttons {
                flex-direction: column;
                width: 100%;
            }
            
            .btn-auth {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header especial para página principal -->
    <header class="index-header">
        <div class="header-container">
            <div class="logo-container">
                <div class="logo">fA</div>
                <div class="logo-text">fAIr<span>class</span></div>
            </div>
            
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <i class="bi bi-list"></i>
            </button>
            
            <div class="nav-links" id="navLinks">
                <a href="#" class="nav-link">Inicio</a>
                
                <div class="auth-buttons">
                    <a href="index.php?action=login" class="btn-auth btn-login">
                        <i class="bi bi-box-arrow-in-right"></i> Ingresar
                    </a>
                    <a href="index.php?action=register" class="btn-auth btn-register">
                        <i class="bi bi-person-plus"></i> Registrarse
                    </a>
                </div>
                
                <button class="theme-toggle" id="themeToggle">
                    <i class="bi bi-sun"></i>
                </button>
            </div>
        </div>
    </header>
    
    <!-- Script para manejar el tema y menú móvil -->
    <script>
        
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('themeToggle');
            const htmlElement = document.documentElement;
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const navLinks = document.getElementById('navLinks');
            
            
            const savedTheme = getCookie('theme');
            if (savedTheme) {
                htmlElement.setAttribute('data-theme', savedTheme);
                updateThemeIcon(savedTheme);
            }
            
            
            themeToggle.addEventListener('click', function() {
                const currentTheme = htmlElement.getAttribute('data-theme');
                const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                
                htmlElement.setAttribute('data-theme', newTheme);
                updateThemeIcon(newTheme);
                
                
                setCookie('theme', newTheme, 30);
            });
            
            
            function updateThemeIcon(theme) {
                const icon = themeToggle.querySelector('i');
                if (theme === 'dark') {
                    icon.classList.remove('bi-moon');
                    icon.classList.add('bi-sun');
                } else {
                    icon.classList.remove('bi-sun');
                    icon.classList.add('bi-moon');
                }
            }
            
            
            mobileMenuBtn.addEventListener('click', function() {
                navLinks.classList.toggle('active');
            });
            
            
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    navLinks.classList.remove('active');
                });
            });
            
            
            function setCookie(name, value, days) {
                let expires = "";
                if (days) {
                    const date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie = name + "=" + (value || "") + expires + "; path=/";
            }
            
            function getCookie(name) {
                const nameEQ = name + "=";
                const ca = document.cookie.split(';');
                for(let i=0; i < ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                    if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
                }
                return null;
            }
        });
    </script>