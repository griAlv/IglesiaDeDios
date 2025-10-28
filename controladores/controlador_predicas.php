<?php
include_once(__DIR__ . '/../MODELO/modelo_predicas.php');

class controlador_predicas {
    private $modelo_predicas;

    public function __construct() {
        $this->modelo_predicas = new modelo_predicas();
    }

    public function listarPredicas() {
        return $this->modelo_predicas->listarPredicas();
    }

    public function getPredicaPorId($id) {
        if (!is_numeric($id)) {
            return false;
        }
        return $this->modelo_predicas->getPredicaPorId($id);
    }
    public function nuevaPredica($titulo, $descripcion, $url_youtube, $miniatura, $predicador, $creadopor)
    {
        $this->modelo_predicas->nuevaPredica($titulo, $descripcion, $url_youtube, $miniatura, $predicador, $creadopor);
    }
    public function eliminarPredica($id)
    {
        $this->modelo_predicas->eliminarPredica($id);
    }
    public function editarPredica($id, $titulo, $descripcion, $url_youtube, $miniatura, $predicador, $creadopor)
    {
        $this->modelo_predicas->editarPredica($id, $titulo, $descripcion, $url_youtube, $miniatura, $predicador, $creadopor);
    }
}