<?php 
include_once(__DIR__ . '/../MODELO/modelo_documentos.php');


class controlador_documentos {
    private $modelo_documentos;
    public function __construct() {
        $this->modelo_documentos = new modelo_documentos();
    }
    public function listarDocumentos() {
        return $this->modelo_documentos->listarDocumentos();
    }
    public function getDocumentoPorId($id) {
        if (!is_numeric($id)) {
            return false;
        }
        return $this->modelo_documentos->getDocumentoPorId($id);
    }
    public function nuevoDocumento($nombre, $archivo, $descripcion, $tipo, $visible_publico, $creadopor, $fecha_creacion){
        return $this->modelo_documentos->nuevoDocumento($nombre, $archivo, $descripcion, $tipo, $visible_publico, $creadopor, $fecha_creacion);
    }
}
?>