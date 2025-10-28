<?php
ob_start();

$url = isset($_GET['url']) ? rtrim($_GET['url'], "/") : "inicio";
$archivo = "vistas/visitas/" . $url . ".php";

if (!file_exists($archivo)) {
    header("Location: /iglesia/");
    exit();
}


include "vistas/visitas/header.php";
include $archivo;
include "vistas/visitas/footer.php";

ob_end_flush();
?>

