<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/iglesia/controladores/controlador_evento.php");
$controlador = new controlador_evento();

$evento = $controlador->getEventoPorId($_GET['id']);

if ($evento && !empty($evento['foto'])) {
    $rutaImagen = $_SERVER['DOCUMENT_ROOT'] . '/iglesia/vistas/admin/' . $evento['foto'];
    
    if (file_exists($rutaImagen)) {
        unlink($rutaImagen);
    }
}


$controlador->eliminarEvento($_GET['id']);

header("Location: index.php?url=todos_evetos");
?>