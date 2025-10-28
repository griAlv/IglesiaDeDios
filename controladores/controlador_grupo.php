<?php
include_once(__DIR__ . '/../MODELO/modelo_grupo.php');

class controlador_grupo {
    private $modelo_grupo;

    public function __construct() {
        $this->modelo_grupo = new modelo_grupo();
    }

   
    public function nuevoGrupo($nombre, $descripcion, $creado_por) {
        if (empty($nombre) || !is_numeric($creado_por)) {
            return ['status' => 'error', 'message' => 'Datos de grupo incompletos.'];
        }

        $resultado = $this->modelo_grupo->nuevoGrupo($nombre, $descripcion, $creado_por);

        if ($resultado) {
            return ['status' => 'success', 'message' => 'Grupo creado exitosamente.'];
        } else {
            return ['status' => 'error', 'message' => 'Error al crear el grupo.'];
        }
    }

    public function agregarPersonaAGrupo($persona_id, $grupo_id) {
        if (!is_numeric($persona_id) || !is_numeric($grupo_id)) {
            return ['status' => 'error', 'message' => 'IDs no válidos.'];
        }

        $resultado = $this->modelo_grupo->agregarPersonaAGrupo($persona_id, $grupo_id);
        
        if ($resultado) {
            return ['status' => 'success', 'message' => 'Persona agregada al grupo exitosamente.'];
        } else {
            return ['status' => 'error', 'message' => 'La persona ya pertenece a este grupo o ocurrió un error.'];
        }
    }
    public function editarGrupo($id, $nombre, $descripcion, $creado_por) {
        $resultado = $this->modelo_grupo->editarGrupo($id, $nombre, $descripcion, $creado_por);
        if ($resultado) {
            return ['status' => 'success', 'message' => 'Grupo editado exitosamente.'];
        } else {
            return ['status' => 'error', 'message' => 'Error al editar el grupo.'];
        }
    }
    

    public function getGrupoPorId($id) {
        return $this->modelo_grupo->getGrupoPorId($id);
    }

   
    public function listarGrupos() {
        return $this->modelo_grupo->listarGrupos();
    }
}
?>