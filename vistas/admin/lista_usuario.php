<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/iglesia/controladores/controladorusuario.php");
$usuario = verificarSesion();
verificarRol(['4']);



$controlador = new ControladorUsuario();
$usuarios = $controlador->listarUsuarios();

?>


<div class="container mt-4">
    <h2 class="mb-3">Lista de Usuarios</h2>
    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Fecha de creación</th>
                <th>Fecha de modificación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
            <tr>            
                <td><?= htmlspecialchars($usuario['id']) ?></td>
                <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                <td><?= htmlspecialchars($usuario['email']) ?></td>
                <td><?= htmlspecialchars($usuario['rol']) ?></td>
                <td><?= htmlspecialchars($usuario['estado']) ?></td>
                <td><?= htmlspecialchars($usuario['creado_en']) ?></td>
                <td><?= htmlspecialchars($usuario['fecha_modificacion']) ?></td>
                
                <td>
                    <a href="editar_usuario?id=<?= $usuario['id'] ?>" class="btn btn-sm btn-primary">Editar</a>
                    <a href="eliminar_usuario?id=<?= $usuario['id'] ?>" class="btn btn-sm btn-danger">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

