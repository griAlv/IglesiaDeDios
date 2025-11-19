<?php   
include_once($_SERVER['DOCUMENT_ROOT'] . "/iglesia/controladores/controlador_evento.php");
$controlador = new controlador_evento();
$eventos = $controlador->listarEventos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias de la ID</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="vistas/css/himnario.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }

        /* Hero Section */
        .hero-section {
            position: relative;
            background-image: url('Imagenes/Notis.png');
            background-size: cover;
            background-position: center;
            min-height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-overlay {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 3rem;
            border-radius: 15px;
            text-align: center;
        }

        .hero-section h1 {
            color: white;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .btn-volver {
            display: inline-block;
            padding: 12px 30px;
            background-color: white;
            color: #333;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-volver:hover {
            background-color: #f0f0f0;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            color: #000;
        }

        /* Cards de Noticias */
        .noticia-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            height: 100%;
            border: none;
        }

        .noticia-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }

        .img-wrapper {
            overflow: hidden;
            height: 250px;
        }

        .noticia-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .noticia-card:hover img {
            transform: scale(1.1);
        }

        .card-body-custom {
            padding: 1.5rem;
        }

        .card-body-custom h2 {
            font-size: 1.4rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.75rem;
        }

        .card-body-custom p {
            color: #6c757d;
            font-size: 0.95rem;
            margin: 0;
        }

        /* Modal de Bootstrap 5 personalizado */
        .modal-content {
            border-radius: 15px;
            border: none;
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
            border: none;
            padding: 1.5rem;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        .modal-header .btn-close:hover {
            opacity: 1;
        }

        .modal-title {
            font-weight: 700;
            font-size: 1.75rem;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-image {
            width: 100%;
            height: auto;
            max-height: 450px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }

        .modal-content-text {
            color: #495057;
            line-height: 1.8;
            font-size: 1.1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2rem;
            }

            .hero-overlay {
                padding: 2rem 1.5rem;
            }

            .img-wrapper {
                height: 200px;
            }

            .card-body-custom h2 {
                font-size: 1.2rem;
            }

            .modal-title {
                font-size: 1.4rem;
            }
        }

        @media (max-width: 576px) {
            .hero-section h1 {
                font-size: 1.5rem;
            }

            .btn-volver {
                padding: 10px 20px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay">
            <h1><i class="bi bi-newspaper"></i> Noticias de la ID</h1>
            <a href="/iglesia/index.php" class="btn-volver">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>
    </section>

    <!-- Grid de Noticias -->
    <section class="container py-5">
        <div class="row g-4">
            <?php foreach ($eventos as $evento) { ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="noticia-card" data-bs-toggle="modal" data-bs-target="#modalNoticia<?php echo $evento['idevento']; ?>">
                        <div class="img-wrapper">
                            <img src="../admin/<?php echo htmlspecialchars($evento['foto']); ?>"
                                 alt="<?php echo htmlspecialchars($evento['titulo']); ?>">
                        </div>
                        <div class="card-body-custom">
                            <h2><?php echo htmlspecialchars($evento['titulo']); ?></h2>
                            <p>
                                <i class="bi bi-calendar-event"></i>
                                <?php echo date('d/m/Y', strtotime($evento['fecha'])); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Modal para cada noticia -->
                <div class="modal fade" id="modalNoticia<?php echo $evento['idevento']; ?>" tabindex="-1" aria-labelledby="modalLabel<?php echo $evento['idevento']; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel<?php echo $evento['idevento']; ?>">
                                    <i class="bi bi-newspaper"></i> <?php echo htmlspecialchars($evento['titulo']); ?>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="../admin/<?php echo htmlspecialchars($evento['foto']); ?>" 
                                     alt="<?php echo htmlspecialchars($evento['titulo']); ?>" 
                                     class="modal-image">
                                
                                <div class="mb-3">
                                    <p class="text-muted">
                                        <i class="bi bi-calendar-event"></i> 
                                        <strong>Fecha:</strong> <?php echo date('d/m/Y', strtotime($evento['fecha'])); ?>
                                    </p>
                                    <?php if (!empty($evento['descripcion'])) { ?>
                                        <p class="text-muted">
                                            <i class="bi bi-clock"></i> 
                                            <strong>Descripción:</strong> <?php echo htmlspecialchars($evento['descripcion']); ?>
                                        </p>
                                    <?php } ?>
                                    <?php if (!empty($evento['hora'])) { ?>
                                        <p class="text-muted">
                                            <i class="bi bi-clock"></i> 
                                            <strong>Hora:</strong> <?php echo htmlspecialchars($evento['hora']); ?>
                                        </p>
                                    <?php } ?>
                                    <?php if (!empty($evento['lugar'])) { ?>
                                        <p class="text-muted">
                                            <i class="bi bi-geo-alt"></i> 
                                            <strong>Lugar:</strong> <?php echo htmlspecialchars($evento['lugar']); ?>
                                        </p>
                                    <?php } ?>
                                </div>
                                
                                <p class="modal-content-text">
                                    <?php echo nl2br(htmlspecialchars($evento['descripcion'] ?? 'Sin descripción disponible')); ?>
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle"></i> Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <?php if (empty($eventos)) { ?>
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info text-center" role="alert">
                        <i class="bi bi-info-circle fs-1 d-block mb-3"></i>
                        <h4>No hay noticias disponibles en este momento</h4>
                        <p class="mb-0">Vuelve pronto para ver las últimas novedades</p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </section>

    <!-- Bootstrap 5 JS Bundle (incluye Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>