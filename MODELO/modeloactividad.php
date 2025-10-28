<?php
include_once(__DIR__ . "/../config/database.php");

class modeloactividad{
    private $pdo;
    public function __construct() {
        $this->pdo = getConnection();
    }

    public function nuevaActividad($nombre, $fecha, $hora, $directiva, $costo, $tipo, $lugar, $foto_link, $creado_por, $extra = []) {
        try {
            $this->pdo->beginTransaction();
    
            // Insertar en tabla principal
            $sql = "INSERT INTO Actividad (nombre, fecha, hora, directiva, costo, tipo, lugar, foto_link, creado_por)
                    VALUES (:nombre, :fecha, :hora, :directiva, :costo, :tipo, :lugar, :foto_link, :creado_por)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':hora', $hora);
            $stmt->bindParam(':directiva', $directiva);
            $stmt->bindParam(':costo', $costo);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':lugar', $lugar);
            $stmt->bindParam(':foto_link', $foto_link);
            $stmt->bindParam(':creado_por', $creado_por, PDO::PARAM_INT);
            $stmt->execute();
    
            $actividad_id = $this->pdo->lastInsertId();
    
            // Detectar el tipo y agregar info extra
            switch (strtolower($tipo)) {
                case 'vigilia':
                    $sqlV = "INSERT INTO Actividad_Vigilia (actividad_id, nombre_vigilia, departamento)
                             VALUES (:actividad_id, :nombre_vigilia, :departamento)";
                    $stmtV = $this->pdo->prepare($sqlV);
                    $stmtV->bindParam(':actividad_id', $actividad_id, PDO::PARAM_INT);
                    $stmtV->bindParam(':nombre_vigilia', $extra['nombre_vigilia']);
                    $stmtV->bindParam(':departamento', $extra['departamento']);
                    $stmtV->execute();
                    break;
    
                case 'convencion':
                    $sqlC = "INSERT INTO Actividad_Convencion (actividad_id, fecha_inicio, dias, departamento, lema, himno)
                             VALUES (:actividad_id, :fecha_inicio, :dias, :departamento, :lema, :himno)";
                    $stmtC = $this->pdo->prepare($sqlC);
                    $stmtC->bindParam(':actividad_id', $actividad_id, PDO::PARAM_INT);
                    $stmtC->bindParam(':fecha_inicio', $extra['fecha_inicio']);
                    $stmtC->bindParam(':dias', $extra['dias'], PDO::PARAM_INT);
                    $stmtC->bindParam(':departamento', $extra['departamento']);
                    $stmtC->bindParam(':lema', $extra['lema']);
                    $stmtC->bindParam(':himno', $extra['himno']);
                    $stmtC->execute();
                    break;
    
                case 'campamento':
                    $sqlCamp = "INSERT INTO Actividad_Campamento (actividad_id, fecha_inicio, dias, departamento, lema, himno)
                                VALUES (:actividad_id, :fecha_inicio, :dias, :departamento, :lema, :himno)";
                    $stmtCamp = $this->pdo->prepare($sqlCamp);
                    $stmtCamp->bindParam(':actividad_id', $actividad_id, PDO::PARAM_INT);
                    $stmtCamp->bindParam(':fecha_inicio', $extra['fecha_inicio']);
                    $stmtCamp->bindParam(':dias', $extra['dias'], PDO::PARAM_INT);
                    $stmtCamp->bindParam(':departamento', $extra['departamento']);
                    $stmtCamp->bindParam(':lema', $extra['lema']);
                    $stmtCamp->bindParam(':himno', $extra['himno']);
                    $stmtCamp->execute();
                    break;
    
                case 'excursion':
                    $sqlEx = "INSERT INTO Actividad_Excursion (actividad_id, distrito_proponente, hora_salida)
                              VALUES (:actividad_id, :distrito_proponente, :hora_salida)";
                    $stmtEx = $this->pdo->prepare($sqlEx);
                    $stmtEx->bindParam(':actividad_id', $actividad_id, PDO::PARAM_INT);
                    $stmtEx->bindParam(':distrito_proponente', $extra['distrito_proponente'], PDO::PARAM_INT);
                    $stmtEx->bindParam(':hora_salida', $extra['hora_salida']);
                    $stmtEx->execute();
                    break;
            }
    
            $this->pdo->commit();
            return ['status' => 'success', 'actividad_id' => $actividad_id];
    
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    

