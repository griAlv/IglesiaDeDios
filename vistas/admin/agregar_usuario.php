<?php
include_once(__DIR__ . "/../../controladores/controladorusuario.php");
$usuario = verificarSesion();
verificarRol(['admin']);
$controlador = new ControladorUsuario();

if (isset($_POST['guardar'])) {
    try {
        $controlador->nuevoUsuario(
            $_POST['nombre'],
            $_POST['email'],
            $_POST['password'],
            $_POST['rol'],
            $_POST['estado']
        );
       echo "<div class='alert alert-success mt-3'>Usuario creado exitosamente.</div>";
       
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}


?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Agregar Usuario</h3>
                </div>
                <div class="card-body">
                    <form method="post">
                        <!-- Nombre -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email"  class="form-control" required>
                        </div>

                        <!-- Rol -->
                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol</label>
                            <select id="rol" name="rol" class="form-select" required>
                                <option value="admin" >Admin</option>
                                <option value="distrital" >Distrital</option>
                                <option value="nacional" >Nacional</option>
                                <option value="visitante" >Visitante</option>
                                <option value="miembro" >Miembro</option>
                            </select>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <small class="text-muted">(dejar vacío si no cambia)</small></label>
                            <input type="password" id="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select id="estado" name="estado" class="form-select" required>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-between">
                            <a href="/iglesia/vistas/admin/listar_usuarios.php" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" name="guardar" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>