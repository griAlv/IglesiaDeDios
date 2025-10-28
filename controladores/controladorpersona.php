<?php
include_once(__DIR__ . "/../modelo/modelo_persona.php");

class controlador_persona {
    private $modelo_persona;

    public function __construct() {
        $this->modelo_persona = new modelo_persona();
    }

    // ============================
    // Listados para catálogos
    // ============================
    public function listarIglesias() {
        return $this->modelo_persona->listarIglesias();
    }

    public function listarDistritos() {
        return $this->modelo_persona->listarDistritos();
    }

    public function listarTallasCamisa() {
        return $this->modelo_persona->listarTallasCamisa();
    }

    public function listarCondicionesMedicas() {
        return $this->modelo_persona->listarCondicionesMedicas();
    }

    public function listarActividades() {
        return $this->modelo_persona->listarActividades();
    }

    // ============================
    // Registrar persona e inscripción
    // ============================
    public function registrarPersonaEInscripcion($datos) {
        return $this->modelo_persona->registrarPersonaEInscripcion($datos);
    }
    public function persona(){
        return $this->modelo_persona->persona();
    }
    public function listarPersonasDetalladas() {
        return $this->modelo_persona->listarPersonasDetalladas();
    }
}
?>
