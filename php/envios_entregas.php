<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$total_carrito = !empty($_SESSION['carrito']) ? array_sum($_SESSION['carrito']) : 0;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCenter - Envíos y Entregas</title>
    <link rel="stylesheet" href="../css/estil.css">
    <style>
        .shipping-container {
            max-width: 1200px;
            margin: 30px auto 60px;
            padding: 0 20px;
        }

        .shipping-hero {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            color: #ffffff;
            border-radius: var(--radius-lg);
            padding: 40px 30px;
            text-align: center;
            margin-bottom: 40px;
            box-shadow: var(--shadow-sm);
        }

        .shipping-hero h1 {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .shipping-hero p {
            color: #cbd5e1;
            font-size: 1.05rem;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Rejilla de tarjetas informativas */
        .shipping-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
            margin-bottom: 50px;
        }

        .shipping-card {
            background: #ffffff;
            border: 1px solid var(--gray-border);
            border-radius: var(--radius-md);
            padding: 25px;
            text-align: center;
            box-shadow: var(--shadow-sm);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .shipping-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            border-color: var(--primary-color);
        }

        .shipping-card-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            display: inline-block;
        }

        .shipping-card h3 {
            font-size: 1.15rem;
            color: var(--dark-color);
            margin-bottom: 10px;
            font-weight: 700;
        }

        .shipping-card p {
            font-size: 0.9rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        /* Sección detallada de políticas */
        .shipping-details {
            background: #ffffff;
            border: 1px solid var(--gray-border);
            border-radius: var(--radius-md);
            padding: 35px;
            box-shadow: var(--shadow-sm);
        }

        .shipping-details h2 {
            font-size: 1.4rem;
            color: var(--dark-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--gray-border);
            font-weight: 700;
        }

        .detail-item {
            margin-bottom: 25px;
        }

        .detail-item:last-child {
            margin-bottom: 0;
        }

        .detail-item h4 {
            font-size: 1.05rem;
            color: var(--primary-color);
            margin-bottom: 8px;
            font-weight: 600;
        }

        .detail-item p {
            font-size: 0.95rem;
            color: var(--text-main);
            line-height: 1.6;
        }

        .highlight-box {
            background: #fff3f0;
            border-left: 4px solid var(--primary-color);
            padding: 15px 20px;
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
            margin-top: 15px;
        }

        .highlight-box p {
            margin: 0;
            color: var(--dark-color);
            font-size: 0.9rem;
            font-weight: 500;
        }
    </style>
</head>

<body>

    <!-- Barra Superior -->
    <div class="top-bar">
        <span>🚚 Envío gratis en compras mayores a $500 | 10% de descuento con el código: <strong>PETNEW</strong></span>
    </div>

    <!-- Encabezado Principal -->
    <header class="site-header">
        <div class="header-container">
            <a href="../Lay-Proy.php" class="logo-container">
                <span class="logo-icon">🐾</span>
                <span class="site-title">PetCenter</span>
            </a>

            <!-- Buscador -->
            <div class="search-container">
                <form action="busquedas.php" method="GET" class="search-form">
                    <input type="text" name="busqueda" id="input-busqueda"
                        placeholder="Buscar productos para tus mascotas..." autocomplete="off">
                    <button type="button" id="btn-limpiar" class="btn-clear">&times;</button>
                    <button type="submit" class="btn-search">🔍</button>
                </form>
                <div id="box-sugerencias" class="sugerencias-box hidden">
                    <div class="sugerencias-header">SUGERENCIAS</div>
                    <ul id="lista-sugerencias"></ul>
                </div>
            </div>

            <!-- Acciones -->
            <div class="header-actions">
                <a href="Sesion.php" class="action-btn">
                    <span class="icon">👤</span>
                    <span class="label">Mi Cuenta</span>
                </a>
                <a href="contacto2.php" class="action-btn">
                    <span class="icon">📞</span>
                    <span class="label">Ayuda</span>
                </a>
                <a href="ver_carrito.php" class="action-btn cart-btn">
                    <span class="icon">🛒</span>
                    <span id="num_cart" class="cart-badge"><?php echo $total_carrito; ?></span>
                </a>
            </div>
        </div>

        <!-- Menú de Navegación -->
        <nav class="main-nav">
            <ul>
                <li><a href="../Lay-Proy.php">Inicio</a></li>
                <li><a href="perros.php">Perros</a></li>
                <li><a href="gatos.php">Gatos</a></li>
                <li><a href="peces.php">Peces</a></li>
                <li><a href="aves.php">Aves</a></li>
                <li><a href="../Lay-Proy.php#ofertas" class="nav-highlight">Ofertas 🏷️</a></li>
            </ul>
        </nav>
    </header>

    <!-- Contenido Principal -->
    <main class="shipping-container">

        <!-- Migas de Pan -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../Lay-Proy.php">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>Envíos y Entregas</span></li>
            </ol>
        </nav>

        <!-- Banner Principal -->
        <section class="shipping-hero">
            <h1>Información de Envíos y Entregas 🚚</h1>
            <p>Nos aseguramos de que los alimentos, accesorios y cuidados de tus mascotas lleguen rápido y seguros hasta
                la puerta de tu hogar.</p>
        </section>

        <!-- Tarjetas Destacadas -->
        <section class="shipping-grid">
            <div class="shipping-card">
                <span class="shipping-card-icon">🎁</span>
                <h3>Envío Gratis</h3>
                <p>En todas tus compras superiores a <strong>$500 MXN</strong> a cualquier parte de la República
                    Mexicana.</p>
            </div>
            <div class="shipping-card">
                <span class="shipping-card-icon">⚡</span>
                <h3>Entrega Rápida</h3>
                <p>Procesamos y enviamos tus paquetes en un lapso estimado de <strong>24 a 48 horas hábiles</strong>.
                </p>
            </div>
            <div class="shipping-card">
                <span class="shipping-card-icon">📍</span>
                <h3>Rastreo en Vivo</h3>
                <p>Recibirás un número de guía para monitorear el trayecto de tu paquete en todo momento.</p>
            </div>
            <div class="shipping-card">
                <span class="shipping-card-icon">🛡️</span>
                <h3>Empaque Protegido</h3>
                <p>Embalaje especial antiextravío y sellado seguro para alimentos y productos frágiles.</p>
            </div>
        </section>

        <!-- Detalles Generales -->
        <section class="shipping-details">
            <h2>Políticas de Envío</h2>

            <div class="detail-item">
                <h4>1. Tiempos de Procesamiento</h4>
                <p>Los pedidos realizados de lunes a viernes antes de las 14:00 hrs se entregan a la paquetería el mismo
                    día. Las órdenes recibidas en fin de semana o días festivos se procesarán al siguiente día hábil.
                </p>
            </div>

            <div class="detail-item">
                <h4>2. Costos de Envío</h4>
                <p>Para compras menores a $500 MXN, se aplicará una tarifa estándar de envío calculada al momento del
                    pago según la zona geográfica (tarifa promedio de $99 MXN en envío local y $149 MXN nacional).</p>
            </div>

            <div class="detail-item">
                <h4>3. Paqueterías Aliadas</h4>
                <p>Trabajamos con los mejores proveedores de logística como FedEx, DHL, Estafeta y nuestro servicio de
                    entrega rápida local PetCenter Express para garantizar entregas puntuales.</p>
            </div>

            <div class="detail-item">
                <h4>4. Intentos de Entrega</h4>
                <p>Las empresas de mensajería realizarán hasta 2 intentos de entrega en la dirección proporcionada. Si
                    no te encuentras en tu domicilio, dejarán una notificación o se pondrán en contacto para acordar la
                    recolección en sucursal.</p>
            </div>

            <div class="highlight-box">
                <p>💡 <strong>¿Tienes dudas con la entrega de tu pedido?</strong> Escríbenos directamente a través de
                    nuestra sección de <a href="contacto2.php"
                        style="color: var(--primary-color); font-weight: bold;">Atención al Cliente</a> o vía WhatsApp
                    con tu número de orden.</p>
            </div>
        </section>

    </main>

    <!-- Pie de Página -->
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-col">
                <div class="logo-container">
                    <span class="logo-icon">🐾</span>
                    <span class="site-title">PetCenter</span>
                </div>
                <p>Tu tienda de confianza para el cuidado, estilo y bienestar de tus mascotas.</p>
            </div>
            <div class="footer-col">
                <h4>Enlaces Rápidos</h4>
                <ul>
                    <li><a href="sobrenosotros.php">Sobre Nosotros</a></li>
                    <li><a href="preguntas.php">Preguntas Frecuentes</a></li>
                    <li><a href="#">Términos y Condiciones</a></li>
                    <li><a href="#">Política de Privacidad</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Atención al Cliente</h4>
                <ul>
                    <li><a href="contactanos.php">Contacto</a></li>
                    <li><a href="#">Seguimiento de Pedido</a></li>
                    <li><a href="envios_entregas.php">Envíos y Entregas</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 PetCenter Store. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="../js/scriptbuscarsugerencias.js"></script>
    <script src="../js/carrito_global.js"></script>
</body>

</html>