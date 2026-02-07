

    <footer class="global-footer">
        <div class="footer-container">
            <div class="footer-grid">

                <div class="footer-column">
                    <div class="footer-logo-container">
                        <div class="logo">fA</div>
                        <div class="footer-logo-text">fAIr<span>class</span></div>
                    </div>
                    <p class="footer-description">
                        Plataforma educativa con detección inteligente de originalidad para una educación justa y transparente.
                    </p>
                    <div class="social-links">
                        <a href="https://facebook.com/GiancrackSan" class="social-link">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://x.com/OtakuSweett" class="social-link">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="https://instagram.com/sweettfm" class="social-link">
                            <i class="bi bi-instagram"></i>
                        </a>
                    </div>
                </div>
                
                
                <!-- Columna 3: Soporte -->
                <div class="footer-column">
                    <h4 class="footer-title">Soporte</h4>
                    <ul class="footer-links">
                        <li><a href="/privacy.php"><i class="bi bi-chevron-right"></i> Política de Privacidad</a></li>
                        <li><a href="/terms.php"><i class="bi bi-chevron-right"></i> Términos y Condiciones</a></li>
                    </ul>
                </div>
                
                <!-- Columna 4: Contacto -->
                <div class="footer-column">
                    <h4 class="footer-title">Contacto</h4>
                    <ul class="footer-contact">
                        <li>
                            <i class="bi bi-geo-alt"></i>
                            <span>Calle Tupu 123, Ciudad del Permatrago</span>
                        </li>
                        <li>
                            <i class="bi bi-telephone"></i>
                            <span>+1 (123) 456-7890</span>
                        </li>
                        <li>
                            <i class="bi bi-envelope"></i>
                            <span>redacted@devsweett.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="copyright">
                    &copy; <?= date('Y') ?> fAIrclass. Todos los derechos reservados.
                </div>
                <div class="footer-links-bottom">
                    <a href="/privacy.php">Política de Privacidad</a>
                    <a href="/terms.php">Términos de Uso</a>
                </div>
            </div>
                <?php if (env('CF_TURNSTILE_SITEKEY')): ?>
                    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
                <?php endif; ?>
        </div>
    </footer>
    
    <style>
       
        .global-footer {
            background: linear-gradient(135deg, rgba(168, 208, 230, 0.95), rgba(248, 183, 216, 0.9));
            backdrop-filter: blur(10px);
            color: var(--color-dark);
            padding: 4rem 0 0;
            position: relative;
            overflow: hidden;
            border-top: 1px solid rgba(255,255,255,0.2);
            margin-top: 4rem;
        }
        
        [data-theme="dark"] .global-footer {
            background: linear-gradient(135deg, rgba(42, 67, 101, 0.95), rgba(85, 60, 154, 0.9));
            border-top: 1px solid rgba(0,0,0,0.2);
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-bottom: 3rem;
        }
        
        .footer-column {
            position: relative;
            z-index: 2;
        }
        
        .footer-logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .footer-logo-text {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--color-dark);
        }
        
        .footer-logo-text span {
            color: var(--color-secondary);
        }
        
        .footer-description {
            color: var(--color-dark);
            opacity: 0.9;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            line-height: 1.6;
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
        }
        
        .social-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-dark);
            transition: var(--transition);
            font-size: 1.2rem;
        }
        
        .social-link:hover {
            background: var(--color-secondary);
            color: white;
            transform: translateY(-5px);
        }
        
        .footer-title {
            color: var(--color-dark);
            font-weight: 700;
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }
        
        .footer-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--color-secondary);
            border-radius: 2px;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.8rem;
        }
        
        .footer-links a {
            color: var(--color-dark);
            text-decoration: none;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            opacity: 0.9;
        }
        
        .footer-links a:hover {
            color: var(--color-secondary);
            opacity: 1;
            transform: translateX(5px);
        }
        
        .footer-links a i {
            color: var(--color-secondary);
            transition: var(--transition);
        }
        
        .footer-links a:hover i {
            transform: rotate(90deg);
        }
        
        .footer-contact {
            list-style: none;
            padding: 0;
            margin: 0 0 2rem;
        }
        
        .footer-contact li {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.2rem;
        }
        
        .footer-contact i {
            color: var(--color-secondary);
            font-size: 1.2rem;
            margin-top: 3px;
        }
        
        .footer-contact span {
            flex: 1;
            opacity: 0.9;
        }
        
        .newsletter-title {
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--color-dark);
        }
        
        .input-group {
            display: flex;
            border-radius: 50px;
            overflow: hidden;
            box-shadow: var(--box-shadow);
        }
        
        .form-control {
            flex: 1;
            border: none;
            padding: 0.8rem 1.5rem;
            background: rgba(255,255,255,0.2);
            color: var(--color-dark);
        }
        
        .form-control::placeholder {
            color: var(--color-dark);
            opacity: 0.7;
        }
        
        .btn-newsletter {
            background: var(--color-secondary);
            color: white;
            border: none;
            padding: 0 1.5rem;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .btn-newsletter:hover {
            background: var(--color-accent);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.2);
            padding: 1.5rem 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            position: relative;
            z-index: 2;
        }
        
        [data-theme="dark"] .footer-bottom {
            border-top: 1px solid rgba(0,0,0,0.2);
        }
        
        .copyright {
            color: var(--color-dark);
            opacity: 0.8;
            font-size: 0.9rem;
        }
        
        .footer-links-bottom {
            display: flex;
            gap: 1.5rem;
        }
        
        .footer-links-bottom a {
            color: var(--color-dark);
            text-decoration: none;
            font-size: 0.9rem;
            transition: var(--transition);
            opacity: 0.8;
        }
        
        .footer-links-bottom a:hover {
            color: var(--color-secondary);
            opacity: 1;
        }
        
       
        .global-footer::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        
        .global-footer::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -50px;
            width: 150px;
            height: 150px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
        }
        
       
        @media (max-width: 768px) {
            .footer-grid {
                gap: 2rem;
            }
            
            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
            
            .footer-links-bottom {
                justify-content: center;
            }
        }
    </style>
</body>
</html>