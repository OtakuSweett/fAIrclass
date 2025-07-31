<?php 
$pageTitle = "Política de Privacidad - fAIrclass";
include PARTIALS_DIR . '/headerindex.php';
include PARTIALS_DIR . '/flash.php';
?>

<style>
   
    .privacy-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }
    
    .privacy-content {
        background-color: var(--color-light);
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 3rem;
        margin-bottom: 3rem;
    }
    
    .privacy-content h1 {
        color: var(--color-dark);
        margin-bottom: 2rem;
        text-align: center;
        font-weight: 700;
    }
    
    .privacy-content h2 {
        color: var(--color-primary);
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }
    
    .privacy-content p {
        margin-bottom: 1rem;
        line-height: 1.8;
        color: var(--color-text);
    }
    
    .privacy-content ul {
        padding-left: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .privacy-content ul li {
        margin-bottom: 0.5rem;
        line-height: 1.6;
    }
    
    .privacy-content .last-updated {
        text-align: right;
        font-style: italic;
        opacity: 0.8;
        margin-top: 3rem;
    }
    
    @media (max-width: 768px) {
        .privacy-content {
            padding: 1.5rem;
        }
    }
</style>

<main class="privacy-container">
    <div class="privacy-content">
        <h1>Política de Privacidad</h1>
        
        <p><strong>Última actualización:</strong> <?= date('d/m/Y') ?></p>
        
        <p>En fAIrclass, una de nuestras principales prioridades es la privacidad de nuestros usuarios. Esta Política de Privacidad documenta los tipos de información que fAIrclass recopila y registra, y cómo la utilizamos.</p>
        
        <h2>Información que recopilamos</h2>
        <p>Recopilamos información cuando te registras en nuestra plataforma, inicias sesión, utilizas nuestros servicios o interactúas de otras formas con fAIrclass. La información personal que recopilamos puede incluir:</p>
        <ul>
            <li>Nombre completo</li>
            <li>Dirección de correo electrónico</li>
            <li>Institución educativa</li>
            <li>Información de perfil (como foto de perfil, biografía)</li>
            <li>Datos de actividad en la plataforma (como cursos, tareas, interacciones)</li>
        </ul>
        
        <h2>Cómo utilizamos su información</h2>
        <p>Utilizamos la información que recopilamos de varias maneras, entre las que se incluyen:</p>
        <ul>
            <li>Proporcionar, operar y mantener nuestra plataforma</li>
            <li>Mejorar, personalizar y expandir nuestra plataforma</li>
            <li>Comprender y analizar cómo utiliza nuestra plataforma</li>
            <li>Desarrollar nuevos productos, servicios, características y funcionalidades</li>
            <li>Comunicarnos con usted, directamente o a través de socios, para servicio al cliente, actualizaciones y otra información relacionada con la plataforma</li>
            <li>Enviar correos electrónicos</li>
            <li>Encontrar y prevenir fraudes</li>
        </ul>
        
        <h2>Seguridad de los datos</h2>
        <p>Valoramos su confianza al proporcionarnos su información personal, por lo que nos esforzamos por utilizar medios comercialmente aceptables para protegerla. Sin embargo, recuerde que ningún método de transmisión por Internet o método de almacenamiento electrónico es 100% seguro y confiable, y no podemos garantizar su seguridad absoluta.</p>
        
        <h2>Enlaces a otros sitios</h2>
        <p>Nuestra plataforma puede contener enlaces a otros sitios. Si hace clic en un enlace de un tercero, será dirigido a ese sitio. Tenga en cuenta que estos sitios externos no son operados por nosotros. Por lo tanto, le recomendamos encarecidamente que revise la Política de Privacidad de estos sitios. No tenemos control ni asumimos responsabilidad por el contenido, las políticas de privacidad o las prácticas de sitios o servicios de terceros.</p>
        
        <h2>Cambios a esta Política de Privacidad</h2>
        <p>Podemos actualizar nuestra Política de Privacidad de vez en cuando. Le notificaremos cualquier cambio publicando la nueva Política de Privacidad en esta página. Se le recomienda revisar esta Política de Privacidad periódicamente para cualquier cambio.</p>
        
        <h2>Contáctenos</h2>
        <p>Si tiene alguna pregunta o sugerencia sobre nuestra Política de Privacidad, no dude en ponerse en contacto con nosotros en <a href="mailto:info@fairclass.edu">info@fairclass.edu</a>.</p>
        
        <div class="last-updated">
            <p>Esta política es efectiva a partir del <?= date('d/m/Y') ?></p>
        </div>
    </div>
</main>

<?php include PARTIALS_DIR . '/footer.php'; ?>