<?php
include_once(__DIR__ . "/../config/database.php");

class ModeloHimno {
    private $pdo;

    public function __construct() {
        $this->pdo = getConnection(); // tu función de conexión PDO
    }

    public function nuevoHimno($numero, $nombre, $letra,$creado_por) {
       if($this->existeHimno($numero)){
           return false;
       }else{
       $query = "INSERT INTO Himno (numero, nombre, letra,creado_por) VALUES (:numero, :nombre, :letra,:creado_por)";
       $stmt = $this->pdo->prepare($query);       
       return $stmt->execute([                     
           ':numero' => $numero,
           ':nombre' => $nombre,
           ':letra'  => $letra,
           ':creado_por' => $creado_por
       ]);  
       }
    }
    public function himnoId($id) {
        $query = "SELECT * FROM Himno WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
   
    public function eliminarHimno($id) {
        $query = "DELETE FROM Himno WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([':id' => $id]);
    }

    public function editarHimno($id, $numero, $nombre, $letra,$creado_por) {
        $query = "UPDATE Himno SET numero = :numero, nombre = :nombre, letra = :letra,creado_por = :creado_por,fecha_modificacion = CURRENT_TIMESTAMP WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            ':id'     => $id,
            ':numero' => $numero,
            ':nombre' => $nombre,
            ':letra'  => $letra,
            ':creado_por' => $creado_por
        ]);
    }

    public function buscarHimno($id) {
        $query = "SELECT * FROM Himno WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listarHimnos() {
        $query = "SELECT * FROM Himno ORDER BY id ASC";
        $stmt = $this->pdo->query($query); // no necesita bind
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function existeHimno($numero) {
    $query = "SELECT COUNT(*) FROM himno WHERE numero = :numero";
    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(':numero', $numero);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}




}

?>
