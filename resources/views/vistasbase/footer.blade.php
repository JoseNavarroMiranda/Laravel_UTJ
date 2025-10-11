<footer class="vb-footer">
    <div class="vb-footer-main container">
        <div class="vb-footer-col">
            <div class="vb-brand">LineaBlanca</div>
            <p class="muted">Electrodomésticos y línea blanca con envío rápido y garantía.</p>
        </div>

        <div class="vb-footer-col">
            <div class="vb-col-title">Tienda</div>
            <a href="#">Inicio</a>
            <a href="#">Categorías</a>
            <a href="#">Ofertas</a>
            <a href="#">Novedades</a>
        </div>

        <div class="vb-footer-col">
            <div class="vb-col-title">Ayuda</div>
            <a href="#">Envíos</a>
            <a href="#">Devoluciones</a>
            <a href="#">Garantías</a>
            <a href="#">Soporte</a>
        </div>

        <div class="vb-footer-col">
            <div class="vb-col-title">Contacto</div>
            <div class="muted">Lun–Vie 9:00–18:00</div>
            <a href="mailto:soporte@lineablanca.test">soporte@lineablanca.test</a>
            <a href="tel:+5215555555555">+52 1 55 5555 5555</a>
            <a href="#">WhatsApp</a>
        </div>
    </div>

    <div class="vb-footer-bottom">
        <div class="container vb-footer-bottom-inner">
            <div class="muted">© {{ date('Y') }} LineaBlanca. Todos los derechos reservados.</div>
            <div class="vb-bottom-links">
                <a href="#">Términos</a>
                <span>·</span>
                <a href="#">Privacidad</a>
                <span>·</span>
                <a href="#">Cookies</a>
            </div>
        </div>
    </div>

    <style>
        .vb-footer{ margin-top: 48px; border-top: 1px solid #1f2937; background: #0b1220; }
        .vb-footer-main{ display:grid; gap:24px; padding: 32px 24px; grid-template-columns: 2fr 1fr 1fr 1fr; }
        @media (max-width: 900px){ .vb-footer-main{ grid-template-columns: 1fr 1fr; } }
        @media (max-width: 560px){ .vb-footer-main{ grid-template-columns: 1fr; } }
        .vb-footer-col{ display:flex; flex-direction:column; gap:10px; }
        .vb-brand{ font-weight: 800; font-size: 18px; letter-spacing: .4px; }
        .vb-col-title{ color:#e5e7eb; font-weight:700; font-size:14px; text-transform:uppercase; letter-spacing:.6px; margin-bottom:4px; }
        .vb-footer a{ color:#9ca3af; text-decoration:none; font-size:14px; }
        .vb-footer a:hover{ color:#ffffff; }
        .vb-footer-bottom{ border-top: 1px solid #1f2937; background: #0b1220; }
        .vb-footer-bottom-inner{ display:flex; align-items:center; justify-content:space-between; gap:12px; padding: 16px 24px; }
        .vb-bottom-links{ display:flex; align-items:center; gap:10px; }
    </style>
</footer>
