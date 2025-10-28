<?php
include_once(__DIR__ . "/../config/database.php");
class modelo_Escuelasabatica{

    private $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }

    public function listarEscuelaSabatica() {
        $sql = "SELECT * FROM escuela_sabatica ORDER BY tipo ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEscuelaSabaticaPorId($id) {
        $sql = "SELECT * FROM escuela_sabatica WHERE idescuela_sabatica = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function nuevaEscuela($nombre, $tipo, $trimestre, $anio, $creado_por_usuario_id, $fecha_registro, $archivo) {
        try {
            $sql = "INSERT INTO escuela_sabatica (nombre, tipo, trimestre, anio, creado_por_usuario_id, fecha_registro, archivo) 
                    VALUES (:nombre, :tipo, :trimestre, :anio, :creado_por_usuario_id, :fecha_registro, :archivo)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
            $stmt->bindParam(':trimestre', $trimestre, PDO::PARAM_STR);
            $stmt->bindParam(':anio', $anio, PDO::PARAM_STR);
            $stmt->bindParam(':creado_por_usuario_id', $creado_por_usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(':fecha_registro', $fecha_registro, PDO::PARAM_STR);
            $stmt->bindParam(':archivo', $archivo, PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en nuevaEscuela: " . $e->getMessage());
            return false;
        }
    }

    public function editarEscuela($idescuela_sabatica, $nombre, $tipo, $trimestre, $anio, $archivo) {
        try {
            $sql = "UPDATE escuela_sabatica 
                    SET nombre = :nombre, tipo = :tipo, trimestre = :trimestre, anio = :anio, archivo = :archivo 
                    WHERE idescuela_sabatica = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $idescuela_sabatica, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
            $stmt->bindParam(':trimestre', $trimestre, PDO::PARAM_STR);
            $stmt->bindParam(':anio', $anio, PDO::PARAM_STR);
            $stmt->bindParam(':archivo', $archivo, PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en editarEscuela: " . $e->getMessage());
            return false;
        }
    }

    public function eliminarEscuela($idescuela_sabatica) {
        try {
            // Primero obtener el archivo para eliminarlo del servidor
            $escuela = $this->getEscuelaSabaticaPorId($idescuela_sabatica);
            
            $sql = "DELETE FROM escuela_sabatica WHERE idescuela_sabatica = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $idescuela_sabatica, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                // Eliminar el archivo físico si existe
                if ($escuela && !empty($escuela['archivo'])) {
                    $archivo_path = __DIR__ . '/../vistas/' . ltrim($escuela['archivo'], '/');
                    if (file_exists($archivo_path)) {
                        unlink($archivo_path);
                    }
                }
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error en eliminarEscuela: " . $e->getMessage());
            return false;
        }
    }
}
?>
