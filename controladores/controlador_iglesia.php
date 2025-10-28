<?php
include_once(__DIR__ . '/../MODELO/modelo_iglesia.php');

class controlador_iglesia {
    private $modelo_iglesia;

    public function __construct() {
        $this->modelo_iglesia = new modelo_iglesia();
    }

    public function listarIglesias() {
        return $this->modelo_iglesia->listarIglesias();
    }

    public function getIglesiaPorId($id) {
        if (!is_numeric($id)) {
            return false;
        }
        return $this->modelo_iglesia->getIglesiaPorId($id);
    }
}
?>