    public function listarActividades() {
        $sql = "SELECT * FROM Actividad ORDER BY fecha DESC, hora ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarActividadesPorTipo($tipo) {
        $sql = "SELECT a.* FROM Actividad a WHERE a.tipo = :tipo ORDER BY a.fecha DESC, a.hora ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->execute();
        $actividades = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Traer datos especializados según tipo
        foreach ($actividades as &$actividad) {
            switch (strtolower($tipo)) {
                case 'vigilia':
                    $sqlV = "SELECT * FROM Actividad_Vigilia WHERE actividad_id = :id";
                    $stmtV = $this->pdo->prepare($sqlV);
                    $stmtV->bindParam(':id', $actividad['id']);
                    $stmtV->execute();
                    $actividad['detalle'] = $stmtV->fetch(PDO::FETCH_ASSOC);
                    break;
    
                case 'convencion':
                    $sqlC = "SELECT * FROM Actividad_Convencion WHERE actividad_id = :id";
                    $stmtC = $this->pdo->prepare($sqlC);
                    $stmtC->bindParam(':id', $actividad['id']);
                    $stmtC->execute();
                    $actividad['detalle'] = $stmtC->fetch(PDO::FETCH_ASSOC);
                    break;
    
                case 'campamento':
                    $sqlCamp = "SELECT * FROM Actividad_Campamento WHERE actividad_id = :id";
                    $stmtCamp = $this->pdo->prepare($sqlCamp);
                    $stmtCamp->bindParam(':id', $actividad['id']);
                    $stmtCamp->execute();
                    $actividad['detalle'] = $stmtCamp->fetch(PDO::FETCH_ASSOC);
                    break;
    
                case 'excursion':
                    $sqlEx = "SELECT * FROM Actividad_Excursion WHERE actividad_id = :id";
                    $stmtEx = $this->pdo->prepare($sqlEx);
                    $stmtEx->bindParam(':id', $actividad['id']);
                    $stmtEx->execute();
                    $actividad['detalle'] = $stmtEx->fetch(PDO::FETCH_ASSOC);
                    break;
    
                default:
                    $actividad['detalle'] = null;
            }
        }
    
        return $actividades;
    }


    public function getActividadPorId($id) {
        $sql = "SELECT * FROM Actividad WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function actualizarActividad($id, $nombre, $fecha, $hora, $directiva, $costo, $tipo, $lugar, $foto_link, $creado_por, $extra = []) {
        try {
            $this->pdo->beginTransaction();
    
            // Actualizar tabla principal
            $sql = "UPDATE Actividad SET
                        nombre = :nombre,
                        fecha = :fecha,
                        hora = :hora,
                        directiva = :directiva,
                        costo = :costo,
                        tipo = :tipo,
                        lugar = :lugar,
                        foto_link = :foto_link,
                        creado_por = :creado_por
                    WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':hora', $hora);
            $stmt->bindParam(':directiva', $directiva);
            $stmt->bindParam(':costo', $costo);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':lugar', $lugar);
            $stmt->bindParam(':foto_link', $foto_link);
            $stmt->bindParam(':creado_por', $creado_por, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
    
            // Actualizar información extra según tipo
            switch (strtolower($tipo)) {
                case 'vigilia':
                    $sqlV = "UPDATE Actividad_Vigilia SET
                                nombre_vigilia = :nombre_vigilia,
                                departamento = :departamento
                             WHERE actividad_id = :actividad_id";
                    $stmtV = $this->pdo->prepare($sqlV);
                    $stmtV->bindParam(':actividad_id', $id, PDO::PARAM_INT);
                    $stmtV->bindParam(':nombre_vigilia', $extra['nombre_vigilia']);
                    $stmtV->bindParam(':departamento', $extra['departamento']);
                    $stmtV->execute();
                    break;
    
                case 'convencion':
                case 'campamento':
                    $tabla = strtolower($tipo) === 'convencion' ? 'Actividad_Convencion' : 'Actividad_Campamento';
                    $sqlC = "UPDATE $tabla SET
                                fecha_inicio = :fecha_inicio,
                                dias = :dias,
                                departamento = :departamento,
                                lema = :lema,
                                himno = :himno
                             WHERE actividad_id = :actividad_id";
                    $stmtC = $this->pdo->prepare($sqlC);
                    $stmtC->bindParam(':actividad_id', $id, PDO::PARAM_INT);
                    $stmtC->bindParam(':fecha_inicio', $extra['fecha_inicio']);
                    $stmtC->bindParam(':dias', $extra['dias'], PDO::PARAM_INT);
                    $stmtC->bindParam(':departamento', $extra['departamento']);
                    $stmtC->bindParam(':lema', $extra['lema']);
                    $stmtC->bindParam(':himno', $extra['himno']);
                    $stmtC->execute();
                    break;
    
                case 'excursion':
                    $sqlEx = "UPDATE Actividad_Excursion SET
                                distrito_proponente = :distrito_proponente,
                                hora_salida = :hora_salida
                              WHERE actividad_id = :actividad_id";
                    $stmtEx = $this->pdo->prepare($sqlEx);
                    $stmtEx->bindParam(':actividad_id', $id, PDO::PARAM_INT);
                    $stmtEx->bindParam(':distrito_proponente', $extra['distrito_proponente'], PDO::PARAM_INT);
                    $stmtEx->bindParam(':hora_salida', $extra['hora_salida']);
                    $stmtEx->execute();
                    break;
            }
    
            $this->pdo->commit();
            return ['status' => 'success', 'actividad_id' => $id];
    
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    
    




    
    
    
    

    

    
}

?>
