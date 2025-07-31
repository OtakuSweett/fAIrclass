<?php 
$pageTitle = "Términos de Uso - fAIrclass";
include PARTIALS_DIR . '/headerindex.php';
include PARTIALS_DIR . '/flash.php';
?>

<style>
   
    .terms-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }
    
    .terms-content {
        background-color: var(--color-light);
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 3rem;
        margin-bottom: 3rem;
    }
    
    .terms-content h1 {
        color: var(--color-dark);
        margin-bottom: 2rem;
        text-align: center;
        font-weight: 700;
    }
    
    .terms-content h2 {
        color: var(--color-primary);
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }
    
    .terms-content p {
        margin-bottom: 1rem;
        line-height: 1.8;
        color: var(--color-text);
    }
    
    .terms-content ul {
        padding-left: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .terms-content ul li {
        margin-bottom: 0.5rem;
        line-height: 1.6;
    }
    
    .terms-content .last-updated {
        text-align: right;
        font-style: italic;
        opacity: 0.8;
        margin-top: 3rem;
    }
    
    @media (max-width: 768px) {
        .terms-content {
            padding: 1.5rem;
        }
    }
</style>

<main class="terms-container">
    <div class="terms-content">
        <h1>Términos y Condiciones de Uso</h1>
        
        <p><strong>Última actualización:</strong> <?= date('d/m/Y') ?></p>
        
        <p>Bienvenido a fAIrclass. Estos términos y condiciones describen las reglas y regulaciones para el uso del sitio web de fAIrclass.</p>
        
        <p>Al acceder a este sitio web, asumimos que aceptas estos términos y condiciones. No continúes usando fAIrclass si no estás de acuerdo con todos los términos y condiciones establecidos en esta página.</p>
        
        <h2>Licencia</h2>
        <p>A menos que se indique lo contrario, fAIrclass y/o sus licenciantes poseen los derechos de propiedad intelectual de todo el material en fAIrclass. Todos los derechos de propiedad intelectual son reservados. Puedes acceder desde fAIrclass para tu uso personal sujeto a las restricciones establecidas en estos términos y condiciones.</p>
        
        <h2>No debes:</h2>
        <ul>
            <li>Copiar o redistribuir material de fAIrclass</li>
            <li>Vender, alquilar o sublicenciar material de fAIrclass</li>
            <li>Reproducir, duplicar o copiar material de fAIrclass</li>
            <li>Redistribuir contenido de fAIrclass</li>
        </ul>
        
        <h2>Responsabilidad del contenido</h2>
        <p>No seremos responsables de ningún contenido que aparezca en su sitio web. Usted acepta protegernos y defendernos contra todas las reclamaciones que se presenten en su sitio web. Ningún enlace(s) debe aparecer en ningún sitio web que pueda interpretarse como difamatorio, obsceno o criminal, o que infrinja, de otra manera viole o defienda la infracción u otra violación de los derechos de terceros.</p>
        
        <h2>Reserva de derechos</h2>
        <p>Nos reservamos el derecho de solicitar que elimines todos los enlaces o cualquier enlace en particular a nuestro sitio web. Usted aprueba eliminar inmediatamente todos los enlaces a nuestro sitio web cuando se lo solicite. También nos reservamos el derecho de modificar estos términos y condiciones y su política de enlaces en cualquier momento. Al vincular continuamente a nuestro sitio web, acepta estar vinculado y seguir estos términos y condiciones de vinculación.</p>
        
        <h2>Eliminación de enlaces de nuestro sitio web</h2>
        <p>Si encuentra algún enlace en nuestro sitio web que sea ofensivo por cualquier motivo, puede contactarnos e informarnos en cualquier momento. Consideraremos las solicitudes para eliminar enlaces, pero no estamos obligados a hacerlo ni a responderle directamente.</p>
        
        <h2>Exención de responsabilidad</h2>
        <p>En la medida máxima permitida por la ley aplicable, excluimos todas las representaciones, garantías y condiciones relacionadas con nuestro sitio web y el uso de este sitio web. Nada en este descargo de responsabilidad:</p>
        <ul>
            <li>limitará o excluirá nuestra o su responsabilidad por muerte o lesiones personales;</li>
            <li>limitará o excluirá nuestra o su responsabilidad por fraude o tergiversación fraudulenta;</li>
            <li>limitará cualquiera de nuestras o sus responsabilidades de cualquier manera que no esté permitida por la ley aplicable; o</li>
            <li>excluirá cualquiera de nuestras o sus responsabilidades que no puedan estar excluidas según la ley aplicable.</li>
        </ul>
        
        <h2>Cambios a estos Términos</h2>
        <p>Podemos actualizar nuestros Términos y Condiciones de vez en cuando. Le notificaremos cualquier cambio publicando los nuevos Términos y Condiciones en esta página. Se le recomienda revisar estos Términos y Condiciones periódicamente para cualquier cambio.</p>
        
        <h2>Contáctenos</h2>
        <p>Si tiene alguna pregunta sobre estos Términos y Condiciones, puede contactarnos:</p>
        <ul>
            <li>Por correo electrónico: info@fairclass.edu</li>
        </ul>
        
        <div class="last-updated">
            <p>Estos términos son efectivos a partir del <?= date('d/m/Y') ?></p>
        </div>
    </div>
</main>

<?php include PARTIALS_DIR . '/footer.php'; ?>