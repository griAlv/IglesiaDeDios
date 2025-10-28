<?php
include_once(__DIR__ . "/../../controladores/controlador_Escuelasabatica.php");
include_once(__DIR__ . "/../../controladores/controladorusuario.php");

$controlador = new controlador_Escuelasabatica();
$usuario = verificarSesion();
verificarRol(['4']);

if (isset($_POST['agregar'])) {

    if (isset($_FILES["archivo"]) && is_uploaded_file($_FILES['archivo']['tmp_name'])) {

        $tipoArchivo = $_FILES["archivo"]["type"];
        if ($tipoArchivo !== 'application/pdf') {
            echo '<div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <div>⚠️ Solo se permiten archivos PDF</div>
                  </div>';
            exit;
        }

        // ✅ Ruta al directorio de destino
        $directorio = dirname(__DIR__) . "/EscuelasPDF/";

        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $rutaRelativa = "EscuelasPDF/" . $_FILES["archivo"]["name"];
        $rutaAbsoluta = $directorio . $_FILES["archivo"]["name"];

        if (is_file($rutaAbsoluta)) {
            $idUnico = time();
            $rutaRelativa = "EscuelasPDF/" . $idUnico . "-" . $_FILES["archivo"]["name"];
            $rutaAbsoluta = $directorio . $idUnico . "-" . $_FILES["archivo"]["name"];
        }

        if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $rutaAbsoluta)) {
            $archivo = $rutaRelativa;
        } else {
            echo '<div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <div>⚠️ Error al mover el archivo PDF</div>
                  </div>';
            exit;
        }

    } else {
        echo '<div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <div>⚠️ No se ha seleccionado ningún archivo PDF</div>
              </div>';
        exit;
    }

    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $trimestre = $_POST['trimestre'];
    $anio = $_POST['anio'];
    $creado_por_usuario_id = $_SESSION['usuario']['idusuario'] ?? null;
    $fecha_registro = date('Y-m-d H:i:s');

    $controlador->nuevaEscuela($nombre, $tipo, $trimestre, $anio, $creado_por_usuario_id, $fecha_registro, $archivo);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Escuela Sabática</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/agregarescuela.css">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="fas fa-book-open me-2"></i>Agregar Escuela Sabática</h1>
                    <p class="lead mb-0">Complete el formulario para agregar un nuevo material de estudio</p>
                </div>
                <div class="col-md-4 text-end">
                    
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <!-- Form Container -->
        <div class="form-container">
            <h2 class="form-title"><i class="fas fa-plus-circle me-2"></i>Nuevo Material</h2>
            
            <!-- Information Box -->
            <div class="info-box">
                <p class="mb-0">
                    <i class="fas fa-info-circle info-icon"></i>
                    Todos los campos marcados con <span class="text-danger">*</span> son obligatorios. 
                    Solo se permiten archivos en formato PDF.
                </p>
            </div>
            
            <form method="post" action="agregar_escuela.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nombre" class="form-label required-field">
                                <i class="fas fa-heading me-1"></i>Nombre del Material
                            </label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingrese el nombre del material" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tipo" class="form-label required-field">
                                <i class="fas fa-tag me-1"></i>Tipo de Material
                            </label>
                            <select name="tipo" id="tipo" class="form-select" required>
                                <option value="" selected disabled>Seleccione un tipo</option>
                                <option value="juvenil">Juvenil</option>
                                <option value="femenil">Femenil</option>
                                <option value="infantil">Infantil</option>
                                <option value="general">General</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="trimestre" class="form-label required-field">
                                <i class="fas fa-calendar-alt me-1"></i>Trimestre
                            </label>
                            <select name="trimestre" id="trimestre" class="form-select" required>
                                <option value="" selected disabled>Seleccione el trimestre</option>
                                <option value="primer">Primer Trimestre</option>
                                <option value="segundo">Segundo Trimestre</option>
                                <option value="tercer">Tercer Trimestre</option>
                                <option value="cuarto">Cuarto Trimestre</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="anio" class="form-label required-field">
                                <i class="fas fa-calendar me-1"></i>Año
                            </label>
                            <select name="anio" id="anio" class="form-select" required>
                                <option value="" selected disabled>Seleccione el año</option>
                                <!-- Options for years, current year and next 2 years -->
                                <?php
                                    $anioActual = date('Y');
                                    for ($i = $anioActual; $i <= $anioActual + 2; $i++) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="fecha_registro" class="form-label">
                                <i class="fas fa-clock me-1"></i>Fecha de Registro
                            </label>
                            <input type="text" name="fecha_registro" id="fecha_registro" class="form-control" value="<?php echo date('Y-m-d H:i:s'); ?>" readonly>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label required-field">
                        <i class="fas fa-file-pdf me-1"></i>Archivo PDF
                    </label>
                    <div class="file-upload-container">
                        <div class="file-upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <h5>Arrastra y suelta tu archivo PDF aquí</h5>
                        <p class="text-muted">o</p>
                        <input type="file" name="archivo" id="archivo" class="form-control d-none" accept="application/pdf" required>
                        <label for="archivo" class="btn btn-outline-primary">
                            <i class="fas fa-folder-open me-2"></i>Seleccionar Archivo
                        </label>
                        <p class="mt-2 text-muted small">Tamaño máximo: 10MB. Solo se permiten archivos PDF.</p>
                        <div id="file-name" class="mt-2 fw-bold text-primary"></div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="index.php" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                    <button type="submit" name="agregar" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Guardar Material
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Footer -->
        <footer class="text-center text-muted py-4">
            <p>Sistema de Gestión de Escuela Sabática &copy; <?php echo date('Y'); ?></p>
        </footer>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    
    <script>
        // Mostrar nombre del archivo seleccionado
        document.getElementById('archivo').addEventListener('change', function(e) {
            const fileName = document.getElementById('file-name');
            if (this.files.length > 0) {
                fileName.textContent = 'Archivo seleccionado: ' + this.files[0].name;
            } else {
                fileName.textContent = '';
            }
        });
        
        // Efecto de arrastrar y soltar
        const fileUploadContainer = document.querySelector('.file-upload-container');
        const fileInput = document.getElementById('archivo');
        
        fileUploadContainer.addEventListener('dragover', (e) => {
            e.preventDefault();
            fileUploadContainer.style.borderColor = '#3498db';
            fileUploadContainer.style.backgroundColor = '#e1f0fa';
        });
        
        fileUploadContainer.addEventListener('dragleave', () => {
            fileUploadContainer.style.borderColor = '#ced4da';
            fileUploadContainer.style.backgroundColor = '#f8f9fa';
        });
        
        fileUploadContainer.addEventListener('drop', (e) => {
            e.preventDefault();
            fileUploadContainer.style.borderColor = '#ced4da';
            fileUploadContainer.style.backgroundColor = '#f8f9fa';
            
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                const fileName = document.getElementById('file-name');
                fileName.textContent = 'Archivo seleccionado: ' + e.dataTransfer.files[0].name;
            }
        });
        
        // Validación de tipo de archivo
        document.querySelector('form').addEventListener('submit', function(e) {
            const fileInput = document.getElementById('archivo');
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                if (file.type !== 'application/pdf') {
                    e.preventDefault();
                    alert('Error: Solo se permiten archivos PDF.');
                    return false;
                }
                
                // Validación de tamaño (10MB máximo)
                if (file.size > 10 * 1024 * 1024) {
                    e.preventDefault();
                    alert('Error: El archivo es demasiado grande. El tamaño máximo permitido es 10MB.');
                    return false;
                }
            }
        });
    </script>
</body>
</html>