<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Himno</title>
    <!-- Bootstrap 5 y Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/himno.css">
    <style>
        /* Sidebar oculto por defecto */
        #panel-opciones {
            position: fixed;
            top: 0;
            right: 0;
            width: 250px;
            height: 100%;
            background-color: #1E4E59;
            display: none; /* 👈 ahora no se ve hasta que se active */
            flex-direction: column;
            padding: 20px;
            transition: transform 0.3s ease;
            transform: translateX(100%); /* fuera de pantalla */
            z-index: 1000;
        }

            #panel-opciones a {
                margin: 15px 0;
                text-decoration: none;
                color: white;
                font-size: 18px;
            }

        /* Botón menú */
        #menu-opciones {
            font-size: 30px;
            cursor: pointer;
            user-select: none;
            z-index: 1100;
        }

        /* Fondo oscuro */
        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            z-index: 900;
        }

        /* Activar el sidebar */
        #panel-opciones.activo {
            display: flex;
            transform: translateX(0);
        }

        #overlay.activo {
            display: block;
        }

        /* Estilos del reproductor moderno */
        .player-container {
            width: 100%;
            max-width: 450px;
            margin: 30px auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            transition: transform 0.3s ease;
            display: none;
        }
        
        .player-container.active {
            display: block;
        }
        
        .player-container:hover {
            transform: translateY(-5px);
        }
        
        .song-info {
            padding: 25px;
            text-align: center;
        }
        
        .song-title {
            font-size: 22px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }
        
        .song-artist {
            font-size: 16px;
            color: #666;
            margin-bottom: 15px;
        }
        
        .progress-area {
            padding: 0 25px;
        }
        
        .progress-container {
            height: 6px;
            width: 100%;
            background: #e0e0e0;
            border-radius: 50px;
            cursor: pointer;
            margin-bottom: 5px;
        }
        
        .progress-bar {
            height: 100%;
            width: 0%;
            background: linear-gradient(to right, #1E4E59, #3b82f6);
            border-radius: 50px;
            position: relative;
            transition: width 0.1s linear;
        }
        
        .progress-bar::before {
            content: "";
            position: absolute;
            height: 12px;
            width: 12px;
            border-radius: 50%;
            background: #1E4E59;
            right: -5px;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0;
            transition: opacity 0.2s;
        }
        
        .progress-container:hover .progress-bar::before {
            opacity: 1;
        }
        
        .timer {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: #666;
            margin-top: 5px;
            font-family: monospace;
        }
        
        .controls {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 25px;
            gap: 25px;
        }
        
        .control-btn {
            border: none;
            background: transparent;
            cursor: pointer;
            color: #666;
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
        }
        
        .control-btn:hover {
            color: #1E4E59;
            transform: scale(1.1);
        }
        
        .play-pause {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1E4E59, #3b82f6);
            color: white;
            box-shadow: 0 5px 15px rgba(30, 78, 89, 0.4);
            font-size: 24px;
        }
        
        .play-pause:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(30, 78, 89, 0.5);
            color: white;
        }
        
        .volume-container {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 25px 25px;
        }
        
        .volume-slider {
            flex: 1;
            height: 5px;
            background: #e0e0e0;
            border-radius: 50px;
            outline: none;
            -webkit-appearance: none;
        }
        
        .volume-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background: #1E4E59;
            cursor: pointer;
        }
        
        audio {
            display: none;
        }
        
        @media (max-width: 480px) {
            .player-container {
                max-width: 100%;
            }
            
            .song-title {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <header>
        <button id="atras">Atrás</button>
        <h1 id="titulo-himno">Himno</h1>
        <div id="menu-opciones">☰</div>
    </header>

    <!-- Sidebar (fuera del header) -->
    <div id="panel-opciones">
        <a href="himnario-inspirado.html">Himnario Inspirado</a>
        <a href="EscuelasSabaticas.html">Escuelas Sabáticas</a>
        <a href="doctrina.html">Doctrina</a>
        <a href="documentacion.html">Documentación</a>
        <a href="localidades.html">Localidades</a>
        <a href="eventos.html">Eventos</a>
        <a href="multimedia.html">Multimedia</a>
    </div>
    <div id="overlay"></div>

    <main class="container mx-auto px-4 py-6">
        <div id="letra-himno" class="text-lg mb-6"></div>
        
        <!-- Reproductor de Audio Moderno -->
        <div class="player-container" id="playerContainer">
            <div class="song-info">
                <h2 class="song-title" id="songTitle">Cargando...</h2>
                <p class="song-artist">Himnario Inspirado</p>
            </div>
            
            <div class="progress-area">
                <div class="progress-container" id="progressContainer">
                    <div class="progress-bar" id="progressBar"></div>
                </div>
                <div class="timer">
                    <span class="current-time" id="currentTime">0:00</span>
                    <span class="song-duration" id="songDuration">0:00</span>
                </div>
            </div>
            
            <div class="controls">
                <button class="control-btn play-pause" id="playPauseBtn">
                    <i class="fas fa-play"></i>
                </button>
            </div>
            
            <div class="volume-container">
                <i class="fas fa-volume-up"></i>
                <input type="range" class="volume-slider" id="volumeSlider" min="0" max="100" value="70">
            </div>
            
            <audio id="audioHimno">
                Tu navegador no soporta el elemento de audio.
            </audio>
        </div>
    </main>

    <script src="/iglesia/vistas/js/himno.js"></script>
    <script>
        const menuBtn = document.getElementById("menu-opciones");
        const panel = document.getElementById("panel-opciones");
        const overlay = document.getElementById("overlay");

        menuBtn.addEventListener("click", () => {
            panel.classList.toggle("activo");
            overlay.classList.toggle("activo");
        });

        overlay.addEventListener("click", () => {
            panel.classList.remove("activo");
            overlay.classList.remove("activo");
        });
    </script>
</body>
</html>
