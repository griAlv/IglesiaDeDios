<?php
include_once(__DIR__ . "/../config/database.php");

class modelo_predicas {
    private $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }

    public function listarPredicas() {
        $sql = "SELECT * FROM predicas ORDER BY fecha_publicacion DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getPredicaPorId($id) {
        $sql = "SELECT * FROM predicas WHERE idpredica = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function nuevaPredica($titulo, $descripcion, $url_youtube, $miniatura, $predicador, $creadopor) {
        try {
            $sql = "INSERT INTO predicas (titulo, descripcion, url_youtube, miniatura, predicador, creadopor) VALUES (:titulo, :descripcion, :url_youtube, :miniatura, :predicador, :creadopor)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':url_youtube', $url_youtube);
            $stmt->bindParam(':miniatura', $miniatura);
            $stmt->bindParam(':predicador', $predicador);
            $stmt->bindParam(':creadopor', $creadopor);
            
            $result = $stmt->execute();
            
            // Debug: Registrar el ID insertado
            if ($result) {
                $inserted_id = $this->pdo->lastInsertId();
                error_log("Predica guardada exitosamente con ID: $inserted_id, Título: $titulo");
            } else {
                error_log("Error al guardar predica: " . print_r($stmt->errorInfo(), true));
            }
            
            return $inserted_id; // Return the inserted ID
        } catch (PDOException $e) {
            error_log("PDOException en nuevaPredica: " . $e->getMessage());
            throw $e;
        }
    }
    public function eliminarPredica($id) {
        try {
            $sql = "DELETE FROM predicas WHERE idpredica = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $result = $stmt->execute();
            
            // Log para depuración
            error_log("Intentando eliminar predica ID: $id, Resultado: " . ($result ? 'exitoso' : 'falló'));
            error_log("Filas afectadas: " . $stmt->rowCount());
            
            return $result && $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error al eliminar predica: " . $e->getMessage());
            throw $e;
        }
    }
    public function editarPredica($id, $titulo, $descripcion, $url_youtube, $miniatura, $predicador, $creadopor) {
        $sql = "UPDATE predicas SET titulo = :titulo, descripcion = :descripcion, url_youtube = :url_youtube, miniatura = :miniatura, predicador = :predicador, creadopor = :creadopor WHERE idpredica = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':url_youtube', $url_youtube);
        $stmt->bindParam(':miniatura', $miniatura);
        $stmt->bindParam(':predicador', $predicador);
        $stmt->bindParam(':creadopor', $creadopor);
        $stmt->execute();
    }
}