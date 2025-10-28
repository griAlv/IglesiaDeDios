<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Evento - Iglesia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/evento.css">
</head>

 <?php
                        include_once($_SERVER['DOCUMENT_ROOT'] . "/iglesia/controladores/controlador_evento.php");
                        session_start();

                        $controlador = new controlador_evento();
                        $evento = $controlador->getEventoPorId($_GET['id']);

                        if (isset($_POST['editar_evento'])) {
                            $name = $evento['foto']; 

                            if (isset($_FILES["foto"]) && is_uploaded_file($_FILES['foto']['tmp_name'])) {
                                $directorio = __DIR__ . "/Imagenes/imagen/";

                                if (!file_exists($directorio)) {
                                    mkdir($directorio, 0777, true);
                                }

                                $rutaRelativa = "Imagenes/imagen/" . $_FILES["foto"]["name"];
                                $rutaAbsoluta = $directorio . $_FILES["foto"]["name"];

                                if (is_file($rutaAbsoluta)) {
                                    $idUnico = time();
                                    $rutaRelativa = "Imagenes/imagen/" . $idUnico . "-" . $_FILES["foto"]["name"];
                                    $rutaAbsoluta = $directorio . $idUnico . "-" . $_FILES["foto"]["name"];
                                }

                                if (move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaAbsoluta)) {
                                    $name = $rutaRelativa; 
                                } else {
                                    echo '<div class="alert alert-danger d-flex align-items-center" role="alert">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            <div>⚠️ Error al mover la imagen</div>
                                          </div>';
                                }
                            }

                            $controlador->editarEvento(
                                $_GET['id'],
                                $_POST['tipo'],
                                $_POST['titulo'],
                                $_POST['descripcion'],
                                $name,
                                $_POST['lugar'],
                                $_POST['fecha'],
                                $_POST['hora'],
                                $_POST['iddistrito'],
                                $_POST['iddepartamento'],
                                $_SESSION['usuario']['idusuario']
                            );

                            echo '<div class="alert alert-success d-flex align-items-center" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <div>✅ Evento actualizado correctamente</div>
                                  </div>';
                        }
                        ?>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header text-center">
                        <h2 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Editar Evento</h2>
                    </div>
                    <div class="card-body p-4">
                       

                        <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h4 class="section-title">Información Básica</h4>
                                    
                                    <div class="mb-3">
                                        <label for="tipo" class="form-label required">Tipo de Evento</label>
                                        <select class="form-select" id="tipo" name="tipo" required>
                                            <option value="" disabled>Seleccione un tipo</option>
                                            <option value="Misa" <?= $evento['tipo'] == 'Misa' ? 'selected' : '' ?>>Misa</option>
                                            <option value="Bautizo" <?= $evento['tipo'] == 'Bautizo' ? 'selected' : '' ?>>Bautizo</option>
                                            <option value="Comunión" <?= $evento['tipo'] == 'Comunión' ? 'selected' : '' ?>>Comunión</option>
                                            <option value="Confirmación" <?= $evento['tipo'] == 'Confirmación' ? 'selected' : '' ?>>Confirmación</option>
                                            <option value="Matrimonio" <?= $evento['tipo'] == 'Matrimonio' ? 'selected' : '' ?>>Matrimonio</option>
                                            <option value="Concierto" <?= $evento['tipo'] == 'Concierto' ? 'selected' : '' ?>>Concierto</option>
                                            <option value="Conferencia" <?= $evento['tipo'] == 'Conferencia' ? 'selected' : '' ?>>Conferencia</option>
                                            <option value="Otro" <?= $evento['tipo'] == 'Otro' ? 'selected' : '' ?>>Otro</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Por favor seleccione un tipo de evento.
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="titulo" class="form-label required">Título del Evento</label>
                                        <input type="text" class="form-control" id="titulo" name="titulo" value="<?= htmlspecialchars($evento['titulo']) ?>" required>
                                        <div class="invalid-feedback">
                                            Por favor ingrese un título para el evento.
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="descripcion" class="form-label required">Descripción</label>
                                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?= htmlspecialchars($evento['descripcion']) ?></textarea>
                                        <div class="invalid-feedback">
                                            Por favor ingrese una descripción para el evento.
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <h4 class="section-title">Ubicación y Fecha</h4>
                                    
                                    <div class="mb-3">
                                        <label for="lugar" class="form-label required">Lugar</label>
                                        <input type="text" class="form-control" id="lugar" name="lugar" value="<?= htmlspecialchars($evento['lugar']) ?>" required>
                                        <div class="invalid-feedback">
                                            Por favor ingrese el lugar del evento.
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="fecha" class="form-label required">Fecha</label>
                                                <input type="date" class="form-control" id="fecha" name="fecha" value="<?= htmlspecialchars($evento['fecha']) ?>" required>
                                                <div class="invalid-feedback">
                                                    Por favor seleccione una fecha.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="hora" class="form-label required">Hora</label>
                                                <input type="time" class="form-control" id="hora" name="hora" value="<?= htmlspecialchars($evento['hora']) ?>" required>
                                                <div class="invalid-feedback">
                                                    Por favor seleccione una hora.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="iddepartamento" class="form-label required">Departamento</label>
                                                <input type="text" class="form-control" id="iddepartamento" name="iddepartamento" value="<?= htmlspecialchars($evento['iddepartamento']) ?>" required>
                                                <div class="invalid-feedback">
                                                    Por favor ingrese el departamento.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="iddistrito" class="form-label required">Distrito</label>
                                                <input type="text" class="form-control" id="iddistrito" name="iddistrito" value="<?= htmlspecialchars($evento['iddistrito']) ?>" required>
                                                <div class="invalid-feedback">
                                                    Por favor ingrese el distrito.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h4 class="section-title">Imagen del Evento</h4>
                                    <div class="row align-items-center">
                                        <div class="col-md-4 mb-3">
                                            <div class="image-preview text-center">
                                                <p class="mb-2"><strong>Imagen Actual</strong></p>
                                                <img src="<?= htmlspecialchars($evento['foto']) ?>" alt="Imagen actual del evento" class="current-image">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label for="foto" class="form-label">Cambiar Imagen</label>
                                                <div class="upload-area border rounded p-4 text-center">
                                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                                    <p class="mb-2">Haga clic aquí o arrastre una imagen para subir</p>
                                                    <p class="small text-muted">Formatos recomendados: JPG, PNG (Máx. 5MB)</p>
                                                    <input type="file" class="form-control d-none" id="foto" name="foto" accept="image/*">
                                                    <button type="button" class="btn btn-outline-primary mt-2" onclick="document.getElementById('foto').click()">
                                                        <i class="fas fa-folder-open me-1"></i> Seleccionar Archivo
                                                    </button>
                                                </div>
                                                <div id="file-name" class="mt-2 small text-muted"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between mt-4">
                                <a href="javascript:history.back()" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Volver
                                </a>
                                <button type="submit" name="editar_evento" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Actualizar Evento
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
        
        // Mostrar nombre del archivo seleccionado
        document.getElementById('foto').addEventListener('change', function(e) {
            var fileName = e.target.files[0] ? e.target.files[0].name : 'No se seleccionó ningún archivo';
            document.getElementById('file-name').textContent = 'Archivo seleccionado: ' + fileName;
        });
        
        // Efecto de arrastrar y soltar para el área de carga
        const uploadArea = document.querySelector('.upload-area');
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.style.borderColor = 'var(--primary-color)';
            uploadArea.style.backgroundColor = 'rgba(52, 152, 219, 0.05)';
        });
        
        uploadArea.addEventListener('dragleave', () => {
            uploadArea.style.borderColor = '#ddd';
            uploadArea.style.backgroundColor = '#f9f9f9';
        });
        
        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.style.borderColor = '#ddd';
            uploadArea.style.backgroundColor = '#f9f9f9';
            
            if (e.dataTransfer.files.length) {
                document.getElementById('foto').files = e.dataTransfer.files;
                document.getElementById('file-name').textContent = 'Archivo seleccionado: ' + e.dataTransfer.files[0].name;
            }
        });
    </script>
</body>
</html>