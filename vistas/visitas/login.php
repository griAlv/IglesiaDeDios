<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/iglesia/controladores/controladorusuario.php");

$mensaje = "";
if ($_POST) {
    $mensaje = login();
}
?>

<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; background: radial-gradient(circle at top, #e0f2ff 0, #ffffff 40%, #e5e7eb 100%);">
    <div class="card shadow-lg border-0" style="max-width: 420px; width: 100%;">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">Iniciar Sesión</h4>
        </div>
        <div class="card-body p-4">
            <?php if ($mensaje): ?>
                <div class="alert alert-danger mb-3"><?php echo $mensaje; ?></div>
            <?php endif; ?>
            <form method="post" action="">
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="text" class="form-control" id="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="PASSWORD" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="PASSWORD" name="PASSWORD" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
            </form>
        </div>
        <div class="card-footer text-center text-muted small">
            Acceso para usuarios autorizados del sistema distrital
        </div>
    </div>
</div>
