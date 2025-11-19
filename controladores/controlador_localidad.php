<?php
include_once(__DIR__ . "/../MODELO/modelo_localidad.php");

class controlador_localidad {
    private $modelo;

    public function __construct() {
        $this->modelo = new modelo_localidad();
    }

    public function listar() {
        try {
            $localidades = $this->modelo->listarLocalidades();
            echo json_encode([
                'success' => true,
                'data' => $localidades
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error al listar localidades: ' . $e->getMessage()
            ]);
        }
    }

    public function obtener($id) {
        try {
            $localidad = $this->modelo->obtenerLocalidad($id);
            if ($localidad) {
                echo json_encode([
                    'success' => true,
                    'data' => $localidad
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Localidad no encontrada'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error al obtener localidad: ' . $e->getMessage()
            ]);
        }
    }

    public function agregar() {
        try {
            $datos = [
                'nombre' => $_POST['nombre'] ?? '',
                'departamento' => $_POST['departamento'] ?? '',
                'ciudad' => $_POST['ciudad'] ?? '',
                'direccion' => $_POST['direccion'] ?? '',
                'lat' => $_POST['lat'] ?? 0,
                'lng' => $_POST['lng'] ?? 0
            ];

            $resultado = $this->modelo->agregarLocalidad($datos);
            
            if ($resultado) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Localidad agregada exitosamente'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al agregar localidad'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error al agregar localidad: ' . $e->getMessage()
            ]);
        }
    }

    public function actualizar($id) {
        try {
            $datos = [
                'nombre' => $_POST['nombre'] ?? '',
                'departamento' => $_POST['departamento'] ?? '',
                'ciudad' => $_POST['ciudad'] ?? '',
                'direccion' => $_POST['direccion'] ?? '',
                'lat' => $_POST['lat'] ?? 0,
                'lng' => $_POST['lng'] ?? 0
            ];

            $resultado = $this->modelo->actualizarLocalidad($id, $datos);
            
            if ($resultado) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Localidad actualizada exitosamente'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al actualizar localidad'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error al actualizar localidad: ' . $e->getMessage()
            ]);
        }
    }

    public function eliminar($id) {
        try {
            $resultado = $this->modelo->eliminarLocalidad($id);
            
            if ($resultado) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Localidad eliminada exitosamente'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al eliminar localidad'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error al eliminar localidad: ' . $e->getMessage()
            ]);
        }
    }
}
?>
