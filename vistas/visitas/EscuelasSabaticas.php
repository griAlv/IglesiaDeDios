<?php
include_once(__DIR__ . "/../../controladores/controlador_Escuelasabatica.php");
$controlador = new controlador_Escuelasabatica();
$escuelas = $controlador->listarEscuelasSabatica();

// Organizar escuelas por trimestre y año
$escuelas_por_trimestre = [];
foreach ($escuelas as $escuela) {
    $trimestre = $escuela['trimestre'];
    $anio = $escuela['anio'];
    if (!isset($escuelas_por_trimestre["$anio-$trimestre"])) {
        $escuelas_por_trimestre["$anio-$trimestre"] = [];
    }
    $escuelas_por_trimestre["$anio-$trimestre"][] = $escuela;
}

// Nombres de los trimestres
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
    <!-- Bootstrap 5 y Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/iglesia/vistas/css/Escuelas.css">
    <!-- PDF.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <style>
        :root {
            --primary-color: #2c5aa0;
            --secondary-color: #d4a017;
            --accent-color: #8b4513;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
        }
        
        .escuelas-section {
            padding: 3rem 1.5rem;
            background-image: url('/iglesia/vistas/Imagenes/lib.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }
        
        .escuelas-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.85);
            z-index: 0;
        }
        
        .escuelas-section > * {
            position: relative;
            z-index: 1;
        }
        
        .escuelas-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .escuelas-header h2 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
            position: relative;
            padding-bottom: 0.5rem;
        }
        
        .escuelas-header h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--secondary-color);
        }
        
        .btn-escuelas {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .btn-escuelas:hover {
            background-color: #1e3d72;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }
        
        .escuelas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }
        
        .escuela-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            height: 300px;
        }
        
        .escuela-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
        }
        
        .escuela-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.7) 100%);
            z-index: 1;
        }
        
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
            background: #f0f0f0;
        }
        
        .pdf-preview-canvas {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .pdf-loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #666;
            font-size: 1.2rem;
            text-align: center;
        }
        
        .card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 1.5rem;
            z-index: 2;
            color: white;
            background: rgba(0, 0, 0, 0.6) !important;
            backdrop-filter: blur(5px);
        }
        
        .card-overlay h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
        }
        
        .card-overlay p {
            font-size: 0.9rem;
            margin: 0;
            opacity: 0.9;
        }
        
        .trimestre-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: var(--secondary-color);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 3;
        }
        
        @media (max-width: 768px) {
            .escuelas-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .escuelas-header h2 {
                font-size: 1.75rem;
            }
            
            .escuelas-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }
        
        @media (max-width: 576px) {
            .escuelas-section {
                padding: 2rem 1rem;
            }
            
            .escuelas-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="font-sans bg-gray-50 text-gray-800 pt-20">
    <?php 
    $es_primer_trimestre = true;
    foreach ($escuelas_por_trimestre as $key => $grupo_escuelas): 
        list($anio, $trimestre) = explode('-', $key);
        $nombre_trimestre = $nombres_trimestres[$trimestre] ?? ucfirst($trimestre) . ' Trimestre';
    ?>
    <section class="escuelas-section">
        <div class="escuelas-header">
            <h2><?php echo "$nombre_trimestre $anio"; ?></h2>
            <?php if ($es_primer_trimestre): ?>
                <a href="index.html" class="btn-escuelas">← Volver</a>
            <?php endif; ?>
        </div>

        <div class="escuelas-grid">
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
                    $pdf_url = '/iglesia/vistas/' . ltrim($escuela_tipo['archivo'], '/');
                    
                    // Configuración según el tipo
                    $config = [
                        'general' => [
                            'nombre' => 'Escuela General',
                            'descripcion' => 'Material para adultos'
                        ],
                        'femenil' => [
                            'nombre' => 'Escuela Femenil',
                            'descripcion' => 'Estudio especial para mujeres'
                        ],
                        'juvenil' => [
                            'nombre' => 'Escuela Juvenil',
                            'descripcion' => 'Material para jóvenes'
                        ],
                        'infantil' => [
                            'nombre' => 'Escuela Infantil',
                            'descripcion' => 'Material para niños'
                        ]
                    ];
                    
                    $nombre_tipo = $config[$tipo]['nombre'];
                    $descripcion = $config[$tipo]['descripcion'];
            ?>
            <div class="escuela-card" 
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
                <?php if ($es_primer_trimestre): ?>
                    <div class="trimestre-badge">Actual</div>
                <?php endif; ?>
                <div class="card-overlay">
                    <h3><?php echo $nombre_tipo; ?></h3>
                    <p><?php echo $descripcion; ?></p>
                </div>
            </div>
            <?php 
                endif;
            endforeach; 
            ?>
        </div>
    </section>
    <?php 
        $es_primer_trimestre = false;
    endforeach; 
    ?>

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
            const escuelas = document.querySelectorAll('.escuela-card[data-pdf-url]');
            
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