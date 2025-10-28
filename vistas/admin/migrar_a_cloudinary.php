<?php
/**
 * Script de migración para subir archivos de audio locales a Cloudinary
 * y actualizar los archivos JSON de los himnos
 */

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir configuración de Cloudinary
require_once dirname(dirname(__DIR__)) . '/config/cloudinary_config.php';

// Configuración de rutas
$rutaBase = dirname(dirname(__DIR__));
$carpetaHimnos = $rutaBase . '/vistas/himnos/';
$carpetaAudio = $rutaBase . '/vistas/PistasHimnos/';

// Variables para el reporte
$resultados = [];
$totalProcesados = 0;
$totalExitosos = 0;
$totalErrores = 0;

// Procesar la migración si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['iniciar_migracion'])) {
    set_time_limit(0); // Sin límite de tiempo para la migración
    
    // Obtener todos los archivos JSON
    $archivosJSON = glob($carpetaHimnos . '*.json');
    
    foreach ($archivosJSON as $archivoJSON) {
        $totalProcesados++;
        $nombreArchivo = basename($archivoJSON);
        $id = pathinfo($nombreArchivo, PATHINFO_FILENAME);
        
        // Leer el JSON actual
        $contenido = file_get_contents($archivoJSON);
        $himno = json_decode($contenido, true);
        
        if (!$himno) {
            $resultados[] = [
                'archivo' => $nombreArchivo,
                'status' => 'error',
                'mensaje' => 'No se pudo leer el JSON'
            ];
            $totalErrores++;
            continue;
        }
        
        // Verificar si ya tiene URL de Cloudinary
        if (isset($himno['audio']) && strpos($himno['audio'], 'cloudinary.com') !== false) {
            $resultados[] = [
                'archivo' => $nombreArchivo,
                'status' => 'skip',
                'mensaje' => 'Ya usa Cloudinary: ' . $himno['audio']
            ];
            continue;
        }
        
        // Buscar el archivo de audio local
        $archivoAudio = null;
        $extensiones = ['mp3', 'wav', 'ogg', 'm4a', 'aac'];
        
        foreach ($extensiones as $ext) {
            $rutaAudio = $carpetaAudio . $id . '.' . $ext;
            if (file_exists($rutaAudio)) {
                $archivoAudio = $rutaAudio;
                break;
            }
        }
        
        if (!$archivoAudio) {
            $resultados[] = [
                'archivo' => $nombreArchivo,
                'status' => 'warning',
                'mensaje' => 'No se encontró archivo de audio local'
            ];
            continue;
        }
        
        // Subir a Cloudinary
        $resultado = subirAudioACloudinary($archivoAudio, $id);
        
        if ($resultado['success']) {
            // Actualizar el JSON con la nueva URL
            $himno['audio'] = $resultado['url'];
            $jsonActualizado = json_encode($himno, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            
            if (file_put_contents($archivoJSON, $jsonActualizado)) {
                $resultados[] = [
                    'archivo' => $nombreArchivo,
                    'status' => 'success',
                    'mensaje' => 'Subido exitosamente',
                    'url' => $resultado['url']
                ];
                $totalExitosos++;
            } else {
                $resultados[] = [
                    'archivo' => $nombreArchivo,
                    'status' => 'error',
                    'mensaje' => 'Error al actualizar el JSON'
                ];
                $totalErrores++;
            }
        } else {
            $resultados[] = [
                'archivo' => $nombreArchivo,
                'status' => 'error',
                'mensaje' => 'Error al subir: ' . $resultado['error']
            ];
            $totalErrores++;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Migrar Himnos a Cloudinary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container-main {
            max-width: 1000px;
            margin: 30px auto;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .status-success {
            color: #28a745;
        }
        .status-error {
            color: #dc3545;
        }
        .status-warning {
            color: #ffc107;
        }
        .status-skip {
            color: #6c757d;
        }
        .resultado-item {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        .resultado-item:last-child {
            border-bottom: none;
        }
        .alert-info {
            background-color: #e7f3ff;
            border-color: #b3d9ff;
            color: #004085;
        }
    </style>
</head>
<body>
    <div class="container-main">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0"><i class="bi bi-cloud-upload me-2"></i>Migrar Himnos a Cloudinary</h2>
            </div>
            <div class="card-body">
                <?php if (empty($resultados)): ?>
                    <div class="alert alert-info">
                        <h5><i class="bi bi-info-circle me-2"></i>Información</h5>
                        <p>Este script te ayudará a migrar todos los archivos de audio de los himnos desde tu servidor local a Cloudinary.</p>
                        <ul>
                            <li>Se buscarán todos los archivos JSON en <code>/vistas/himnos/</code></li>
                            <li>Para cada himno, se buscará su archivo de audio en <code>/vistas/PistasHimnos/</code></li>
                            <li>Los archivos se subirán a Cloudinary con el mismo ID</li>
                            <li>Los archivos JSON se actualizarán con las nuevas URLs de Cloudinary</li>
                            <li>Los himnos que ya usen Cloudinary se omitirán</li>
                        </ul>
                        <p class="mb-0"><strong>Nota:</strong> Asegúrate de haber configurado correctamente tus credenciales de Cloudinary en <code>/config/cloudinary_config.php</code></p>
                    </div>
                    
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Advertencia:</strong> Este proceso puede tomar varios minutos dependiendo de la cantidad de archivos. No cierres esta ventana hasta que termine.
                    </div>
                    
                    <form method="POST" action="">
                        <div class="d-grid gap-2">
                            <button type="submit" name="iniciar_migracion" class="btn btn-primary btn-lg">
                                <i class="bi bi-cloud-upload me-2"></i>Iniciar Migración
                            </button>
                            <a href="index.php?url=listarhimnario" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Volver
                            </a>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="alert alert-success">
                        <h5><i class="bi bi-check-circle me-2"></i>Migración Completada</h5>
                        <p class="mb-0">
                            <strong>Total procesados:</strong> <?php echo $totalProcesados; ?><br>
                            <strong>Exitosos:</strong> <?php echo $totalExitosos; ?><br>
                            <strong>Errores:</strong> <?php echo $totalErrores; ?><br>
                            <strong>Omitidos:</strong> <?php echo count(array_filter($resultados, function($r) { return $r['status'] === 'skip'; })); ?>
                        </p>
                    </div>
                    
                    <h5 class="mt-4 mb-3">Resultados Detallados:</h5>
                    <div class="border rounded">
                        <?php foreach ($resultados as $resultado): ?>
                            <div class="resultado-item">
                                <div class="d-flex align-items-start">
                                    <div class="me-3">
                                        <?php if ($resultado['status'] === 'success'): ?>
                                            <i class="bi bi-check-circle-fill status-success fs-4"></i>
                                        <?php elseif ($resultado['status'] === 'error'): ?>
                                            <i class="bi bi-x-circle-fill status-error fs-4"></i>
                                        <?php elseif ($resultado['status'] === 'warning'): ?>
                                            <i class="bi bi-exclamation-triangle-fill status-warning fs-4"></i>
                                        <?php else: ?>
                                            <i class="bi bi-dash-circle-fill status-skip fs-4"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <strong><?php echo htmlspecialchars($resultado['archivo']); ?></strong><br>
                                        <small class="text-muted"><?php echo htmlspecialchars($resultado['mensaje']); ?></small>
                                        <?php if (isset($resultado['url'])): ?>
                                            <br><small><a href="<?php echo htmlspecialchars($resultado['url']); ?>" target="_blank" class="text-decoration-none">Ver en Cloudinary <i class="bi bi-box-arrow-up-right"></i></a></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="mt-4 d-grid gap-2">
                        <a href="index.php?url=listarhimnario" class="btn btn-primary">
                            <i class="bi bi-arrow-left me-2"></i>Volver al Listado
                        </a>
                        <a href="migrar_a_cloudinary.php" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise me-2"></i>Ejecutar Nuevamente
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
