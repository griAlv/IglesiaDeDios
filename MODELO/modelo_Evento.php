<?php
include_once(__DIR__ . "/../config/database.php");

class modelo_Evento {
    private $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }

    

    public function listarEventos() {
    $sql = "SELECT * FROM evento ORDER BY tipo ASC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarEventosRecientes($limite = 3) {
    $sql = "SELECT * FROM evento ORDER BY fecha DESC, hora DESC LIMIT :limite";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEventoPorId($idevento) {
    $sql = "SELECT * FROM evento WHERE idevento = :idevento";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':idevento', $idevento, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function nuevoEvento($tipo, $titulo, $descripcion, $foto, $lugar, $fecha, $hora, $iddistrito, $iddepartamento, $creadopor) {
    $sql = "INSERT INTO evento (tipo, titulo, descripcion, foto, lugar, fecha, hora, iddistrito, iddepartamento, creadopor)
            VALUES (:tipo, :titulo, :descripcion, :foto, :lugar, :fecha, :hora, :iddistrito, :iddepartamento, :creadopor)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
    $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
    $stmt->bindParam(':foto', $foto, PDO::PARAM_STR);
    $stmt->bindParam(':lugar', $lugar, PDO::PARAM_STR);
    $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
    $stmt->bindParam(':hora', $hora, PDO::PARAM_STR);
    $stmt->bindParam(':iddistrito', $iddistrito, PDO::PARAM_INT);
    $stmt->bindParam(':iddepartamento', $iddepartamento, PDO::PARAM_INT);
    $stmt->bindParam(':creadopor', $creadopor, PDO::PARAM_INT);
    $stmt->execute();
    return $this->pdo->lastInsertId();
    }

    public function editarEvento($idevento, $tipo, $titulo, $descripcion, $foto, $lugar, $fecha, $hora, $iddistrito, $iddepartamento, $creadopor) {
    $sql = "UPDATE evento 
            SET tipo = :tipo, 
                titulo = :titulo, 
                descripcion = :descripcion, 
                foto = :foto, 
                lugar = :lugar, 
                fecha = :fecha, 
                hora = :hora, 
                iddistrito = :iddistrito,
                iddepartamento = :iddepartamento,
                creadopor = :creadopor 
            WHERE idevento = :idevento";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':idevento', $idevento, PDO::PARAM_INT);
    $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
    $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
    $stmt->bindParam(':foto', $foto, PDO::PARAM_STR);
    $stmt->bindParam(':lugar', $lugar, PDO::PARAM_STR);
    $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
    $stmt->bindParam(':hora', $hora, PDO::PARAM_STR);
    $stmt->bindParam(':iddistrito', $iddistrito, PDO::PARAM_INT);
    $stmt->bindParam(':iddepartamento', $iddepartamento, PDO::PARAM_INT);
    $stmt->bindParam(':creadopor', $creadopor, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->rowCount() > 0;
}

public function eliminarEvento($idevento) {
    $sql = "DELETE FROM evento WHERE idevento = :idevento";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':idevento', $idevento, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->rowCount() > 0;
}

public function existeEventoMismoDiaHora($fecha, $hora) {
    $sql = "SELECT * FROM evento WHERE fecha = :fecha AND hora = :hora";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
    $stmt->bindParam(':hora', $hora, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->rowCount() > 0;
}
}

?>