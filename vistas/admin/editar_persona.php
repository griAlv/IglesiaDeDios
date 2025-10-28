<?php
include_once(__DIR__ . "/../../controladores/controladorpersona.php");
include_once(__DIR__ . "/../../controladores/controladorusuario.php");

$controlador = new controlador_persona();
$usuario = verificarSesion();
verificarRol(['4']);
$idPersona = isset($_GET['id']) ? intval($_GET['id']) : 0;
$persona = $controlador->getPersonaPorId($idPersona);

if (isset($_POST['editar_persona'])) {
    $controlador->editarPersona(
        $idPersona,
        $_POST['nombre'],
        $_POST['apellido'],
        $_POST['edad'],
        $_POST['genero'],
        $_POST['rol'],
        $_POST['estado'],
        $_POST['cantidad_pagos'],
        $_POST['monto_total'] ?? 0,
        $_POST['iglesia_id'],
        $_POST['distrito_id'],
        $_SESSION['usuario']['id'],
        $_POST['talla_camisa_id'],
        $_POST['condicion_medica_id']
    );
}
?>

<style>
body {
    background-color: #f8f9fa;
}
.card-custom {
    max-width: 800px;
    margin: 50px auto;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}
.card-header {
    background-color: #0d6efd;
    color: white;
    font-weight: 600;
    text-align: center;
    font-size: 1.5rem;
}
.form-label {
    font-weight: 500;
}
.btn-primary {
    background-color: #0d6efd;
    border: none;
}
.btn-primary:hover {
    background-color: #0b5ed7;
}
</style>

<div class="card card-custom">
    <div class="card-header">Editar Persona</div>
    <div class="card-body">
        <form action="" method="post">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($persona['nombre']) ?>" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" name="apellido" id="apellido" value="<?= htmlspecialchars($persona['apellido']) ?>" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label for="edad" class="form-label">Edad</label>
                    <input type="number" name="edad" id="edad" value="<?= htmlspecialchars($persona['edad']) ?>" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label for="genero" class="form-label">Género</label>
                    <select name="genero" id="genero" class="form-select" required>
                        <option value="">Seleccione género</option>
                        <option value="M" <?= $persona['genero'] == 'M' ? 'selected' : '' ?>>Masculino</option>
                        <option value="F" <?= $persona['genero'] == 'F' ? 'selected' : '' ?>>Femenino</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="rol" class="form-label">Rol</label>
                    <select name="rol" id="rol" class="form-select" required>
                        <option value="visitante" <?= $persona['rol'] == 'visitante' ? 'selected' : '' ?>>Visitante</option>
                        <option value="miembro" <?= $persona['rol'] == 'miembro' ? 'selected' : '' ?>>Miembro</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select name="estado" id="estado" class="form-select" required>
                        <option value="pendiente" <?= $persona['estado'] == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                        <option value="pagado" <?= $persona['estado'] == 'pagado' ? 'selected' : '' ?>>Pagado</option>
                        <option value="parcial" <?= $persona['estado'] == 'parcial' ? 'selected' : '' ?>>Parcial</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="cantidad_pagos" class="form-label">Cantidad de pagos</label>
                    <input type="number" name="cantidad_pagos" id="cantidad_pagos" value="<?= htmlspecialchars($persona['cantidad_pagos']) ?>" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label for="iglesia_id" class="form-label">Iglesia</label>
                    <select name="iglesia_id" id="iglesia_id" class="form-select" required>
                        <option value="">Seleccione iglesia</option>
                        <?php
                        $db = new PDO("mysql:host=localhost;dbname=iglesia;charset=utf8", "root", "");
                        $stmt = $db->query("SELECT id, nombre FROM Iglesia");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $selected = $persona['iglesia_id'] == $row['id'] ? 'selected' : '';
                            echo "<option value='{$row['id']}' $selected>{$row['nombre']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="distrito_id" class="form-label">Distrito</label>
                    <select name="distrito_id" id="distrito_id" class="form-select" required>
                        <option value="">Seleccione distrito</option>
                        <?php
                        $stmt = $db->query("SELECT id, nombre FROM Distrito");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $selected = $persona['distrito_id'] == $row['id'] ? 'selected' : '';
                            echo "<option value='{$row['id']}' $selected>{$row['nombre']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="actividad_id" class="form-label">Actividad</label>
                    <select name="actividad_id" id="actividad_id" class="form-select" required>
                        <option value="">Seleccione actividad</option>
                        <?php
                        $stmt = $db->query("SELECT id, nombre FROM Actividad");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $selected = $persona['actividad_id'] == $row['id'] ? 'selected' : '';
                            echo "<option value='{$row['id']}' $selected>{$row['nombre']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="talla_camisa_id" class="form-label">Talla de camisa</label>
                    <select name="talla_camisa_id" id="talla_camisa_id" class="form-select" required>
                        <option value="">Seleccione talla</option>
                        <?php
                        $stmt = $db->query("SELECT id, talla FROM Talla_Camisa");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $selected = $persona['talla_camisa_id'] == $row['id'] ? 'selected' : '';
                            echo "<option value='{$row['id']}' $selected>{$row['talla']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="condicion_medica_id" class="form-label">Condición médica</label>
                    <select name="condicion_medica_id" id="condicion_medica_id" class="form-select" required>
                        <option value="">Seleccione condición</option>
                        <?php
                        $stmt = $db->query("SELECT id, descripcion FROM Condicion_Medica");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $selected = $persona['condicion_medica_id'] == $row['id'] ? 'selected' : '';
                            echo "<option value='{$row['id']}' $selected>{$row['descripcion']}</option>";
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="d-grid mt-4">
                <button type="submit" name="editar_persona" class="btn btn-primary btn-lg">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>
