<?php
include_once(__DIR__ . "/../config/database.php");

class ModeloUsuario {
    private $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }
    public function login($email, $PASSWORD) {
        $query = "SELECT * 
                  FROM usuario 
                  WHERE email = :email 
                    AND PASSWORD = :PASSWORD
                     AND estado = 'activo' LIMIT 1";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':PASSWORD', $PASSWORD);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function nuevoUsuario($email, $nombre, $PASSWORD, $idrol, $estado) {
        if ($this->existeUsuario($email)) {
            return false;
        }
    
        $query = "INSERT INTO usuario (nombre, email, PASSWORD, idrol, estado) 
                  VALUES (:nombre, :email, :PASSWORD, :idrol, :estado)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':PASSWORD', $PASSWORD);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':idrol', $idrol);
    
        return $stmt->execute();
    }
    
    public function editarUsuario($id, $nombre, $email, $PASSWORD, $estado, $idrol) {
        
            $query = "UPDATE usuario
            SET nombre = :nombre,
                email = :email,
                PASSWORD = :PASSWORD,
                estado = :estado,
                idrol = :idrol,
                fecha_modificacion = NOW()
            WHERE id = :id";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':PASSWORD', $PASSWORD);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':idrol', $idrol);
        
        
        
        return $stmt->execute();
    }

    public function eliminarUsuario($id) {
        $query = "DELETE FROM usuario WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
   
    public function listarUsuarios() {
        $query = "SELECT * FROM usuario ORDER BY id ASC";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
   
    public function getUsuarioPorId($id) {
        $query = "SELECT id, nombre, email, PASSWORD, estado, idrol FROM usuario WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function existeUsuario($email) {
        $query = "SELECT * FROM usuario WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


}

    
?>
