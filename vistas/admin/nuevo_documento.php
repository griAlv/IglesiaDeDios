<?php
include_once(__DIR__ . "/../../controladores/controlador_documentos.php");

$controlador = new controlador_documentos();
$mensaje = '';
$tipoMensaje = '';

if (isset($_POST['guardar'])) {
    try {
        // Validar que se haya subido un archivo
        if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Error al subir el archivo");
        }

        // Validar campos requeridos
        if (empty($_POST['nombre']) || empty($_POST['descripcion']) || empty($_POST['tipo'])) {
            throw new Exception("Todos los campos son obligatorios");
        }

        // Configurar directorio de destino
        $directorioDestino = __DIR__ . "/../../uploads/documentos/";
        if (!file_exists($directorioDestino)) {
            mkdir($directorioDestino, 0777, true);
        }

        // Obtener información del archivo
        $nombreArchivo = $_FILES['archivo']['name'];
        $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
        $nombreUnico = uniqid() . '_' . time() . '.' . $extension;
        $rutaCompleta = $directorioDestino . $nombreUnico;

        // Validar extensiones permitidas
        $extensionesPermitidas = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'jpg', 'jpeg', 'png'];
        if (!in_array(strtolower($extension), $extensionesPermitidas)) {
            throw new Exception("Tipo de archivo no permitido. Extensiones válidas: " . implode(', ', $extensionesPermitidas));
        }

        // Mover archivo al directorio
        if (!move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaCompleta)) {
            throw new Exception("Error al guardar el archivo en el servidor");
        }

        // Guardar en base de datos
        $creado_por_usuario_id = $_SESSION['usuario']['idusuario'] ?? null;
        
        if (!$creado_por_usuario_id) {
            throw new Exception("Debe iniciar sesión para crear documentos");
        }
        
        $resultado = $controlador->nuevoDocumento(
            $_POST['nombre'],
            'uploads/documentos/' . $nombreUnico,
            $_POST['descripcion'],
            $_POST['tipo'],
            $_POST['visible_publico'],
            $creado_por_usuario_id,
            date('Y-m-d H:i:s')
        );

        if ($resultado) {
            $mensaje = "Documento creado exitosamente";
            $tipoMensaje = "success";
        } else {
            throw new Exception("Error al guardar en la base de datos");
        }

    } catch (Exception $e) {
        $mensaje = "Error: " . $e->getMessage();
        $tipoMensaje = "danger";
        // Si hubo error y el archivo se movió, eliminarlo
        if (isset($rutaCompleta) && file_exists($rutaCompleta)) {
            unlink($rutaCompleta);
        }
    }
}

?>
<?php if ($mensaje): ?>
    <div class="alert alert-<?php echo $tipoMensaje; ?> mt-3"><?php echo $mensaje; ?></div>
<?php endif; ?>

<div class="container mt-4">
    <h2>Nuevo Documento</h2>
    <form action="" method="post" enctype="multipart/form-data" class="mt-3">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del documento *</label>
            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" required>
        </div>
        
        <div class="mb-3">
            <label for="archivo" class="form-label">Archivo *</label>
            <input type="file" name="archivo" id="archivo" class="form-control" required>
            <small class="form-text text-muted">Formatos permitidos: PDF, DOC, DOCX, XLS, XLSX, TXT, JPG, JPEG, PNG</small>
        </div>
        
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción *</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="3" placeholder="Descripción del documento" required></textarea>
        </div>
        
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de documento *</label>
            <select name="tipo" id="tipo" class="form-control" required>
                <option value="">Seleccione un tipo</option>
                <option value="Acta">Acta</option>
                <option value="Informe">Informe</option>
                <option value="Certificado">Certificado</option>
                <option value="Manual">Manual</option>
                <option value="Otro">Otro</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="visible_publico" class="form-label">Visibilidad</label>
            <select name="visible_publico" id="visible_publico" class="form-control">
                <option value="1">Visible para el público</option>
                <option value="0" selected>Solo administradores</option>
            </select>
        </div>
        
        <div class="mb-3">
            <button type="submit" name="guardar" class="btn btn-primary">Guardar Documento</button>
            <a href="index.php?url=listar_documentos" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>