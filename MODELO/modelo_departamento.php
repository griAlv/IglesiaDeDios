<?php
include_once(__DIR__ . "/../config/database.php");

class modelo_departamento {
    private $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }

    public function listarDepartamentos() {
        $sql = "SELECT* FROM Departamento ORDER BY nombre ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}