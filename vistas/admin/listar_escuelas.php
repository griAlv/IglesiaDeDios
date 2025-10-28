<?php
include_once(__DIR__ . "/../../controladores/controlador_Escuelasabatica.php");
$controlador = new controlador_Escuelasabatica();
$escuelas = $controlador->listarEscuelasSabatica();

$mensaje_exito = isset($_SESSION['mensaje_exito']) ? $_SESSION['mensaje_exito'] : '';
$mensaje_error = isset($_SESSION['mensaje_error']) ? $_SESSION['mensaje_error'] : '';
unset($_SESSION['mensaje_exito']);
unset($_SESSION['mensaje_error']);
$escuelas_por_trimestre = [];
foreach ($escuelas as $escuela) {
    $trimestre = $escuela['trimestre'];
    $anio = $escuela['anio'];
    if (!isset($escuelas_por_trimestre["$anio-$trimestre"])) {
        $escuelas_por_trimestre["$anio-$trimestre"] = [];
    }
    $escuelas_por_trimestre["$anio-$trimestre"][] = $escuela;
}

$nombres_trimestres = [
    'primer' => 'Primer Trimestre',
    'segundo' => 'Segundo Trimestre',
    'tercer' => 'Tercer Trimestre',
    'cuarto' => 'Cuarto Trimestre'
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escuelas Sabáticas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/iglesia/vistas/css/Escuelas.css">
    <!-- PDF.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <style>
        .pdf-preview-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .pdf-preview-canvas {
            max-width: 70%;
            max-height: 85%;
            object-fit: contain;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            border-radius: 8px;
        }
        
        .pdf-loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 1.2rem;
            text-align: center;
        }

        .Escuela {
            position: relative;
            min-height: 300px;
        }

        .overlay {
            background: rgba(0, 0, 0, 0.6) !important;
            backdrop-filter: blur(5px);
        }
    </style>
</head>
<body class="font-sans bg-gray-50 text-gray-800 pt-20">
    <?php if ($mensaje_exito): ?>
        <div class="container mx-auto px-4 mb-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <i class="fas fa-check-circle"></i> <strong><?php echo $mensaje_exito; ?></strong>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if ($mensaje_error): ?>
        <div class="container mx-auto px-4 mb-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <i class="fas fa-exclamation-circle"></i> <strong><?php echo $mensaje_error; ?></strong>
            </div>
        </div>
    <?php endif; ?>
    
    <?php foreach ($escuelas_por_trimestre as $key => $grupo_escuelas): 
        list($anio, $trimestre) = explode('-', $key);
        $nombre_trimestre = $nombres_trimestres[$trimestre] ?? ucfirst($trimestre) . ' Trimestre';
    ?>
    <section id="Escuelas" class="Escuelas">
        <div class="Escuelas-header">
            <h2><?php echo "$nombre_trimestre $anio"; ?></h2>
            <?php if ($key === array_key_first($escuelas_por_trimestre)): ?>
                <a href="/iglesia/vistas/admin/index.php" class="btn-escuelas">← Volver</a>
            <?php endif; ?>
        </div>

        <div class="Escuelas-grid">
            <?php 
            // Mostrar los tipos en un orden específico
            $tipos_ordenados = ['general', 'femenil', 'juvenil', 'infantil'];
            
            foreach ($tipos_ordenados as $tipo):
                $escuela_tipo = null;
                // Buscar si existe una escuela de este tipo en el trimestre actual
                foreach ($grupo_escuelas as $escuela) {
                    if ($escuela['tipo'] === $tipo) {
                        $escuela_tipo = $escuela;
                        break;
                    }
                }
                
                if ($escuela_tipo):
                    $nombre_tipo = ucfirst($tipo);
                    $pdf_url = '/iglesia/vistas/' . ltrim($escuela_tipo['archivo'], '/');
            ?>
                <div class="Escuela cursor-pointer" 
                     data-pdf-url="<?php echo $pdf_url; ?>"
                     data-escuela-id="<?php echo $escuela_tipo['idescuela_sabatica']; ?>"
                     onclick="window.open('<?php echo $pdf_url; ?>', '_blank')">
                    <div class="pdf-preview-container">
                        <canvas class="pdf-preview-canvas" id="canvas-<?php echo $escuela_tipo['idescuela_sabatica']; ?>"></canvas>
                        <div class="pdf-loading">
                            <i class="fas fa-spinner fa-spin"></i><br>
                            <small>Cargando vista previa...</small>
                        </div>
                    </div>
                    <div class="overlay">
                        <h3>Escuela <?php echo $nombre_tipo; ?></h3>
                        <div class="mt-2">
                            <a href="/iglesia/vistas/admin/editar_escuela.php?id=<?php echo $escuela_tipo['idescuela_sabatica']; ?>" 
                               class="text-white hover:underline mr-3"
                               onclick="event.stopPropagation();">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="/iglesia/vistas/admin/eliminar_escuela.php?id=<?php echo $escuela_tipo['idescuela_sabatica']; ?>" 
                               class="text-white hover:underline"
                               onclick="event.stopPropagation(); return confirm('¿Estás seguro de eliminar esta escuela?')">
                                <i class="fas fa-trash"></i> Eliminar
                            </a>
                        </div>
                    </div>
                </div>
            <?php 
                endif;
            endforeach; 
            ?>
        </div>
    </section>
    <?php endforeach; ?>

    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        async function renderPDFPreview(pdfUrl, canvasId) {
            try {
                const loadingTask = pdfjsLib.getDocument(pdfUrl);
                const pdf = await loadingTask.promise;
                const page = await pdf.getPage(1); // Primera página
                
                const canvas = document.getElementById(canvasId);
                const context = canvas.getContext('2d');
                
                const scale = 1.5;
                const viewport = page.getViewport({ scale: scale });
                
                canvas.width = viewport.width;
                canvas.height = viewport.height;
                
                const renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };
                
                await page.render(renderContext).promise;
                
                const loadingDiv = canvas.parentElement.querySelector('.pdf-loading');
                if (loadingDiv) {
                    loadingDiv.style.display = 'none';
                }
            } catch (error) {
                console.error('Error al cargar el PDF:', error);
                const loadingDiv = document.getElementById(canvasId).parentElement.querySelector('.pdf-loading');
                if (loadingDiv) {
                    loadingDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i><br><small>Error al cargar</small>';
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const escuelas = document.querySelectorAll('.Escuela[data-pdf-url]');
            
            escuelas.forEach(escuela => {
                const pdfUrl = escuela.getAttribute('data-pdf-url');
                const escuelaId = escuela.getAttribute('data-escuela-id');
                const canvasId = `canvas-${escuelaId}`;
                
                renderPDFPreview(pdfUrl, canvasId);
            });
        });
    </script>
</body>
</html>