<?php
include_once(__DIR__ . "/../config/database.php");

class modelo_iglesia {
    private $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }

   
    public function listarIglesias() {
        $sql = "SELECT id, nombre FROM Iglesia ORDER BY nombre ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

 
    public function getIglesiaPorId($id) {
        $sql = "SELECT * FROM Iglesia WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>