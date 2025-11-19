<?php
include_once(__DIR__ . "/../../controladores/controlador_predicas.php");
$controlador = new controlador_predicas();

// Procesar el formulario PRIMERO
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

        $inserted_id = $controlador->nuevaPredica(
            $titulo,
            $descripcion,
            $url_youtube,
            $miniatura,
            $predicador,
            $_SESSION['usuario']['idusuario']
        );

        if ($inserted_id) {
            // Redirect to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF'] . "?success=1&id=" . $inserted_id);
            exit();
        } else {
            throw new Exception("Error al guardar la predicación");
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Cargar las predicaciones DESPUÉS del procesamiento (o después del redirect)
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
    <title>Nueva Predicación</title>

    
</head>
<body>
    <div class="container mt-4">
        <div class="alert alert-info">Total predicaciones en la base de datos: <?php echo count($predicas); ?></div>
        <div class="row">
            <div class="col-md-6">
                <h2>Nueva Predicación</h2>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle me-2"></i>
                        ¡Predicación guardada exitosamente!
                    </div>
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
                        <label for="url_youtube" class="form-label">URL o código iframe de YouTube *</label>
                        <textarea class="form-control" id="url_youtube" name="url_youtube" rows="3" required></textarea>
                        <small class="text-muted">Puedes pegar la URL (por ejemplo: https://www.youtube.com/watch?v=VIDEO_ID) o el código iframe completo.</small>
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
            <h3><i class="bi bi-collection-play me-2"></i>Predicaciones Existentes (<?php echo count($predicas); ?>)</h3>
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
                    </div>

                    <!-- Modal para editar predicación -->
                    <div class="modal fade modal-edit" id="editModal<?php echo $predica['idpredica']; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        <i class="bi bi-pencil-square me-2"></i>Editar Predicación
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="POST" action="">
                                    <div class="modal-body">
                                        <input type="hidden" name="idpredica" value="<?php echo $predica['idpredica']; ?>">
                                        
                                        <div class="mb-3">
                                            <label for="edit_titulo_<?php echo $predica['idpredica']; ?>" class="form-label">Título *</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="edit_titulo_<?php echo $predica['idpredica']; ?>" 
                                                   name="titulo" 
                                                   value="<?php echo htmlspecialchars($predica['titulo']); ?>" 
                                                   required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="edit_descripcion_<?php echo $predica['idpredica']; ?>" class="form-label">Descripción *</label>
                                            <textarea class="form-control" 
                                                      id="edit_descripcion_<?php echo $predica['idpredica']; ?>" 
                                                      name="descripcion" 
                                                      rows="3" 
                                                      required><?php echo htmlspecialchars($predica['descripcion']); ?></textarea>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="edit_url_<?php echo $predica['idpredica']; ?>" class="form-label">URL de YouTube *</label>
                                            <textarea class="form-control" 
                                                      id="edit_url_<?php echo $predica['idpredica']; ?>" 
                                                      name="url_youtube" 
                                                      rows="3" 
                                                      required><?php echo htmlspecialchars($predica['url_youtube']); ?></textarea>
                                            <small class="text-muted">Puedes pegar la URL o el código iframe completo.</small>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="edit_miniatura_<?php echo $predica['idpredica']; ?>" class="form-label">URL Miniatura</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="edit_miniatura_<?php echo $predica['idpredica']; ?>" 
                                                   name="miniatura" 
                                                   value="<?php echo htmlspecialchars($predica['miniatura'] ?? ''); ?>">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="edit_predicador_<?php echo $predica['idpredica']; ?>" class="form-label">Predicador</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="edit_predicador_<?php echo $predica['idpredica']; ?>" 
                                                   name="predicador" 
                                                   value="<?php echo htmlspecialchars($predica['predicador'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" name="editar" class="btn btn-primary">
                                            <i class="bi bi-save me-1"></i>Guardar Cambios
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

  
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
        
       
        modal.addEventListener('hidden.bs.modal', function () {
            const container = this.querySelector('.video-container');
            container.innerHTML = ''; 
        });
    });
</script>
</body>
</html>