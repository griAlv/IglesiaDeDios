<?php
include_once(__DIR__ . '/../MODELO/modelo_escuela_sabatica.php');
class controlador_Escuelasabatica{
    private $modelo_Escuelasabatica;
    public function __construct() {
        $this->modelo_Escuelasabatica = new modelo_Escuelasabatica();
    }
    public function listarEscuelasSabatica() {
        return $this->modelo_Escuelasabatica->listarEscuelaSabatica();
    }
    public function getEscuelaSabaticaPorId($id) {
        return $this->modelo_Escuelasabatica->getEscuelaSabaticaPorId($id);
    }
    public function nuevaEscuela($nombre,$tipo,$trimestre,$anio,$archivo,$creado_por_usuario_id,$fecha_registro) {
        return $this->modelo_Escuelasabatica->nuevaEscuela($nombre,$tipo,$trimestre,$anio,$archivo,$creado_por_usuario_id,$fecha_registro);
    }
    public function editarEscuela($idescuela_sabatica,$nombre,$tipo,$trimestre,$anio,$archivo) {
        return $this->modelo_Escuelasabatica->editarEscuela($idescuela_sabatica,$nombre,$tipo,$trimestre,$anio,$archivo);
    }
    public function eliminarEscuela($idescuela_sabatica) {
        return $this->modelo_Escuelasabatica->eliminarEscuela($idescuela_sabatica);
    }
}
?>
