<?php
session_start();

// Comentar temporalmente la validación de admin para debug
// if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
//     header('Location: /iglesia/vistas/admin/login.php');
//     exit();
// }

include_once(__DIR__ . "/../../controladores/controlador_Escuelasabatica.php");
$controlador = new controlador_Escuelasabatica();

// Obtener el ID de la escuela
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    $_SESSION['mensaje_error'] = 'ID de escuela inválido.';
    header('Location: /iglesia/vistas/admin/listar_escuelas.php');
    exit();
}

// Obtener datos de la escuela
$escuela = $controlador->getEscuelaSabaticaPorId($id);

if (!$escuela) {
    $_SESSION['mensaje_error'] = 'Escuela no encontrada (ID: ' . $id . ').';
    header('Location: /iglesia/vistas/admin/listar_escuelas.php');
    exit();
}

// Eliminar la escuela
try {
    $resultado = $controlador->eliminarEscuela($id);
    
    if ($resultado) {
        $_SESSION['mensaje_exito'] = 'Escuela "' . $escuela['nombre'] . '" eliminada exitosamente.';
    } else {
        $_SESSION['mensaje_error'] = 'Error al eliminar la escuela. No se pudo ejecutar la operación.';
    }
} catch (Exception $e) {
    $_SESSION['mensaje_error'] = 'Error al eliminar: ' . $e->getMessage();
}

header('Location: /iglesia/vistas/admin/listar_escuelas.php');
exit();
?>
