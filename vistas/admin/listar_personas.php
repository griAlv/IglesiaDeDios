<?php
include_once(__DIR__ . "/../../controladores/controladorpersona.php");

$controlador = new controlador_persona();
$personas = $controlador->listarPersonasDetalladas();

?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <h2>Tabla de las Personas</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Edad</th>
                        <th>Genero</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Iglesia</th>
                        <th>Distrito</th>
                        <th>Talla Camisa</th>
                        <th>Condicion Medica</th>
                        <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($personas as $persona): ?>
                <tr>
                <td><?= $persona['id'] ?></td>
                <td><?= $persona['nombre'] ?></td>
                <td><?= $persona['apellido'] ?></td>
                <td><?= $persona['edad'] ?></td>
                <td><?= $persona['genero'] ?></td>
                <td><?= $persona['rol'] ?></td>
                <td><?= $persona['estado'] ?></td>
                <td><?= $persona['iglesia'] ?></td>
                <td><?= $persona['distrito'] ?></td>
                <td><?= $persona['talla_camisa'] ?></td>
                <td><?= $persona['condicion_medica'] ?></td>
                <td>
                    <a href="editar_persona?id=<?= $persona['id'] ?>" class="btn btn-sm btn-primary">Editar</a>
                    <a href="eliminar_persona?id=<?= $persona['id'] ?>" class="btn btn-sm btn-danger">Eliminar</a>
                </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>  