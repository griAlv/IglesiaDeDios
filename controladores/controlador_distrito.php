<?php
include_once(__DIR__ . '/../MODELO/modelo_distrito.php');

class controlador_distrito {
    private $modelo_distrito;

    public function __construct() {
        $this->modelo_distrito = new modelo_distrito();
    }

    public function listarDistritos() {
        return $this->modelo_distrito->listarDistritos();
    }

    public function getDistritoPorId($id) {
        if (!is_numeric($id)) {
            return false;
        }
        return $this->modelo_distrito->getDistritoPorId($id);
    }
}
?>