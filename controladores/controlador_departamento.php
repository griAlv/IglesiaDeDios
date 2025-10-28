<?php
include_once(__DIR__ . '/../MODELO/modelo_departamento.php');

class controlador_departamento {
    private $modelo_departamento;

    public function __construct() {
        $this->modelo_departamento = new modelo_departamento();
    }

    public function listarDepartamentos() {
        return $this->modelo_departamento->listarDepartamentos();
    }

    public function getDepartamentoPorId($id) {
        if (!is_numeric($id)) {
            return false;
        }
        return $this->modelo_departamento->getDepartamentoPorId($id);
    }
}