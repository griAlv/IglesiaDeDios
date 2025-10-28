<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/iglesia/controladores/controladorusuario.php");

$mensaje = "";
if ($_POST) {
    $mensaje = login();
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-center mb-4">Iniciar Sesión</h2>
                    <?php if ($mensaje): ?>
                        <div class="alert alert-danger"><?php echo $mensaje; ?></div>
                    <?php endif; ?>
                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="email" class="form-label">email</label>
                            <input type="text" class="form-control" id="email" name="email" required>
                           
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="PASSWORD" name="PASSWORD" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                    </form>

                    <hr>
                    
                </div>
            </div>
        </div>
    </div>
</div>
