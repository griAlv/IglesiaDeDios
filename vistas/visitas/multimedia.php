<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espacio Juvenil</title>
    <link rel="stylesheet" href="/iglesia/vistas/css/EspJuvenil.css">
</head>
<body>
    <!-- Sección principal -->
    <section class="hero">
        <div class="hero-content">
            <h1 class="hero-title">Espacio Juvenil</h1>
            <p class="hero-subtitle">El departamento nacional "Juventud ID" se encarga a nivel nacional de todos los jovenes de la amada iglesia, conoce mas sobre nosotros!</p>
            <div class="scroll-hint">Conocer más ⬇</div>
        </div>
    </section>

    <!-- Sección Escuela Actual -->
    <section class="escuela">
        <div class="escuela-overlay"></div>
        <div class="escuela-container">

            <!-- Columna izquierda: texto -->
            <div class="escuela-content">
                <h2 class="escuela-title">Cartas de Dios</h2>
                <h3 class="escuela-subtitle">Escuela Sabática Juvenil Actual</h3>
                <p class="escuela-text">
                    Imagina si en algún momento de tu vida en tu correspondencia te encuentras con una carta muy especial y particular, cuyo remitente es el Eterno Dios ¿Qué harías? ¿La abrirías con gran alegría para leer su contenido o la mantendrías cerrada por temor a lo que está escrito?

                    Dios siempre ha mostrado su deseo en favor de la humanidad y este trimestre nos permitirá conocer a través de la revelación de su Palabra, su perfecto amor y su eterna justicia.
                </p>
                <div class="escuela-buttons">
                    <a href="#" class="btn leer">Leer escuela</a>
                    <a href="#" class="btn mas">Más escuelas</a>
                </div>
            </div>

            <!-- Columna derecha: imagen carátula -->
            <div class="escuela-cover">
                <img src="/iglesia/vistas/Imagenes/Jovenes/car.png" alt="Carátula Escuela Sabática">
            </div>

        </div>
    </section>

    <!-- -->
    <!-- Sección Nuestros Eventos -->
    <section class="eventos">

        <!-- Línea blanca de separación -->
        <div class="linea-separacion"></div>

        <!-- Encabezado -->
        <h2 class="eventos-title">Nuestros eventos</h2>

        <!-- Galería con grid -->
        <div class="parent">
            <div class="div1 evento-foto" data-titulo="Evento 1" data-info="Información del evento 1" data-img="../Imagenes/Eventos/evento1.jpg">1</div>
            <div class="div2 evento-foto" data-titulo="Evento 2" data-info="Información del evento 2" data-img="../Imagenes/Eventos/evento2.jpg">2</div>
            <div class="div3 evento-foto" data-titulo="Evento 3" data-info="Información del evento 3" data-img="../Imagenes/Eventos/evento3.jpg">3</div>
            <div class="div4 evento-foto" data-titulo="Evento 4" data-info="Información del evento 4" data-img="../Imagenes/Eventos/evento4.jpg">4</div>
            <div class="div5 evento-foto" data-titulo="Evento 5" data-info="Información del evento 5" data-img="../Imagenes/Eventos/evento5.jpg">5</div>
            <div class="div6 evento-foto" data-titulo="Evento 6" data-info="Información del evento 6" data-img="../Imagenes/Eventos/evento6.jpg">6</div>
        </div>
        <div class="linea-separacionFinal"></div>
    </section>
    <!-- Línea blanca de separación -->
    <!-- Modal para mostrar información de cada evento -->
    <div id="modal-evento" class="modal">
        <div class="modal-content">
            <span class="cerrar">&times;</span>
            <img id="modal-img" src="" alt="Evento">
            <h3 id="modal-titulo">Título del evento</h3>
            <p id="modal-info">Información del evento</p>
            <a href="#" class="btn ver-album">Ver álbum completo</a>
        </div>
    </div>

    <!-- Sección Nuestros Eventos -->
    <section class="Unete">
        <!-- Encabezado -->
        <h2 class="Unete-title">¡Es tu momento!</h2>
        <h3 class="TextoUnt">
            Que esperas para ser parte del pueblo de Dios?. Este es tu momento para comenzar de nuevo y velar la fe en nuestro Señor
            Jesucristo, aqui te dejamos puntos importantes que es bueno conocer.
        </h3>
    </section >

    <section1 >

        <img src="/iglesia/vistas/Imagenes/Jovenes/ejempl.png"  href="#"/>
        <img src="/iglesia/vistas/Imagenes/Jovenes/car.png" href="#"/>
        <img src="/iglesia/vistas/Imagenes/Jovenes/car.png" href="#"/>
        <img src="/iglesia/vistas/Imagenes/Jovenes/car.png" href="#"/>
        <img src="/iglesia/vistas/Imagenes/Jovenes/car.png" href="#"/>

    </section1>

    <script src="js/EspacioJuvenil.js"></script>
</body>
</html>
