<?php
include_once(__DIR__ . '/../MODELO/modelo_tallacamisa.php');

class controlador_tallacamisa {
    private $modelo_tallacamisa;

    public function __construct() {
        $this->modelo_tallacamisa = new modelo_tallacamisa();
    }
    
    public function listarTallas() {
        return $this->modelo_tallacamisa->listarTallas();
    }


    public function getTallaPorId($id) {
        if (!is_numeric($id)) {
            return false;
        }
        return $this->modelo_tallacamisa->getTallaPorId($id);
    }
}
?>