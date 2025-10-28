<?php
include_once(__DIR__ . "/../../controladores/controlador_predicas.php");
$controlador = new controlador_predicas();
$predicas = $controlador->listarPredicas();

// Function to extract YouTube video ID
function getYoutubeVideoId($url) {
    $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i';
    if (preg_match($pattern, $url, $matches)) {
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
    <title>Predicaciones - Iglesia de Dios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
        }

        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 0;
            margin-bottom: 3rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .page-header h1 {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            opacity: 0.9;
            margin: 0;
        }

        /* Cards de Predicaciones */
        .predica-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            cursor: pointer;
            background: white;
            height: 100%;
        }
        
        .predica-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        
        .predica-img-container {
            position: relative;
            padding-top: 56.25%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            overflow: hidden;
        }
        
        .predica-img-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .predica-img-container .play-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .predica-card:hover .play-overlay {
            opacity: 1;
        }
        
        .predica-card-body {
            padding: 1.5rem;
        }
        
        .predica-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.75rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .predica-description {
            font-size: 0.9rem;
            color: #718096;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 1rem;
        }
        
        .predica-footer {
            background: #f7fafc;
            padding: 1rem 1.5rem;
            border-top: 1px solid #e2e8f0;
        }
        
        .predica-meta {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: #4a5568;
            margin-bottom: 0.5rem;
        }

        .predica-meta:last-child {
            margin-bottom: 0;
        }
        
        .predica-meta i {
            color: #667eea;
        }
        
        .no-predicas {
            text-align: center;
            padding: 4rem 2rem;
            color: #718096;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .no-predicas i {
            font-size: 4rem;
            color: #cbd5e0;
            margin-bottom: 1rem;
        }

        /* Modal Video Styles Mejorado */
        .modal-video {
            background: rgba(0, 0, 0, 0.85);
        }

        .modal-video .modal-dialog {
            max-width: 90%;
            width: 1200px;
            margin: 2rem auto;
        }

        .modal-video .modal-content {
            background: transparent;
            border: none;
            box-shadow: none;
        }

        .modal-video .modal-header {
            border: none;
            padding: 1rem 0 0.5rem;
            background: transparent;
        }

        .modal-video .modal-body {
            padding: 0;
        }

        .modal-video .btn-close {
            filter: invert(1) brightness(2);
            opacity: 1;
            background-size: 1.5rem;
            width: 2rem;
            height: 2rem;
        }

        .modal-video .btn-close:hover {
            opacity: 0.75;
        }

        .modal-video .modal-title {
            color: white;
            font-size: 1.2rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }

        .video-wrapper {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%;
            background: #000;
            border-radius: 8px;
            overflow: hidden;
        }

        .video-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        /* Sección de Radio y TV */
        .media-section {
            margin-top: 4rem;
            margin-bottom: 4rem;
        }

        .section-divider {
            border: 0;
            height: 3px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            margin: 3rem 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 2rem;
        }

        .section-title h2 {
            font-weight: 700;
            color: #2d3748;
        }

        .responsive-iframe {
            position: relative;
            overflow: hidden;
            width: 100%;
            padding-top: 56.25%;
        }

        .responsive-iframe iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="page-header">
        <div class="container">
            <h1><i class="bi bi-collection-play me-2"></i>Predicaciones</h1>
            <p>Explora nuestra colección de mensajes y enseñanzas</p>
        </div>
    </div>

    <!-- Content Predicaciones -->
    <div class="container pb-5">
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
                    <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                        <div class="card predica-card" onclick="openVideoModal('<?php echo $videoId; ?>', '<?php echo htmlspecialchars(addslashes($predica['titulo'])); ?>')">
                            <div class="predica-img-container">
                                <img src="<?php echo htmlspecialchars($thumbnail); ?>" 
                                     alt="<?php echo htmlspecialchars($predica['titulo']); ?>"
                                     loading="lazy"
                                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22640%22 height=%22360%22%3E%3Crect fill=%22%23667eea%22 width=%22640%22 height=%22360%22/%3E%3Ctext fill=%22%23ffffff%22 font-family=%22Arial,sans-serif%22 font-size=%2224%22 text-anchor=%22middle%22 x=%22320%22 y=%22180%22%3EVideo no disponible%3C/text%3E%3C/svg%3E'">
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
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal Universal para Videos -->
    <div class="modal fade modal-video" id="universalVideoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalTitle">Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="video-wrapper">
                        <div id="videoContainer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Separador -->
    <hr class="section-divider">

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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Modal de Bootstrap
        let videoModal = null;
        
        document.addEventListener('DOMContentLoaded', function() {
            const modalElement = document.getElementById('universalVideoModal');
            videoModal = new bootstrap.Modal(modalElement);
            
            // Limpiar video al cerrar
            modalElement.addEventListener('hidden.bs.modal', function() {
                document.getElementById('videoContainer').innerHTML = '';
            });
        });
        
        // Función global para abrir video
        function openVideoModal(videoId, title) {
            if (!videoId) {
                alert('ID de video no válido');
                return;
            }
            
            // Actualizar título
            document.getElementById('videoModalTitle').textContent = title;
            
            // Crear iframe
            const iframe = document.createElement('iframe');
            iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1`;
            iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
            iframe.setAttribute('allowfullscreen', '');
            iframe.style.width = '100%';
            iframe.style.height = '100%';
            iframe.style.border = '0';
            
            // Insertar iframe
            const container = document.getElementById('videoContainer');
            container.innerHTML = '';
            container.appendChild(iframe);
            
            // Mostrar modal
            videoModal.show();
        }
    </script>
</body>
</html>