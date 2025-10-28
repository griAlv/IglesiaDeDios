<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/iglesia/controladores/controlador_evento.php");
$controlador = new controlador_evento();
$eventos = $controlador->listarEventos();

?>

<?php foreach ($eventos as $evento): ?>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($evento['titulo']) ?></h5>
            <p class="card-text"><?= htmlspecialchars($evento['descripcion']) ?></p>
            <p class="card-text"><small class="text-muted">Fecha: <?= htmlspecialchars($evento['fecha']) ?></small></p>
            <img src="<?= htmlspecialchars($evento['foto']) ?>" alt="Imagen del evento" width="150">
            <a href="editar_evento.php?id=<?= htmlspecialchars($evento['idevento']) ?>" class="btn btn-primary">Editar</a>
            <a href="eliminar_evento.php?id=<?= htmlspecialchars($evento['idevento']) ?>" class="btn btn-danger">Eliminar</a>
        </div>
    </div>
<?php endforeach; ?>


