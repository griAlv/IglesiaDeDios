<?php
include_once(__DIR__ . "/../../controladores/controlador_predicas.php");
$controlador = new controlador_predicas();
$predicas = $controlador->listarPredicas();

// Function to extract YouTube video ID
function getYoutubeVideoId($input) {
    if (empty($input)) {
        return null;
    }

    // Si viene un iframe completo, extraer primero el atributo src
    if (stripos($input, '<iframe') !== false) {
        if (preg_match('/src=["\']([^"\']+)["\']/i', $input, $m)) {
            $input = $m[1];
        }
    }

    $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i';
    if (preg_match($pattern, $input, $matches)) {
        return $matches[1];
    }
    return null;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radio y Predicaciones - Iglesia de Dios</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tailwind CSS -->
   
   
    <link rel="stylesheet" href="/iglesia/vistas/css/radio.css">
</head>
<body>
    <!-- Header -->
    <div class="page-header">
        <div class="container">
            <h1><i class="bi bi-broadcast-tower me-2"></i>Radio y Televisión</h1>
            <p>Sintoniza nuestras transmisiones en vivo</p>
        </div>
    </div>

    <!-- Sección Radio y TV -->
    <div class="container media-section">
        <div class="section-title">
            <h2><i class="fas fa-broadcast-tower me-2"></i>Radio y Televisión</h2>
            <p class="text-muted">Sintoniza nuestras transmisiones en vivo</p>
        </div>

        <div class="row g-4">
            <!-- RADIO -->
            <div class="col-lg-6">
                <div class="card shadow-lg border-0 rounded-4 h-100">
                    <div class="card-header text-white rounded-top-4" 
                         style="background: linear-gradient(90deg, #6c63ff, #3f37c9);">
                        <h3 class="mb-0">
                            <i class="fas fa-broadcast-tower me-2"></i> RADIO ABBA TRANSMITE
                        </h3>
                        <small>Reproductor oficial con controles avanzados</small>
                    </div>
                    <div class="card-body text-center">
                        <iframe name="contenedorPlayer" 
                                class="cuadroBordeado" 
                                allow="autoplay"
                                width="100%" 
                                height="280"
                                frameborder="0" 
                                scrolling="no"
                                loading="lazy"
                                src="https://cp.usastreams.com/pr2g/APPlayerRadioHTML5.aspx?stream=https://whmsonic.playerfullhd.com/8008/stream&fondo=05&formato=mp3&color=14&titulo=2&autoStart=0&vol=10&tipo=20&nombre=RADIO+ABBA+.ORG&imagen=https://cp.usastreams.com/playerHTML5/img/cover.png&server=https://radio.playerfullhd.com/8008/index.htmlCHUMILLASsid=1"
                                title="Radio ABBA - Reproductor Embebido">
                        </iframe>
                    </div>
                    <div class="card-footer bg-light text-center">
                        <a href="https://www.facebook.com/iglesiadedios.or" target="_blank" rel="noopener noreferrer"
                           class="btn btn-primary rounded-pill me-2">
                            <i class="fab fa-facebook-f me-1"></i> Facebook
                        </a>
                        <a href="https://wa.me/50360185110" target="_blank" rel="noopener noreferrer"
                           class="btn btn-success rounded-pill">
                            <i class="fab fa-whatsapp me-1"></i> WhatsApp
                        </a>
                    </div>
                </div>
            </div>

            <!-- TV -->
            <div class="col-lg-6">
                <div class="card shadow-lg border-0 rounded-4 h-100">
                    <div class="card-header text-white rounded-top-4" 
                         style="background: linear-gradient(90deg, #3f37c9, #6c63ff);">
                        <h3 class="mb-0">
                            <i class="fas fa-tv me-2"></i> TV EN VIVO
                        </h3>
                        <small>Transmisión en directo de contenido cristiano</small>
                    </div>
                    <div class="card-body">
                        <div class="responsive-iframe">
                            <iframe src="https://panel.streamingtv-mediacp.online:2000/VideoPlayer/wmabgczpsh?autoplay=0"
                                    scrolling="no" 
                                    allow="autoplay" 
                                    allowfullscreen
                                    loading="lazy"
                                    title="TV Iglesia de Dios - Transmisión en Vivo">
                            </iframe>
                        </div>
                        <div class="mt-3 text-center">
                            <span class="badge bg-success rounded-pill px-3 py-2">
                                🔴 En Vivo
                            </span>
                        </div>
                    </div>
                    <div class="card-footer bg-light text-center">
                        <h5>Programación Cristiana 24/7</h5>
                        <p class="mb-2">Conéctate con Jehová a través de prédicas y alabanzas.</p>
                        <a href="https://www.facebook.com/iglesiadedios.or" target="_blank" rel="noopener noreferrer"
                           class="btn btn-primary rounded-pill me-2">
                            <i class="fab fa-facebook-f me-1"></i> Facebook
                        </a>
                        <a href="https://wa.me/50360185110" target="_blank" rel="noopener noreferrer"
                           class="btn btn-success rounded-pill">
                            <i class="fab fa-whatsapp me-1"></i> WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- HORARIOS -->
        <div class="card shadow-lg border-0 rounded-4 mt-5">
            <div class="card-header text-white rounded-top-4" 
                 style="background: linear-gradient(90deg, #6c63ff, #3f37c9);">
                <h3 class="mb-0"><i class="fas fa-clock me-2"></i> Horarios de Transmisión</h3>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-6 mb-3">
                        <h5 class="text-primary fw-bold">Lunes a Viernes</h5>
                        <ul class="list-unstyled">
                            <li>⏰ 10:00 AM</li>
                            <li>⏰ 2:00 PM</li>
                            <li>⏰ 7:00 PM</li>
                        </ul>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h5 class="text-success fw-bold">Sábados</h5>
                        <ul class="list-unstyled">
                            <li>⏰ Escuela Sabática - 9:00 AM</li>
                            <li>👩‍🦰 Escuela Femenil - 2:00 PM</li>
                            <li>👥 Culto General - 4:00 PM</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Separador -->
    <hr class="section-divider">

    <!-- Apartado de Predicaciones -->
    <div class="container">
        <div class="section-title">
            <h2><i class="bi bi-collection-play me-2"></i>Predicaciones</h2>
            <p class="text-muted">Contenido espiritual para edificar tu fe</p>
        </div>
        
        <?php 
        // DEBUG: Mostrar información de las predicaciones
        echo "<!-- DEBUG: Total predicas en array: " . count($predicas) . " -->";
        foreach ($predicas as $idx => $p) {
            echo "<!-- DEBUG Predica $idx: ID=" . $p['idpredica'] . ", Titulo=" . htmlspecialchars($p['titulo']) . " -->";
        }
        ?>

        <div class="row">
            <?php if (empty($predicas)): ?>
                <div class="col-12">
                    <div class="no-predicas">
                        <i class="bi bi-inbox"></i>
                        <h4>No hay predicaciones disponibles</h4>
                        <p>Pronto agregaremos contenido nuevo</p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($predicas as $predica): 
                    $videoId = getYoutubeVideoId($predica['url_youtube']);
                    $thumbnail = !empty($predica['miniatura']) ? $predica['miniatura'] : "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
                ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card predica-card h-100" data-bs-toggle="modal" data-bs-target="#videoModal<?php echo $predica['idpredica']; ?>">
                            <div class="predica-img-container">
                                <img src="<?php echo htmlspecialchars($thumbnail); ?>" 
                                     alt="<?php echo htmlspecialchars($predica['titulo']); ?>"
                                     onerror="this.src='https://via.placeholder.com/640x360/667eea/ffffff?text=Video'">
                                <div class="play-overlay">
                                    <i class="bi bi-play-fill" style="font-size: 2rem; color: #667eea;"></i>
                                </div>
                            </div>
                            
                            <div class="predica-card-body">
                                <h5 class="predica-title"><?php echo htmlspecialchars($predica['titulo']); ?></h5>
                                <p class="predica-description"><?php echo htmlspecialchars($predica['descripcion']); ?></p>
                            </div>
                            
                            <div class="predica-footer">
                                <?php if (!empty($predica['predicador'])): ?>
                                    <div class="predica-meta">
                                        <i class="bi bi-person-circle"></i>
                                        <span><?php echo htmlspecialchars($predica['predicador']); ?></span>
                                    </div>
                                <?php endif; ?>
                                <div class="predica-meta">
                                    <i class="bi bi-calendar-event"></i>
                                    <span><?php echo date('d/m/Y', strtotime($predica['fecha_publicacion'])); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal para reproducir video -->
                    <div class="modal fade modal-video" id="videoModal<?php echo $predica['idpredica']; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><?php echo htmlspecialchars($predica['titulo']); ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="video-wrapper">
                                        <div class="video-container" data-video-id="<?php echo htmlspecialchars($videoId); ?>">
                                            <!-- El iframe se cargará dinámicamente cuando se abra el modal -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Cargar video solo cuando se abre el modal
    document.querySelectorAll('.modal-video').forEach(modal => {
        modal.addEventListener('show.bs.modal', function () {
            const container = this.querySelector('.video-container');
            const videoId = container.getAttribute('data-video-id');
            
            // Solo cargar si no hay iframe ya
            if (!container.querySelector('iframe')) {
                const iframe = document.createElement('iframe');
                iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
                iframe.frameBorder = '0';
                iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
                iframe.allowFullscreen = true;
                container.appendChild(iframe);
            }
        });
        
        // Limpiar iframe completamente cuando se cierra el modal
        modal.addEventListener('hidden.bs.modal', function () {
            const container = this.querySelector('.video-container');
            container.innerHTML = ''; // Eliminar el iframe completamente
        });
    });
    </script>
</body>
</html>