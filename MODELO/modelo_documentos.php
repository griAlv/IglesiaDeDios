<?php
include_once(__DIR__ . "/../config/database.php");

class modelo_documentos {
    private $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }

    public function listarDocumentos() {
        return $this->pdo->query("SELECT * FROM documentos")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDocumentoPorId($id) {
        if (!is_numeric($id)) {
            return false;
        }
        return $this->pdo->query("SELECT * FROM documentos WHERE iddocumento = $id")->fetch(PDO::FETCH_ASSOC);
    }
    public function nuevoDocumento($nombre, $archivo, $descripcion, $tipo, $visible_publico, $creadopor, $fecha_creacion){
        $sql = "INSERT INTO documentos (nombre, archivo, descripcion, tipo, visible_publico, creadopor, fecha_creacion)
                VALUES (:nombre, :archivo, :descripcion, :tipo, :visible_publico, :creadopor, :fecha_creacion)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':archivo', $archivo, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
        $stmt->bindParam(':visible_publico', $visible_publico, PDO::PARAM_INT);
        $stmt->bindParam(':creadopor', $creadopor, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_creacion', $fecha_creacion, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
?>
