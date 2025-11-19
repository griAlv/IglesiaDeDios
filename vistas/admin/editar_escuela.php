<?php


include_once(__DIR__ . "/../../controladores/controlador_Escuelasabatica.php");
$controlador = new controlador_Escuelasabatica();

$mensaje = '';
$error = '';

// Obtener el ID de la escuela
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    header('Location: /iglesia/vistas/admin/listar_escuelas.php');
    exit();
}

// Obtener datos de la escuela
$escuela = $controlador->getEscuelaSabaticaPorId($id);

if (!$escuela) {
    header('Location: /iglesia/vistas/admin/listar_escuelas.php');
    exit();
}

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $tipo = trim($_POST['tipo']);
    $trimestre = trim($_POST['trimestre']);
    $anio = trim($_POST['anio']);
    $archivo_actual = $escuela['archivo'];
    
    // Validaciones
    if (empty($nombre) || empty($tipo) || empty($trimestre) || empty($anio)) {
        $error = 'Todos los campos son obligatorios.';
    } else {
        // Manejar la subida de archivo si se proporciona uno nuevo
        if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
            $archivo_tmp = $_FILES['archivo']['tmp_name'];
            $archivo_nombre = $_FILES['archivo']['name'];
            $archivo_ext = strtolower(pathinfo($archivo_nombre, PATHINFO_EXTENSION));
            
            if ($archivo_ext !== 'pdf') {
                $error = 'Solo se permiten archivos PDF.';
            } else {
                // Crear nombre único para el archivo
                $nuevo_nombre = 'escuela' . $tipo . '_' . $trimestre . $anio . '_' . time() . '.pdf';
                $ruta_destino = __DIR__ . '/../EscuelasPDF/' . $nuevo_nombre;
                
                // Crear directorio si no existe
                if (!file_exists(__DIR__ . '/../EscuelasPDF/')) {
                    mkdir(__DIR__ . '/../EscuelasPDF/', 0777, true);
                }
                
                if (move_uploaded_file($archivo_tmp, $ruta_destino)) {
                    // Eliminar archivo anterior
                    $archivo_anterior = __DIR__ . '/../' . ltrim($archivo_actual, '/');
                    if (file_exists($archivo_anterior)) {
                        unlink($archivo_anterior);
                    }
                    $archivo_actual = 'EscuelasPDF/' . $nuevo_nombre;
                } else {
                    $error = 'Error al subir el archivo.';
                }
            }
        }
        
        if (empty($error)) {
            $resultado = $controlador->editarEscuela($id, $nombre, $tipo, $trimestre, $anio, $archivo_actual);
            
            if ($resultado) {
                $mensaje = 'Escuela actualizada exitosamente.';
                // Recargar datos actualizados
                $escuela = $controlador->getEscuelaSabaticaPorId($id);
            } else {
                $error = 'Error al actualizar la escuela.';
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
    <title>Editar Escuela Sabática</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen py-8">
    <div class="container mx-auto px-4 max-w-2xl">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-edit text-blue-600"></i> Editar Escuela Sabática
                </h1>
                <a href="/iglesia/vistas/admin/listar_escuelas.php" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>

            <?php if ($mensaje): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <i class="fas fa-check-circle"></i> <?php echo $mensaje; ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-heading"></i> Nombre de la Escuela
                    </label>
                    <input type="text" name="nombre" value="<?php echo htmlspecialchars($escuela['nombre']); ?>" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-tag"></i> Tipo
                    </label>
                    <select name="tipo" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="general" <?php echo $escuela['tipo'] === 'general' ? 'selected' : ''; ?>>General</option>
                        <option value="femenil" <?php echo $escuela['tipo'] === 'femenil' ? 'selected' : ''; ?>>Femenil</option>
                        <option value="juvenil" <?php echo $escuela['tipo'] === 'juvenil' ? 'selected' : ''; ?>>Juvenil</option>
                        <option value="infantil" <?php echo $escuela['tipo'] === 'infantil' ? 'selected' : ''; ?>>Infantil</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-calendar-alt"></i> Trimestre
                    </label>
                    <select name="trimestre" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="primer" <?php echo $escuela['trimestre'] === 'primer' ? 'selected' : ''; ?>>Primer Trimestre</option>
                        <option value="segundo" <?php echo $escuela['trimestre'] === 'segundo' ? 'selected' : ''; ?>>Segundo Trimestre</option>
                        <option value="tercer" <?php echo $escuela['trimestre'] === 'tercer' ? 'selected' : ''; ?>>Tercer Trimestre</option>
                        <option value="cuarto" <?php echo $escuela['trimestre'] === 'cuarto' ? 'selected' : ''; ?>>Cuarto Trimestre</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-calendar"></i> Año
                    </label>
                    <input type="number" name="anio" value="<?php echo htmlspecialchars($escuela['anio']); ?>" 
                           min="2020" max="2100" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-file-pdf"></i> Archivo PDF Actual
                    </label>
                    <div class="bg-gray-50 p-3 rounded border border-gray-300 mb-2">
                        <a href="/iglesia/vistas/<?php echo htmlspecialchars($escuela['archivo']); ?>" target="_blank" class="text-blue-600 hover:underline">
                            <i class="fas fa-external-link-alt"></i> Ver archivo actual
                        </a>
                    </div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        Cambiar archivo (opcional)
                    </label>
                    <input type="file" name="archivo" accept=".pdf" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-sm text-gray-500 mt-1">Deja vacío si no deseas cambiar el archivo</p>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                    <a href="/iglesia/vistas/admin/listar_escuelas.php" class="flex-1 bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition font-semibold text-center">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
