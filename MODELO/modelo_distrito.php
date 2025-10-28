
<?php
include_once(__DIR__ . "/../config/database.php");

class modelo_distrito {
    private $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }

    public function listarDistritos() {
        $sql = "SELECT* FROM Distrito ORDER BY nombre ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDistritoPorId($id) {
        $sql = "SELECT * FROM Distrito WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>