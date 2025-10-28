<?php
include_once(__DIR__ . "/../MODELO/modelohimno.php");
class controladorhimno{
    public function __construct() {
        $this->modelo_himno = new ModeloHimno();
    }
    public function nuevoHimno($numero, $nombre, $letra,$creado_por) {
        $this->modelo_himno->nuevoHimno($numero, $nombre, $letra,$creado_por);
    }
    public function eliminarHimno($id) {
        $this->modelo_himno->eliminarHimno($id);
    }
    public function editarHimno($id, $numero, $nombre, $letra,$creado_por) {
        $this->modelo_himno->editarHimno($id, $numero, $nombre, $letra,$creado_por);
    }
    public function buscarHimno($id) {
        return $this->modelo_himno->buscarHimno($id);
    }
    public function listarHimnos() {
        return $this->modelo_himno->listarHimnos();
    }
    public function existeHimno($numero) {
    $query = "SELECT COUNT(*) FROM Himno WHERE numero = :numero";
    $stmt = $this->modelo_himno->prepare($query);
    $stmt->bindParam(':numero', $numero);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
    }

    public function obtenerHimno($id) {
        return $this->buscarHimno($id); // alias de buscarHimno
    }
    
}
?>