<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/iglesia/controladores/controlador_grupo.php");
$usuario = verificarSesion();
verificarRol(['4']);



$controlador = new controlador_grupo();
$grupos = $controlador->listarGrupos();

?>

<div class="container mt-4">
    <h2 class="text-center mb-4 text-primary">Lista de Grupos</h2>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered align-middle shadow-sm">
            <thead class="table-primary text-center">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Creado por</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($grupos as $grupo) { ?>
                    <tr>
                        <td><?= htmlspecialchars($grupo['nombre']) ?></td>
                        <td><?= htmlspecialchars($grupo['descripcion']) ?></td>
                        <td><?= htmlspecialchars($grupo['creado_por']) ?></td>
                        <td class="text-center">
                            <a href="editarGrupo?id=<?= $grupo['id'] ?>" class="btn btn-sm btn-warning me-1">
                                ✏️ Editar
                            </a>
                            <a href="eliminarGrupo?id=<?= $grupo['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este grupo?');">
                                🗑️ Eliminar
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>