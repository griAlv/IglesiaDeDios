<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/iglesia/controladores/controladorhimno.php");
$usuario = verificarSesion();
verificarRol(['admin']);



$controlador = new ControladorHimno();
$himnos = $controlador->listarHimnos();

?>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white text-center">
            <h4>Listado de Himnos</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Número</th>
                            <th>Nombre</th>
                            <th>Letra</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($himnos as $himno): ?>
                        <tr>
                            <td><?= htmlspecialchars($himno['numero']) ?></td>
                            <td><?= htmlspecialchars($himno['nombre']) ?></td>
                            <td><?= nl2br(htmlspecialchars($himno['letra'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($himnos)): ?>
                        <tr>
                            <td colspan="3" class="text-center">No hay himnos registrados</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
