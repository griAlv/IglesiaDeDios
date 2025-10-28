<?php
include_once(__DIR__ . "/../../controladores/controladorusuario.php");
include_once(__DIR__ . "/../../controladores/controladorhimno.php");

$usuario = verificarSesion();
verificarRol(['4']);
$controlador = new controladorhimno();

if (isset($_POST['guardar'])) {
    $numero = $_POST['numero'];
    $nombre = $_POST['nombre'];
    $letra = $_POST['letra'];
    $creado_por = $_SESSION['usuario']['id'];
    $controlador->nuevoHimno($numero, $nombre, $letra,$creado_por);
}
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Agregar Himno</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_POST['guardar']) && !$controlador->existeHimno($_POST['numero'])) { ?>
                        <div class="alert alert-danger">El número del himno ya existe.</div>
                    <?php } ?>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="numero" class="form-label">Número</label>
                            <input type="number" name="numero" id="numero" class="form-control" placeholder="Ingrese número" required>
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingrese nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="letra" class="form-label">Letra</label>
                            <textarea name="letra" id="letra" class="form-control" rows="5" placeholder="Ingrese la letra del himno" required></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" name="guardar" class="btn btn-success btn-lg">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>