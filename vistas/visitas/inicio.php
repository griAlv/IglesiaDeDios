<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . "/iglesia/controladores/controlador_evento.php");
$controlador = new controlador_evento();
$eventosRecientes = $controlador->listarEventosRecientes(3);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iglesia de Dios El Salvador</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="/iglesia/vistas/css/Estilos.css">
    
    <style>
        body {
            font-family: 'Coolvetica', sans-serif;
            background-color: #f9fafb;
            color: #1f2937;
            padding-top: 5rem;
        }

        /* Sección Hero - Sobre Nosotros */
        #sobre-nosotros {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .hero-bg-wrapper {
            position: absolute;
            top: -4rem;
            left: 0;
            width: 100%;
            height: 100vh;
            overflow: hidden;
            z-index: -1;
        }

        .hero-bg-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.75);
        }

        .hero-title {
            color: white;
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
        }

        .hero-text {
            color: white;
            font-size: 1.25rem;
            line-height: 1.6;
        }

        .mission-vision h2 {
            color: white;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .mission-vision p {
            color: #e5e7eb;
            margin-bottom: 1.5rem;
        }

        .btn-historia {
            display: inline-block;
            background-color: #f9fafb;
            color: black;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .btn-historia:hover {
            background-color: #4b5563;
            color: white;
        }

        /* Carrusel Ministerios */
        .ministerios-section {
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 1rem;
        }

        .ministerios-section h1 {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2.5rem;
            font-weight: bold;
        }

        #myCarousel .carousel-item img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-text {
                font-size: 1rem;
            }
            .mission-vision h2 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>

    <!-- SECCIÓN SOBRE NOSOTROS -->
    <section id="sobre-nosotros">
        <!-- Imagen de fondo -->
        <div class="hero-bg-wrapper">
            <img src="vistas/Imagenes/ImagenPrincipal.jpg" alt="Iglesia de Dios">
        </div>

        <!-- Contenido del texto -->
        <div class="container" style="position: relative; z-index: 1;">
            <div class="row g-5 align-items-center">
                
                <!-- Columna izquierda -->
                <div class="col-lg-6">
                    <h1 class="hero-title">
                        Iglesia de Dios en El Salvador
                    </h1>
                    <p class="hero-text">
                        Somos la Iglesia de Dios, fundada por nuestro Señor Jesucristo en el año 26 de la Era Cristiana. 
                        Comisionando primeramente a 12 apóstoles, a quienes se les encomienda la misión de predicar el evangelio 
                        a toda criatura, comenzando desde Jerusalén, Judea, Samaria y hasta lo último de la tierra. Como organización 
                        cristiana nos esforzamos por mantener la observancia de los Mandamientos de nuestro Dios y el Testimonio 
                        de Jesús, con una doctrina que se constituye en la columna y apoyo de la verdad.
                    </p>
                </div>

                <!-- Columna derecha -->
                <div class="col-lg-6 mission-vision">
                    <div class="p-4 rounded-3">
                        <h2>Misión</h2>
                        <p>
                            Enseñar la doctrina que practicaron los apóstoles de Jesucristo en Jerusalem, observando orden y decencia, todo basado en las Sagradas Escrituras, con el fin de librar al hombre de pecado para que, con fe en Cristo Jesús, pueda ser útil a la humanidad y finalmente obtener la vida eterna.
                        </p>

                        <h2>Visión</h2>
                        <p>
                            Ser la Iglesia pura y sin mancha que saldrá al encuentro del Señor Jesucristo en su Segunda Venida, con el fin de vivir mil años con él, y después una eternidad con el Padre Celestial.
                        </p>
                        <a href="vistas/visitas/historia.php" class="btn-historia">
                            Historia de la iglesia
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================================================
            Sección Nuestros Ministerios
    ===========================================================================-->
    
    <div class="ministerios-section">
        <h1>Más de nosotros!</h1>  
        <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
            <!-- Indicators -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2"></button>
            </div>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="vistas/Imagenes/es1.png" class="d-block w-100" alt="Ministerio 1">
                </div>

                <div class="carousel-item">
                    <img src="vistas/Imagenes/es2.png" class="d-block w-100" alt="Ministerio 2">
                </div>
            
                <div class="carousel-item">
                    <img src="vistas/Imagenes/es3.png" class="d-block w-100" alt="Ministerio 3">
                </div>
            </div>

            <!-- Left and right controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    </div>

    <!-- ========================================================================
            Sección Noticias
    ==========================================================================-->

    <section id="noticias" class="noticias">
        <div class="noticias-header">
            <h2>Noticias</h2>
            <a href="vistas/visitas/noticias.php" class="btn-articulos">Más noticias</a>
        </div>

        <div class="noticias-contenido">
            <!-- Noticia principal -->
            <div class="noticia-principal">
                <?php if (!empty($eventosRecientes)) { 
                    $primerEvento = $eventosRecientes[0]; ?>
                <img src="/iglesia/vistas/admin/<?php echo $primerEvento['foto']; ?>" alt="<?php echo htmlspecialchars($primerEvento['titulo']); ?>">
                <div class="noticia-info">
                    <span class="categoria">Iglesia de Dios Central</span>
                    <h3><?php echo htmlspecialchars($primerEvento['titulo']); ?></h3>
                    <p class="fecha"><?php echo date('d/m/Y', strtotime($primerEvento['fecha'])); ?></p>
                </div>
                <?php } ?>
            </div>

            <!-- Noticias secundarias -->
            <div class="noticias-secundarias">
                <?php 
                $categorias = ['Distrito 1', 'ID CENTRAL', 'Nivel Nacional'];
                for ($i = 1; $i < count($eventosRecientes) && $i <= 2; $i++) { 
                    $evento = $eventosRecientes[$i];
                ?>
                <div class="noticia-secundaria">
                    <img src="/iglesia/vistas/admin/<?php echo $evento['foto']; ?>" alt="Noticia secundaria <?php echo $i; ?>">
                    <div>
                        <span class="categoria"><?php echo $categorias[$i-1]; ?></span>
                        <h4><?php echo htmlspecialchars($evento['titulo']); ?></h4>
                        <p class="fecha"><?php echo date('d/m/Y', strtotime($evento['fecha'])); ?></p>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>  

    <!-- ========================================================================
               Sección Escuelas Sabáticas
    ==========================================================================-->

    <section id="escuelas" class="Escuelas">
        <div class="Escuelas-header">
            <h2>Escuelas Sabáticas</h2>
            <a href="EscuelasSabaticas.php" class="btn-escuelas">Más Escuelas</a>
        </div>

        <div class="Escuelas-grid">
            <div class="Escuela cursor-pointer" style="background-image: url('vistas/Imagenes/escuela1.png');"
                 onclick="window.open('vistas/EscuelasPDF/escuelageneral032025.pdf', '_blank')">
                <div class="overlay">
                    <h3>Escuela General</h3>
                </div>
            </div>

            <div class="Escuela cursor-pointer" style="background-image: url('vistas/Imagenes/escuela3.png');"
                 onclick="window.open('vistas/EscuelasPDF/escuelafemenil032025.pdf', '_blank')">
                <div class="overlay">
                    <h3>Escuela Femenil</h3>
                </div>
            </div>

            <div class="Escuela cursor-pointer" style="background-image: url('vistas/Imagenes/escuela2.png');"
                 onclick="window.open('vistas/EscuelasPDF/escuelajuvenil032025.pdf', '_blank')">
                <div class="overlay">
                    <h3>Escuela Juvenil</h3>
                </div>
            </div>

            <div class="Escuela cursor-pointer" style="background-image: url('vistas/Imagenes/infantil.png');"
                 onclick="window.open('vistas/EscuelasPDF/escuelainfantil012025.pdf', '_blank')">
                <div class="overlay">
                    <h3>Escuela infantil</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================================================
            Sección Más de nosotros!
    ==========================================================================-->

    
    <div class="mas-header">
        <h2>Más de nosotros!</h2>
    </div>

    <div class="mas-section">

        <!-- Carrusel -->
        <div class="slider">
            <div class="slides">
                <div class="slide">
                        <img src="vistas/Imagenes/mas1.jpg" alt="Noticia 1">
                </div>
                <div class="slide">
                        <img src="vistas/Imagenes/mas2.jpg" alt="Noticia 2">
                </div>
                <div class="slide">
                        <img src="vistas/Imagenes/mas3.jpg" alt="Noticia 3">
                </div>
                <div class="slide">
                        <img src="vistas/Imagenes/mas4.jpg" alt="Noticia 4">
                </div>
                <div class="slide">
                        <img src="vistas/Imagenes/mas5.jpg" alt="Noticia 5">
                </div>
                <div class="slide">
                        <img src="vistas/Imagenes/mas6.jpg" alt="Noticia 6">
                </div>
                <div class="slide">
                        <img src="vistas/Imagenes/mas7.jpg" alt="Noticia 7">
                </div>
                <div class="slide">
                        <img src="vistas/Imagenes/mas8.jpg" alt="Noticia 8">
                </div>
                 <button class="prevo">&#10093;</button>
                <button class="nexto">&#10094;</button>
            </div>

            <!-- Flechas -->
            <button class="prev">&#10094;</button>
            <button class="next">&#10095;</button>

            <!-- Indicadores -->
            <div class="indicators">
                <span class="dot active"></span>
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>
        </div>

        <!-- Artículos recientes -->
        <aside class="recent-articles">
            <div class="Textmas"></div>
        </aside>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script personalizado -->
    <script src="vistas/js/script.js"></script>
</body>
</html>