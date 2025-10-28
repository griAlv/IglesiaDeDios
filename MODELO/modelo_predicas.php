<?php
include_once(__DIR__ . "/../config/database.php");

class modelo_predicas {
    private $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }

    public function listarPredicas() {
        $sql = "SELECT* FROM predicas ORDER BY fecha_publicacion DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getPredicaPorId($id) {
        $sql = "SELECT* FROM predicas WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function nuevaPredica($titulo, $descripcion, $url_youtube, $miniatura, $predicador, $creadopor) {
        $sql = "INSERT INTO predicas (titulo, descripcion, url_youtube, miniatura, predicador, creadopor) VALUES (:titulo, :descripcion, :url_youtube, :miniatura, :predicador, :creadopor)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':url_youtube', $url_youtube);
        $stmt->bindParam(':miniatura', $miniatura);
        $stmt->bindParam(':predicador', $predicador);
        $stmt->bindParam(':creadopor', $creadopor);
        $stmt->execute();
    }
    public function eliminarPredica($id) {
        $sql = "DELETE FROM predicas WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
    public function editarPredica($id, $titulo, $descripcion, $url_youtube, $miniatura, $predicador, $creadopor) {
        $sql = "UPDATE predicas SET titulo = :titulo, descripcion = :descripcion, url_youtube = :url_youtube, miniatura = :miniatura, predicador = :predicador, creadopor = :creadopor WHERE id = :id";
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