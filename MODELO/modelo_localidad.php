<?php
include_once(__DIR__ . "/../config/database.php");

class modelo_localidad {
    private $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }

    public function listarLocalidades() {
        $sql = "SELECT * FROM localidades ORDER BY nombre ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerLocalidad($id) {
        $sql = "SELECT * FROM localidades WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function agregarLocalidad($datos) {
        $sql = "INSERT INTO localidades (nombre, departamento, ciudad, direccion, telefono, pastor, lat, lng, tipo, notas) 
                VALUES (:nombre, :departamento, :ciudad, :direccion, :telefono, :pastor, :lat, :lng, :tipo, :notas)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nombre', $datos['nombre']);
        $stmt->bindParam(':departamento', $datos['departamento']);
        $stmt->bindParam(':ciudad', $datos['ciudad']);
        $stmt->bindParam(':direccion', $datos['direccion']);
        $stmt->bindParam(':telefono', $datos['telefono']);
        $stmt->bindParam(':pastor', $datos['pastor']);
        $stmt->bindParam(':lat', $datos['lat']);
        $stmt->bindParam(':lng', $datos['lng']);
        $stmt->bindParam(':tipo', $datos['tipo']);
        $stmt->bindParam(':notas', $datos['notas']);
        
        return $stmt->execute();
    }

    public function actualizarLocalidad($id, $datos) {
        $sql = "UPDATE localidades SET 
                nombre = :nombre, 
                departamento = :departamento, 
                ciudad = :ciudad, 
                direccion = :direccion, 
                telefono = :telefono, 
                pastor = :pastor, 
                lat = :lat, 
                lng = :lng, 
                tipo = :tipo, 
                notas = :notas 
                WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $datos['nombre']);
        $stmt->bindParam(':departamento', $datos['departamento']);
        $stmt->bindParam(':ciudad', $datos['ciudad']);
        $stmt->bindParam(':direccion', $datos['direccion']);
        $stmt->bindParam(':telefono', $datos['telefono']);
        $stmt->bindParam(':pastor', $datos['pastor']);
        $stmt->bindParam(':lat', $datos['lat']);
        $stmt->bindParam(':lng', $datos['lng']);
        $stmt->bindParam(':tipo', $datos['tipo']);
        $stmt->bindParam(':notas', $datos['notas']);
        
        return $stmt->execute();
    }

    public function eliminarLocalidad($id) {
        $sql = "DELETE FROM localidades WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
