<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . "/iglesia/controladores/controlador_evento.php");
$controlador = new controlador_evento();
$eventosRecientes = $controlador->listarEventosRecientes(3);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="/iglesia/vistas/css/Estilos.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iglesia de Dios El Salvador</title>


</head>
<body class="font-sans bg-gray-50 text-gray-800 pt-20">



    <section id="sobre-nosotros" class="relative">
        <!-- Imagen de fondo -->
        <div class="absolute inset-0 -top-16">
            <img src="vistas/Imagenes/ImagenPrincipal.jpg"
                 class="w-full h-screen object-cover brightness-75">
        </div>

        <!-- Contenido del texto -->
        <div class="relative container mx-auto h-screen flex flex-col justify-center px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

                <!-- Columna izquierda -->
                <div>
                    <h1 class="text-white text-5xl md:text-6xl font-bold mb-6 max-w-2xl">
                        Iglesia de Dios en El Salvador
                    </h1>
                    <p class="text-white text-lg md:text-xl max-w-2xl">
                        Somos la Iglesia de Dios, fundada por nuestro Señor Jesucristo en el año 26 de la Era Cristiana. 
                        Comisionando primeramente a 12 apóstoles, a quienes se les encomienda la misión de predicar el evangelio 
                        a toda criatura, comenzando desde Jerusalén, Judea, Samaria y hasta lo último de la tierra. Como organización 
                        cristiana nos esforzamos por mantener la observancia de los Mandamientos de nuestro Dios y el Testimonio 
                        de Jesús, con una doctrina que se constituye en la columna y apoyo de la verdad.
                    </p>
                </div>

                <!-- Columna derecha -->
                <div class=" p-6 rounded-2xl ">
                    <h2 class="text-white text-3xl font-semibold mb-4">Misión</h2>
                    <p class="text-gray-200 mb-6">
                        Enseñar la doctrina que practicaron los apóstoles de Jesucristo en Jerusalem, observando orden y decencia, todo basado en las Sagradas Escrituras, con el fin de librar al hombre de pecado para que, con fe en Cristo Jesús, pueda ser útil a la humanidad y finalmente obtener la vida eterna.
                    </p>

                    <h2 class="text-white text-3xl font-semibold mb-4">Visión</h2>
                    <p class="text-gray-200 mb-6">
                        Ser la Iglesia pura y sin mancha que saldrá al encuentro del Señor Jesucristo en su Segunda Venida, con el fin de vivir mil años con él, y después una eternidad con el Padre Celestial.
                    </p>
                    <a href="vistas/visitas/historia.php"
                       class="inline-block bg-gray-50 hover:bg-gray-600 text-black font-semibold px-6 py-3 rounded-lg shadow-lg transition">
                        Historia de la iglesia
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================================================
            Sección Nuestros Ministerios
    ===========================================================================-->
    
<div class="container">
  <h1>Más de nosotros!</h1>  
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
        <img src="vistas/Imagenes/es1.png" alt="Los Angeles" style="width:100%;">
      </div>

      <div class="item">
        <img src="vistas/Imagenes/es2.png" alt="Chicago" style="width:100%;">
      </div>
    
      <div class="item">
        <img src="vistas/Imagenes/es3.png" alt="New york" style="width:100%;">
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
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
                <!-- Para redireccionar con la escuela -->
                <div class="overlay">
                    <h3>Escuela General</h3>
                </div>
            </div>

            <div class="Escuela cursor-pointer" style="background-image: url('vistas/Imagenes/escuela3.png');"
                 onclick="window.open('vistas/EscuelasPDF/escuelafemenil032025.pdf', '_blank')">
                <!-- Para redireccionar con la escuela -->
                <div class="overlay">
                    <h3>Escuela Femenil</h3>
                </div>
            </div>

            <div class="Escuela cursor-pointer" style="background-image: url('vistas/Imagenes/escuela2.png');"
                 onclick="window.open('vistas/EscuelasPDF/escuelajuvenil032025.pdf', '_blank')">
                <!-- Para redireccionar con la escuela -->
                <div class="overlay">
                    <h3>Escuela Juvenil</h3>
                </div>
            </div>

            <div class="Escuela cursor-pointer" style="background-image: url('vistas/Imagenes/infantil.png');"
                 onclick="window.open('vistas/EscuelasPDF/escuelainfantil012025.pdf', '_blank')">
                <!-- Para redireccionar con la escuela -->
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

   

    <!-- ========================================================================
            Footer
    ==========================================================================-->

    <footer class="bg-gray-900 text-gray-400 py-6 text-center">
        <div class="container mx-auto px-4">
            <p>&copy; <?php echo date('Y'); ?> Iglesia de Dios en El Salvador. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="vistas/js/script.js"></script>
    
<script>
        const header = document.getElementById("header");

        window.addEventListener("scroll", () => {
            if (window.scrollY > 50) {
                header.classList.add("bg-black");
                header.classList.remove("bg-transparent");
            } else {
                header.classList.add("bg-transparent");
                header.classList.remove("bg-black");
            }
        });
    </script>
</body>
</html>
