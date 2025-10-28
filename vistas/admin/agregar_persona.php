<?php
include_once(__DIR__ . "/../../controladores/controladorpersona.php");
include_once(__DIR__ . "/../../controladores/controladorusuario.php");

$controlador = new controlador_persona();
$usuario = verificarSesion();
verificarRol(['admin']);

$iglesias = $controlador->listarIglesias();
$distritos = $controlador->listarDistritos();
$tallas = $controlador->listarTallasCamisa();
$condiciones = $controlador->listarCondicionesMedicas();

$mensaje = '';
$tipoMensaje = '';

if (isset($_POST['agregar_persona'])) {
    $resultado = $controlador->nuevaPersona(
        $_POST['nombre'],
        $_POST['apellido'],
        $_POST['edad'],
        $_POST['genero'],
        $_POST['rol'],
        $_POST['estado'],
        $_POST['iglesia_id'],
        $_POST['distrito_id'],
        $_SESSION['usuario']['id'],
        $_POST['talla_camisa_id'],
        $_POST['condicion_medica_id']
    );
    if ($resultado) {
        $mensaje = "Persona agregada exitosamente";
        $tipoMensaje = "success";
    } else {
        $mensaje = "Error al agregar persona";
        $tipoMensaje = "danger";
    }
}
?>

<!-- Contenedor principal -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="mb-0">Agregar Persona</h2>
                </div>
                <div class="card-body">
                    
                    <?php if($mensaje): ?>
                        <div class="alert alert-<?= $tipoMensaje ?> alert-dismissible fade show" role="alert">
                            <?= $mensaje ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="" method="post">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingrese nombre" required>
                            </div>
                            <div class="col-md-6">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Ingrese apellido" required>
                            </div>
                            <div class="col-md-4">
                                <label for="edad" class="form-label">Edad</label>
                                <input type="number" name="edad" id="edad" class="form-control" placeholder="Ingrese edad" required>
                            </div>
                            <div class="col-md-4">
                                <label for="genero" class="form-label">Género</label>
                                <select name="genero" id="genero" class="form-select" required>
                                    <option value="">Seleccione género</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="rol" class="form-label">Rol</label>
                                <select name="rol" id="rol" class="form-select" required>
                                    <option value="visitante">Visitante</option>
                                    <option value="miembro">Miembro</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="estado" class="form-label">Estado</label>
                                <select name="estado" id="estado" class="form-select" required>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="pagado">Pagado</option>
                                    <option value="parcial">Parcial</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="iglesia_id" class="form-label">Iglesia</label>
                                <select name="iglesia_id" id="iglesia_id" class="form-select" required>
                                    <option value="">Seleccione iglesia</option>
                                    <?php foreach($iglesias as $iglesia): ?>
                                        <option value="<?= $iglesia['id'] ?>"><?= $iglesia['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="distrito_id" class="form-label">Distrito</label>
                                <select name="distrito_id" id="distrito_id" class="form-select" required>
                                    <option value="">Seleccione distrito</option>
                                    <?php foreach($distritos as $distrito): ?>
                                        <option value="<?= $distrito['id'] ?>"><?= $distrito['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="talla_camisa_id" class="form-label">Talla de camisa</label>
                                <select name="talla_camisa_id" id="talla_camisa_id" class="form-select" required>
                                    <option value="">Seleccione talla</option>
                                    <?php foreach($tallas as $talla): ?>
                                        <option value="<?= $talla['id'] ?>"><?= $talla['talla'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="condicion_medica_id" class="form-label">Condición médica</label>
                                <select name="condicion_medica_id" id="condicion_medica_id" class="form-select" required>
                                    <option value="">Seleccione condición</option>
                                    <?php foreach($condiciones as $condicion): ?>
                                        <option value="<?= $condicion['id'] ?>"><?= $condicion['descripcion'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" name="agregar_persona" class="btn btn-primary btn-lg">Agregar Persona</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
