<?php
/**
 * Script de prueba para verificar la conexión con Cloudinary
 */

// Incluir configuración de Cloudinary
require_once dirname(dirname(__DIR__)) . '/config/cloudinary_config.php';

$mensaje = "";
$resultado = null;

// Verificar credenciales
$credencialesCompletas = (
    CLOUDINARY_CLOUD_NAME !== 'TU_CLOUD_NAME_AQUI' &&
    CLOUDINARY_API_KEY !== 'TU_API_KEY_AQUI' &&
    CLOUDINARY_API_SECRET !== 'TU_API_SECRET_AQUI'
);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['test_connection'])) {
    if (!$credencialesCompletas) {
        $mensaje = "<div class='alert alert-danger'><i class='bi bi-x-circle me-2'></i>Por favor, configura tus credenciales de Cloudinary primero.</div>";
    } else {
        // Hacer una petición simple a la API de Cloudinary para verificar las credenciales
        $cloudName = CLOUDINARY_CLOUD_NAME;
        $apiKey = CLOUDINARY_API_KEY;
        $apiSecret = CLOUDINARY_API_SECRET;
        
        $timestamp = time();
        
        // Crear una firma simple para probar
        $signatureString = "timestamp={$timestamp}" . $apiSecret;
        $signature = sha1($signatureString);
        
        // URL de la API para listar recursos
        $url = "https://api.cloudinary.com/v1_1/{$cloudName}/resources/video?timestamp={$timestamp}&api_key={$apiKey}&signature={$signature}";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            $mensaje = "<div class='alert alert-danger'><i class='bi bi-x-circle me-2'></i><strong>Error de conexión:</strong> {$error}</div>";
        } else {
            curl_close($ch);
            $result = json_decode($response, true);
            
            if ($httpCode === 200) {
                $mensaje = "<div class='alert alert-success'><i class='bi bi-check-circle me-2'></i><strong>¡Conexión exitosa!</strong> Tus credenciales de Cloudinary son correctas.</div>";
                $resultado = $result;
            } else {
                $errorMsg = isset($result['error']['message']) ? $result['error']['message'] : 'Error desconocido';
                $mensaje = "<div class='alert alert-danger'><i class='bi bi-x-circle me-2'></i><strong>Error de autenticación:</strong> {$errorMsg}</div>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test de Cloudinary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container-main {
            max-width: 800px;
            margin: 30px auto;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .credential-item {
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
            margin-bottom: 10px;
            font-family: monospace;
        }
        .credential-label {
            font-weight: bold;
            color: #495057;
        }
        .credential-value {
            color: #007bff;
        }
        .credential-missing {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container-main">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0"><i class="bi bi-cloud-check me-2"></i>Test de Conexión Cloudinary</h2>
            </div>
            <div class="card-body">
                <h5 class="mb-3">Estado de Credenciales</h5>
                
                <div class="credential-item">
                    <span class="credential-label">Cloud Name:</span>
                    <span class="<?php echo CLOUDINARY_CLOUD_NAME !== 'TU_CLOUD_NAME_AQUI' ? 'credential-value' : 'credential-missing'; ?>">
                        <?php echo CLOUDINARY_CLOUD_NAME !== 'TU_CLOUD_NAME_AQUI' ? CLOUDINARY_CLOUD_NAME : '❌ No configurado'; ?>
                    </span>
                </div>
                
                <div class="credential-item">
                    <span class="credential-label">API Key:</span>
                    <span class="<?php echo CLOUDINARY_API_KEY !== 'TU_API_KEY_AQUI' ? 'credential-value' : 'credential-missing'; ?>">
                        <?php 
                        if (CLOUDINARY_API_KEY !== 'TU_API_KEY_AQUI') {
                            echo substr(CLOUDINARY_API_KEY, 0, 4) . '...' . substr(CLOUDINARY_API_KEY, -4);
                        } else {
                            echo '❌ No configurado';
                        }
                        ?>
                    </span>
                </div>
                
                <div class="credential-item">
                    <span class="credential-label">API Secret:</span>
                    <span class="<?php echo CLOUDINARY_API_SECRET !== 'TU_API_SECRET_AQUI' ? 'credential-value' : 'credential-missing'; ?>">
                        <?php 
                        if (CLOUDINARY_API_SECRET !== 'TU_API_SECRET_AQUI') {
                            echo '••••••••••••';
                        } else {
                            echo '❌ No configurado';
                        }
                        ?>
                    </span>
                </div>
                
                <hr class="my-4">
                
                <?php if (!$credencialesCompletas): ?>
                    <div class="alert alert-warning">
                        <h5><i class="bi bi-exclamation-triangle me-2"></i>Credenciales Incompletas</h5>
                        <p>Para usar Cloudinary, necesitas configurar tus credenciales en:</p>
                        <code>config/cloudinary_config.php</code>
                        <p class="mt-3 mb-0">
                            <strong>Pasos:</strong>
                        </p>
                        <ol>
                            <li>Ve a <a href="https://console.cloudinary.com/" target="_blank">https://console.cloudinary.com/</a></li>
                            <li>Inicia sesión o crea una cuenta gratuita</li>
                            <li>En el Dashboard, copia tus credenciales</li>
                            <li>Pégalas en el archivo de configuración</li>
                        </ol>
                    </div>
                <?php else: ?>
                    <?php echo $mensaje; ?>
                    
                    <form method="POST" action="">
                        <button type="submit" name="test_connection" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-cloud-check me-2"></i>Probar Conexión
                        </button>
                    </form>
                    
                    <?php if ($resultado && isset($resultado['resources'])): ?>
                        <div class="mt-4">
                            <h5>Archivos en Cloudinary:</h5>
                            <p class="text-muted">Total de archivos de audio: <strong><?php echo count($resultado['resources']); ?></strong></p>
                            
                            <?php if (count($resultado['resources']) > 0): ?>
                                <div class="list-group mt-3">
                                    <?php foreach (array_slice($resultado['resources'], 0, 5) as $resource): ?>
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-file-music me-2"></i>
                                                    <strong><?php echo htmlspecialchars($resource['public_id']); ?></strong>
                                                </div>
                                                <span class="badge bg-primary">
                                                    <?php echo isset($resource['format']) ? strtoupper($resource['format']) : 'N/A'; ?>
                                                </span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php if (count($resultado['resources']) > 5): ?>
                                    <p class="text-muted mt-2 text-center">
                                        ... y <?php echo count($resultado['resources']) - 5; ?> más
                                    </p>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                
                <div class="mt-4 d-grid gap-2">
                    <a href="index.php?url=listarhimnario" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Volver al Panel
                    </a>
                    <a href="migrar_a_cloudinary.php" class="btn btn-outline-primary">
                        <i class="bi bi-cloud-upload me-2"></i>Ir a Migración
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-body">
                <h5><i class="bi bi-info-circle me-2"></i>Información del Sistema</h5>
                <ul class="list-unstyled mb-0">
                    <li><strong>PHP cURL:</strong> <?php echo function_exists('curl_version') ? '✅ Habilitado' : '❌ Deshabilitado'; ?></li>
                    <li><strong>PHP Version:</strong> <?php echo phpversion(); ?></li>
                    <li><strong>Carpeta de Himnos:</strong> <code>/vistas/himnos/</code></li>
                    <li><strong>Carpeta de Audio:</strong> <code>/vistas/PistasHimnos/</code></li>
                </ul>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
