<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir configuración de Cloudinary
require_once dirname(dirname(__DIR__)) . '/config/cloudinary_config.php';

// Configuración de rutas absolutas
$rutaBase = dirname(dirname(__DIR__));
$carpetaDestino = $rutaBase . '/vistas/himnos/';
$carpetaAudio = $rutaBase . '/vistas/PistasHimnos/';

if (!file_exists($carpetaDestino)) {
    mkdir($carpetaDestino, 0777, true);
}
if (!file_exists($carpetaAudio)) {
    mkdir($carpetaAudio, 0777, true);
}

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'], $_POST['titulo'], $_POST['letra'])) {
        $id = intval($_POST['id']);
        $titulo = trim($_POST['titulo']);
        $letra = $_POST['letra'];
        
        // Validar datos básicos
        if (empty($titulo) || empty($letra)) {
            $mensaje = "<div class='alert alert-danger'>El título y la letra son obligatorios.</div>";
        } else {
            $audioUrl = null;
            $errorAudio = null;
            
            // Procesar el archivo de audio si se subió
            if (isset($_FILES['audio_file']) && $_FILES['audio_file']['error'] === UPLOAD_ERR_OK) {
                $archivoTemporal = $_FILES['audio_file']['tmp_name'];
                $nombreOriginal = $_FILES['audio_file']['name'];
                $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
                
                // Validar que sea un archivo de audio
                $extensionesPermitidas = ['mp3', 'wav', 'ogg', 'm4a', 'aac'];
                if (!in_array(strtolower($extension), $extensionesPermitidas)) {
                    $errorAudio = "Formato de audio no permitido. Use: " . implode(', ', $extensionesPermitidas);
                } else {
                    // Subir a Cloudinary
                    $publicId = sprintf("%03d", $id); // Usar el ID del himno como public_id
                    $resultado = subirAudioACloudinary($archivoTemporal, $publicId);
                    
                    if ($resultado['success']) {
                        $audioUrl = $resultado['url'];
                    } else {
                        $errorAudio = "Error al subir a Cloudinary: " . $resultado['error'];
                    }
                }
            } elseif (isset($_POST['audio_url']) && !empty(trim($_POST['audio_url']))) {
                // Si se proporcionó una URL directamente
                $audioUrl = trim($_POST['audio_url']);
            }
            
            if ($errorAudio) {
                $mensaje = "<div class='alert alert-danger'>" . $errorAudio . "</div>";
            } else {
                $letraArray = array_filter(array_map('trim', explode("\n", $letra)));
                $letraArray = array_values($letraArray);
                
                // Crear el objeto del himno
                $himno = [
                    "id" => $id,
                    "titulo" => $titulo,
                    "letra" => $letraArray
                ];
                
                // Agregar audio solo si existe
                if ($audioUrl) {
                    $himno["audio"] = $audioUrl;
                }
                
                $nombreArchivo = $carpetaDestino . sprintf("%03d", $id) . ".json";
                $json = json_encode($himno, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                
                if (file_put_contents($nombreArchivo, $json)) {
                    $mensajeAudio = $audioUrl ? " con audio en Cloudinary" : " sin audio";
                    $mensaje = "<div class='alert alert-success'>Himno guardado exitosamente" . $mensajeAudio . ": " . basename($nombreArchivo) . "</div>";
                    
                    // Limpiar formulario
                    $_POST = array();
                } else {
                    $mensaje = "<div class='alert alert-danger'>Error al guardar el archivo. Verifica los permisos de escritura.</div>";
                }
            }
        }
    } else {
        $mensaje = "<div class='alert alert-danger'>El ID, título y letra son obligatorios.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Himno - Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .form-label {
            font-weight: 600;
        }
        .btn-submit {
            background-color: #0d6efd;
            border: none;
            padding: 10px 25px;
            font-weight: 500;
        }
        .btn-submit:hover {
            background-color: #0b5ed7;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <h2 class="mb-4"><i class="bi bi-music-note-beamed me-2"></i>Añadir Nuevo Himno</h2>
                    
                    <?php echo $mensaje; ?>
                    
                    <form method="POST" action="" enctype="multipart/form-data" class="mt-4">
                        <div class="mb-3">
                            <label for="id" class="form-label">ID del Himno</label>
                            <input type="number" class="form-control form-control-lg" id="id" name="id" required min="1" 
                                   value="">
                        </div>
                        
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título del Himno</label>
                            <input type="text" class="form-control form-control-lg" id="titulo" name="titulo" required
                                   value="">
                        </div>
                        
                        <div class="mb-3">
                            <label for="audio_file" class="form-label">Archivo de Audio</label>
                            <input type="file" class="form-control form-control-lg" id="audio_file" name="audio_file" 
                                   accept=".mp3,.wav,.ogg,.m4a,.aac">
                            <div class="form-text">Sube un archivo de audio (MP3, WAV, OGG, M4A, AAC). Se subirá automáticamente a Cloudinary.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="audio_url" class="form-label">O pega la URL de Cloudinary</label>
                            <input type="text" class="form-control form-control-lg" id="audio_url" name="audio_url"
                                   placeholder="https://res.cloudinary.com/..." 
                                   value="">
                            <div class="form-text">Si ya subiste el audio a Cloudinary, pega la URL aquí. Esto es opcional si subes un archivo arriba.</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="letra" class="form-label">Letra del Himno</label>
                            <textarea class="form-control" id="letra" name="letra" rows="15" required placeholder="1
Por fe contemplo redención
La fuente carmesí;
Jesús nos da la salvación,
Su vida dió por mí.
CORO
La fuente sin igual hallé..."></textarea>
                            <div class="form-text">Escribe cada línea en una nueva línea. Ejemplo de formato arriba.</div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-primary btn-submit">
                                <i class="bi bi-save me-2"></i>Guardar Himno
                            </button>
                            <a href="index.php?url=listarhimnario" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Volver al listado
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>