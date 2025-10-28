Documentacion
<?php
include_once(__DIR__ . "/../../controladores/controlador_documentos.php");

$controlador = new controlador_documentos();
$documentos = $controlador->listarDocumentos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Documentos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

    <style>
        :root {
            --primary-color: #2c5aa0;
            --secondary-color: #d4a017;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
        }

        .docs-section {
            padding: 3rem 1.5rem;
            background-image: url('/iglesia/vistas/Imagenes/lib.jpg');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .docs-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(255, 255, 255, 0.9);
            z-index: 0;
        }

        .docs-section > * {
            position: relative;
            z-index: 1;
        }

        .docs-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .docs-header h2 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            position: relative;
            padding-bottom: 0.5rem;
        }

        .docs-header h2::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--secondary-color);
        }

        .docs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .doc-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            transition: transform .3s ease;
            position: relative;
            cursor: pointer;
            background: white;
        }

        .doc-card:hover {
            transform: translateY(-5px);
        }

        .pdf-preview-container {
            position: relative;
            height: 250px;
            background: #f0f0f0;
            overflow: hidden;
        }

        .pdf-preview-canvas {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .pdf-loading {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            color: #555;
            font-size: 1rem;
            text-align: center;
        }

        .doc-info {
            padding: 1rem 1.2rem;
        }

        .doc-info h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .doc-info p {
            font-size: 0.9rem;
            color: #555;
            margin-top: 0.5rem;
        }

        .doc-footer {
            padding: 0.8rem 1.2rem;
            background: #f9fafb;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-ver {
            background-color: var(--primary-color);
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            text-decoration: none;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        .btn-ver:hover {
            background-color: #1e3d72;
        }
    </style>
</head>

<body>
<section class="docs-section">
    <div class="docs-header">
        <h2>📚 Biblioteca de Documentos</h2>
        <a href="index.html" class="btn-ver"><i class="fa fa-arrow-left"></i> Volver</a>
    </div>

    <div class="docs-grid">
        <?php foreach ($documentos as $doc): 
            $pdf_url = '/iglesia/' . ltrim($doc['archivo'], '/');
        ?>
            <div class="doc-card" onclick="window.open('<?php echo $pdf_url; ?>', '_blank')">
                <div class="pdf-preview-container">
                    <canvas id="canvas-<?php echo $doc['id']; ?>" class="pdf-preview-canvas"></canvas>
                    <div class="pdf-loading">
                        <i class="fas fa-spinner fa-spin"></i><br><small>Cargando...</small>
                    </div>
                </div>
                <div class="doc-info">
                    <h3><?php echo htmlspecialchars($doc['nombre']); ?></h3>
                    <p><?php echo htmlspecialchars($doc['descripcion']); ?></p>
                </div>
                <div class="doc-footer">
                    <span class="text-sm text-gray-600">
                        <i class="fa fa-calendar"></i> <?php echo htmlspecialchars($doc['fecha_creacion']); ?>
                    </span>
                    <a href="<?php echo $pdf_url; ?>" target="_blank" class="btn-ver">Ver PDF</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    async function renderPDFPreview(pdfUrl, canvasId) {
        try {
            const loadingTask = pdfjsLib.getDocument(pdfUrl);
            const pdf = await loadingTask.promise;
            const page = await pdf.getPage(1);

            const canvas = document.getElementById(canvasId);
            const context = canvas.getContext('2d');
            const scale = 1.2;
            const viewport = page.getViewport({ scale });

            canvas.width = viewport.width;
            canvas.height = viewport.height;

            await page.render({ canvasContext: context, viewport }).promise;

            const loadingDiv = canvas.parentElement.querySelector('.pdf-loading');
            if (loadingDiv) loadingDiv.style.display = 'none';
        } catch (e) {
            console.error('Error cargando PDF:', e);
            const loadingDiv = document.getElementById(canvasId).parentElement.querySelector('.pdf-loading');
            if (loadingDiv)
                loadingDiv.innerHTML = '<i class="fa fa-exclamation-triangle text-red-500"></i><br><small>Error</small>';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.doc-card').forEach(card => {
            const canvas = card.querySelector('canvas');
            if (canvas) {
                const pdfUrl = card.getAttribute('onclick').match(/'(.*?)'/)[1];
                renderPDFPreview(pdfUrl, canvas.id);
            }
        });
    });
</script>
</body>
</html>
