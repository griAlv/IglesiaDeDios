<?php
include_once(__DIR__ . "/../controladores/controlador_evento.php");

$controlador_evento = new controlador_evento();
$eventos = $controlador_evento->listarEventos();

?>
<?php foreach ($eventos as $evento) { ?>
    <div>
        <h2><?php echo $evento['titulo']; ?></h2>
        <p><?php echo $evento['descripcion']; ?></p>
        <p><?php echo $evento['tipo']; ?></p>
        <p><?php echo $evento['fecha']; ?></p>
        <p><?php echo $evento['hora']; ?></p>
        <p><?php echo $evento['iddistrito']; ?></p>
        <p><?php echo $evento['iddepartamento']; ?></p>
        <p><?php echo $evento['creadopor']; ?></p>
        <a href="<?php echo $evento['id']; ?>">Editar</a>
        <a href="<?php echo $evento['id']; ?>">Eliminar</a>
    </div>
<?php } ?>