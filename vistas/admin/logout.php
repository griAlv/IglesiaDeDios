<?php
session_start();
unset($_SESSION['usuario']);
session_destroy();
header("Location: /iglesia/index.php?url=index");
exit();
?>