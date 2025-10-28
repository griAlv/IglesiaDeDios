<?php 
include_once(__DIR__ . "/../../controladores/controlador_evento.php");
include_once(__DIR__ . "/../../controladores/controlador_distrito.php");
include_once(__DIR__ . "/../../controladores/controlador_departamento.php");
$controlador = new controlador_evento();
$controlador_distrito = new controlador_distrito();
$distritos = $controlador_distrito->listarDistritos();

$controlador_departamento = new controlador_departamento();
$departamentos = $controlador_departamento->listarDepartamentos();
$name = "";
if (isset($_POST['guardar'])) {
                             

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

                            $controlador->nuevoEvento(
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

                            
                        }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Evento</title>
  
    <link rel="stylesheet" href="../css/evento1.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header text-center">
                        <h2 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Guardar Evento</h2>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" enctype="multipart/form-data">
                            
                            <div class="form-section">
                                <h4 class="section-title"><i class="fas fa-info-circle me-2"></i>Información Básica</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tipo" class="form-label required-field">Tipo de Evento</label>
                                        <input type="text" class="form-control" name="tipo" id="tipo" placeholder="Ej: Conferencia, vigilia" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="titulo" class="form-label required-field">Título del Evento</label>
                                        <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Ingresa un título atractivo" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label required-field">Descripción</label>
                                    <textarea class="form-control" name="descripcion" id="descripcion" rows="3" placeholder="Describe tu evento de manera clara y atractiva" required></textarea>
                                </div>
                            </div>
                            
                            
                            <div class="form-section">
                                <h4 class="section-title"><i class="fas fa-image me-2"></i>Imagen del Evento</h4>
                                <div class="mb-3">
                                    <label class="form-label required-field">Foto del Evento</label>
                                    <div class="file-upload-container">
                                        <label class="file-upload-label" for="foto">
                                            <i class="fas fa-cloud-upload-alt file-icon"></i>
                                            <span id="file-name">Selecciona una imagen</span>
                                        </label>
                                        <input type="file" class="form-control" name="foto" id="foto" accept="image/*" required>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="form-section">
                                <h4 class="section-title"><i class="fas fa-map-marker-alt me-2"></i>Ubicación</h4>
                                <div class="mb-3">
                                    <label for="lugar" class="form-label required-field">Lugar del Evento</label>
                                    <input type="text" class="form-control" name="lugar" id="lugar" placeholder="Ej: Centro de Convenciones, Parque Central..." required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="iddistrito" class="form-label required-field">Distrito</label>
                                        <select class="form-select" name="iddistrito" id="iddistrito" required>
                                            <option value="">Seleccionar distrito</option>
                                            <?php foreach ($distritos as $distrito): ?>
                                                <option value="<?= $distrito['iddistrito'] ?>"><?= $distrito['nombre'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="iddepartamento" class="form-label required-field">Departamento</label>
                                        <select class="form-select" name="iddepartamento" id="iddepartamento" required>
                                            <option value="">Seleccionar departamento</option>
                                            <?php foreach ($departamentos as $departamento): ?>
                                                <option value="<?= $departamento['iddepartamento'] ?>"><?= $departamento['nombre'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="form-section">
                                <h4 class="section-title"><i class="far fa-clock me-2"></i>Fecha y Hora</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fecha" class="form-label required-field">Fecha del Evento</label>
                                        <input type="date" class="form-control" name="fecha" id="fecha" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="hora" class="form-label required-field">Hora del Evento</label>
                                        <input type="time" class="form-control" name="hora" id="hora" required>
                                    </div>
                                </div>
                            </div>
                            
                                                
                            <div class="text-center mt-4">
                                <button type="submit" name="guardar" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Guardar Evento
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
    <script>
    
        document.getElementById('foto').addEventListener('change', function(e) {
            var fileName = e.target.files[0] ? e.target.files[0].name : 'Selecciona una imagen';
            document.getElementById('file-name').textContent = fileName;
        });
        
        // Establecer la fecha mínima como hoy
        document.getElementById('fecha').min = new Date().toISOString().split("T")[0];
    </script>
</body>
</html>