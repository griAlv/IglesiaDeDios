<?php
include_once(__DIR__ . "/../MODELO/modeloactividad.php");
include_once(__DIR__ . "/controladorusuario.php"); 

class ControladorActividad {
    private $modelo;
    
    public function __construct() {
        $this->modelo = new ModeloActividad();
    }

    // Crear nueva actividad
    public function crearActividad($data) {
        $usuario = verificarSesion(); // Usuario logueado
        $creado_por = $usuario['id'];

        // Validar que existan los campos obligatorios
        $nombre = $data['nombre'] ?? '';
        $fecha = $data['fecha'] ?? '';
        $hora = $data['hora'] ?? '';
        $directiva = $data['directiva'] ?? '';
        $costo = $data['costo'] ?? 0;
        $tipo = $data['tipo'] ?? '';
        $lugar = $data['lugar'] ?? '';
        $foto_link = $data['foto_link'] ?? '';
        $extra = $data['extra'] ?? [];

        return $this->modelo->nuevaActividad($nombre, $fecha, $hora, $directiva, $costo, $tipo, $lugar, $foto_link, $creado_por, $extra);
    }


    public function listarActividades() {
        return $this->modelo->listarActividades();
    }

    public function obtenerActividadPorId($id) {
        return $this->modelo->getActividadPorId($id);
    }

    
    public function getActividad($id) {
        return $this->modelo->getActividadPorId($id);
    }

    public function listarPorTipo($tipo) {
        return $this->modelo->listarPorTipo($tipo);
    }
    
    public function actualizarActividad($id, $data) {
        return $this->modelo->actualizarActividad(
            $id,
            $data['nombre'],
            $data['fecha'],
            $data['hora'],
            $data['directiva'],
            $data['costo'],
            $data['tipo'],
            $data['lugar'],
            $data['foto_link'],
            $data['creado_por'],
            isset($data['extra']) ? $data['extra'] : []
        );
    }

    public function eliminarActividad($id) {
        return $this->modelo->eliminarActividad($id);
    }
}
