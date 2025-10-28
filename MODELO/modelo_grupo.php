<?php
include_once(__DIR__ . "/../config/database.php");

class modelo_grupo {
    private $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }


    public function nuevoGrupo($nombre, $descripcion, $creado_por) {
        $sql = "INSERT INTO Grupo (nombre, descripcion, creado_por) VALUES (:nombre, :descripcion, :creado_por)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':creado_por', $creado_por);
        return $stmt->execute();
    }


    public function agregarPersonaAGrupo($persona_id, $grupo_id) {
        // Prevenir duplicados
        if ($this->existePersonaEnGrupo($persona_id, $grupo_id)) {
            return false;
        }else{
            $sql = "INSERT INTO Persona_Grupo (persona_id, grupo_id) VALUES (:persona_id, :grupo_id)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':persona_id', $persona_id);
            $stmt->bindParam(':grupo_id', $grupo_id);
            return $stmt->execute();
        }

        
    }

    public function editarGrupo($id, $nombre, $descripcion, $creado_por) {
    $sql = "UPDATE Grupo 
            SET nombre = :nombre, descripcion = :descripcion, creado_por = :creado_por 
            WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':creado_por', $creado_por);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
    }


    public function getGrupoPorId($id) {
        $sql = "SELECT * FROM Grupo WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
     
    public function getGrupoDisponible() {
        $sql = "SELECT id FROM Grupo LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $grupo = $stmt->fetch(PDO::FETCH_ASSOC);
        return $grupo ? $grupo['id'] : null;
    }

    public function existePersonaEnGrupo($persona_id, $grupo_id) {
        $sql = "SELECT COUNT(*) FROM Persona_Grupo WHERE persona_id = :persona_id AND grupo_id = :grupo_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':persona_id', $persona_id);
        $stmt->bindParam(':grupo_id', $grupo_id);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    
    public function listarPersonasEnGrupo($grupo_id) {
        $sql = "SELECT p.* FROM Persona p
                JOIN Persona_Grupo pg ON p.id = pg.persona_id
                WHERE pg.grupo_id = :grupo_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':grupo_id', $grupo_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
   
    public function listarGrupos() {
        $sql = "SELECT * FROM Grupo";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>