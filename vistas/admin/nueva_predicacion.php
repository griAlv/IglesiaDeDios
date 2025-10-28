<?php
include_once(__DIR__ . "/../../controladores/controlador_predicas.php");
$controlador = new controlador_predicas();
$predicas = $controlador->listarPredicas();


if ( isset($_POST['guardar'])) {
    try {
        // Basic input validation
        $titulo = trim($_POST['titulo'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $url_youtube = trim($_POST['url_youtube'] ?? '');
        $miniatura = trim($_POST['miniatura'] ?? '');
        $predicador = trim($_POST['predicador'] ?? '');
       

        if (empty($titulo) || empty($descripcion) || empty($url_youtube)) {
            throw new Exception("Por favor complete todos los campos requeridos");
        }

        $controlador->nuevaPredica(
            $titulo,
            $descripcion,
            $url_youtube,
            $miniatura,
            $predicador,
            $_SESSION['usuario']['idusuario']
        );
        
        // Redirect to prevent form resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

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
    <title>Nueva Predicación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/iglesia/vistas/css/admin.css">
    <style>
        .predica-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            cursor: pointer;
        }
        
        .predica-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        
        .predica-img-container {
            position: relative;
            padding-top: 56.25%; /* 16:9 Aspect Ratio */
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
        
        .predica-meta i {
            color: #667eea;
        }
        
        .badge-predicador {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .section-header {
            margin: 3rem 0 2rem 0;
            padding-bottom: 1rem;
            border-bottom: 3px solid #667eea;
        }
        
        .section-header h3 {
            color: #2d3748;
            font-weight: 700;
            margin: 0;
        }
        
        .no-predicas {
            text-align: center;
            padding: 4rem 2rem;
            color: #718096;
        }
        
        .no-predicas i {
            font-size: 4rem;
            color: #cbd5e0;
            margin-bottom: 1rem;
        }

        /* Modal Video Styles */
        .modal-video .modal-dialog {
            max-width: 900px;
        }

        .modal-video .modal-content {
            background: #000;
            border: none;
        }

        .modal-video .modal-header {
            border-bottom: none;
            padding: 1rem;
            background: rgba(0,0,0,0.8);
        }

        .modal-video .modal-body {
            padding: 0;
        }

        .modal-video .btn-close {
            filter: invert(1);
        }

        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
        }

        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .modal-video .modal-title {
            color: white;
            font-size: 1.1rem;
        }

        .btn-view-video {
            position: absolute;
            bottom: 1rem;
            right: 1rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .predica-card:hover .btn-view-video {
            opacity: 1;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <h2>Nueva Predicación</h2>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <form method="POST" class="mb-4">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título *</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción *</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="url_youtube" class="form-label">URL de YouTube *</label>
                        <input type="url" class="form-control" id="url_youtube" name="url_youtube" required>
                        <small class="text-muted">Ejemplo: https://www.youtube.com/watch?v=VIDEO_ID</small>
                    </div>
                    
                    
                    
                    <div class="mb-3">
                        <label for="predicador" class="form-label">Predicador</label>
                        <input type="text" class="form-control" id="predicador" name="predicador">
                    </div>
                    
                    <button type="submit" name="guardar" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>

        <div class="section-header">
            <h3><i class="bi bi-collection-play me-2"></i>Predicaciones Existentes</h3>
        </div>

        <div class="row">
            <?php if (empty($predicas)): ?>
                <div class="col-12">
                    <div class="no-predicas">
                        <i class="bi bi-inbox"></i>
                        <h4>No hay predicaciones disponibles</h4>
                        <p>Comienza agregando tu primera predicación</p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($predicas as $predica): 
                    $videoId = getYoutubeVideoId($predica['url_youtube']);
                    $thumbnail = !empty($predica['miniatura']) ? $predica['miniatura'] : "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
                ?>
                    <div class="col-md-4 col-lg-3 mb-4">
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
                                    <i class="bi bi-upload"></i>
                                    <span><?php echo htmlspecialchars($predica['creadopor']); ?></span>
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
                        <div class="video-container" data-video-id="<?php echo htmlspecialchars($videoId); ?>">
                    <!-- El iframe se cargará dinámicamente cuando se abra el modal -->
                        </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

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