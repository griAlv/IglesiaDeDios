<?php
include_once(__DIR__ . "/../config/database.php");

class modelo_tallacamisa {
    private $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }

    /**
     * Lista todas las tallas de camisa disponibles en el catálogo.
     * @return array Retorna un array de arrays asociativos con los IDs y las tallas.
     */
    public function listarTallas() {
        $sql = "SELECT id, talla FROM Talla_Camisa ORDER BY id ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene una talla específica por su ID.
     * @param int $id El ID de la talla.
     * @return array|false Retorna un array asociativo con la talla o false si no se encuentra.
     */
    public function getTallaPorId($id) {
        $sql = "SELECT id, talla FROM Talla_Camisa WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>