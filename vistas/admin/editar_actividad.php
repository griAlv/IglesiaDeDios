<?php
include_once(__DIR__ . "/../../controladores/ControladorActividad.php");
include_once(__DIR__ . "/../../controladores/controladorusuario.php");

// Verificar sesión
$usuario = verificarSesion();
verificarRol(['admin', 'distrital', 'nacional']);

$controlador = new ControladorActividad();
$actividad = $controlador->getActividad($_GET['id']);

if (isset($_POST['editar'])) {

    $foto_link = '';
    if (isset($_FILES["foto_link"]) && is_uploaded_file($_FILES['foto_link']['tmp_name'])) {
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/iglesia/recursos/imagenes/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9_.]/', '_', basename($_FILES["foto_link"]["name"]));
        $targetFile = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES["foto_link"]["tmp_name"], $targetFile)) {
           
            $foto_link = $fileName;
        } else {
            echo "<div class='alert alert-warning'>Error al subir la imagen. Por favor, inténtelo de nuevo.</div>";
        }
    }

    $data = [
        'nombre' => $_POST['nombre'],
        'fecha' => $_POST['fecha'],
        'hora' => $_POST['hora'],
        'directiva' => $_POST['directiva'],
        'costo' => $_POST['costo'],
        'tipo' => $_POST['tipo'],
        'lugar' => $_POST['lugar'],
        'creado_por' => $usuario['id'],
        'foto_link' => $foto_link,
        'extra' => $_POST['extra'] ?? [] // Datos adicionales según tipo
    ];

    $resultado = $controlador->actualizarActividad($_GET['id'], $data);

    if ($resultado['status'] == 'success') {
        echo "<div class='alert alert-success'>Actividad editada con ID: " . $resultado['actividad_id'] . "</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $resultado['message'] . "</div>";
    }
}
?>

<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">Editar Actividad</h4>
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data" class="row g-3">

                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="<?= htmlspecialchars($actividad['nombre']) ?>" placeholder="Nombre de la actividad" required>
                </div>

                <div class="col-md-6">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" value="<?= htmlspecialchars($actividad['fecha']) ?>" required>
                </div>

                <div class="col-md-6">
                    <label for="hora" class="form-label">Hora</label>
                    <input type="time" name="hora" id="hora" class="form-control" value="<?= htmlspecialchars($actividad['hora']) ?>">
                </div>

                <div class="col-md-6">
                    <label for="directiva" class="form-label">Directiva</label>
                    <input type="text" name="directiva" id="directiva" class="form-control" value="<?= htmlspecialchars($actividad['directiva']) ?>" placeholder="Directiva de la actividad" required>
                </div>

                <div class="col-md-6">
                    <label for="costo" class="form-label">Costo</label>
                    <input type="number" step="0.01" name="costo" id="costo" class="form-control" value="<?= htmlspecialchars($actividad['costo']) ?>" placeholder="0.00">
                </div>

                <div class="col-md-6">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select name="tipo" id="tipo" class="form-select" required value="<?= htmlspecialchars($actividad['tipo']) ?>">
                        <option value="">Selecciona un tipo</option>
                        <option value="vigilia">Vigilia</option>
                        <option value="convencion">Convención</option>
                        <option value="campamento">Campamento</option>
                        <option value="excursion">Excursión</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="lugar" class="form-label">Lugar</label>
                    <input type="text" name="lugar" id="lugar" class="form-control" value="<?= htmlspecialchars($actividad['lugar']) ?>" placeholder="Lugar de la actividad" required>
                </div>

                <div class="col-md-6">
                    <label for="foto_link" class="form-label">Foto del evento</label>
                    <input type="file" name="foto_link" value="<?= htmlspecialchars($actividad['foto_link']) ?>" id="foto_link" class="form-control">
                </div>

                <div class="col-12 text-end">
                    <button type="submit" name="editar" class="btn btn-success px-4">Editar</button>
                </div>
            </form>
        </div>
    </div>
</div>
