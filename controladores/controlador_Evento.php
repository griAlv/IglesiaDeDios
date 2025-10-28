<?php
include_once(__DIR__ . '/../MODELO/modelo_Evento.php');

class controlador_Evento{
    private $modelo_Evento;
    public function __construct() {
        $this->modelo_Evento = new modelo_Evento();
    }
    public function listarEventos() {
        return $this->modelo_Evento->listarEventos();
    }
    public function listarEventosRecientes($limite = 3) {
        return $this->modelo_Evento->listarEventosRecientes($limite);
    }
    public function getEventoPorId($idevento) {
        return $this->modelo_Evento->getEventoPorId($idevento);
    }
   public function nuevoEvento($tipo, $titulo, $descripcion, $foto, $lugar, $fecha, $hora, $iddistrito, $iddepartamento, $creadopor) {
        $modelo = new modelo_evento();
        $existe = $modelo->existeEventoMismoDiaHora($fecha, $hora);

        if ($existe) {
            echo '<div class="alert alert-warning d-flex align-items-center" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <div>⚠️ Este evento ya fue creado para esta fecha y hora</div>
                  </div>';
        } else {
            $modelo->nuevoEvento($tipo, $titulo, $descripcion, $foto, $lugar, $fecha, $hora, $iddistrito, $iddepartamento, $creadopor);
            echo '<div class="alert alert-success d-flex align-items-center" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <div>✅ Evento guardado correctamente</div>
                  </div>';
        }
    }
    public function editarEvento($idevento, $tipo, $titulo, $descripcion, $foto, $lugar, $fecha, $hora, $iddistrito, $iddepartamento, $creadopor) {
        return $this->modelo_Evento->editarEvento($idevento, $tipo, $titulo, $descripcion, $foto, $lugar, $fecha, $hora, $iddistrito, $iddepartamento, $creadopor);
    }
    public function eliminarEvento($idevento) {
        return $this->modelo_Evento->eliminarEvento($idevento);
    }
}
?>