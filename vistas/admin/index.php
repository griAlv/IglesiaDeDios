<?php
ob_start();
include_once(__DIR__ . "/../../controladores/controladorusuario.php");
$usuario = verificarSesion();
verificarRol(['4']);

$url = isset($_GET['url']) ? basename(rtrim($_GET['url'], "/")) : "dashboard_admin";

$archivo = __DIR__ . "/" . $url . ".php";

if (!file_exists($archivo)) {
    header("Location: index.php?url=dashboard_admin");
    exit();
}
include __DIR__ . "/header.php";
include $archivo;
include __DIR__ . "/footer.php";
ob_end_flush();
?>