<?php
include_once(__DIR__ . "/../config/database.php");

class modelo_persona {
    private $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }

    public function listarIglesias() {
        $stmt = $this->pdo->prepare("SELECT * FROM Iglesia");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarDistritos() {
        $stmt = $this->pdo->prepare("SELECT * FROM Distrito");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarTallasCamisa() {
        $stmt = $this->pdo->prepare("SELECT * FROM Talla_Camisa");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarCondicionesMedicas() {
        $stmt = $this->pdo->prepare("SELECT * FROM Condicion_Medica");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarActividades() {
        $stmt = $this->pdo->prepare("SELECT * FROM Actividad");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registrarPersonaEInscripcion($datos) {
        try {
            $this->pdo->beginTransaction();

            // 1. Insertar persona (incluyendo cantidad_pagos y monto_total que están en la tabla Persona)
            $sql = "INSERT INTO Persona (nombre, apellido, edad, genero, rol, estado, cantidad_pagos, monto_total, iglesia_id, distrito_id, usuario_id, talla_camisa_id, condicion_medica_id)
                    VALUES (:nombre, :apellido, :edad, :genero, :rol, :estado, :cantidad_pagos, :monto_total, :iglesia_id, :distrito_id, :usuario_id, :talla_camisa_id, :condicion_medica_id)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':nombre' => $datos['nombre'],
                ':apellido' => $datos['apellido'],
                ':edad' => $datos['edad'],
                ':genero' => $datos['genero'],
                ':rol' => $datos['rol'],
                ':estado' => $datos['estado'],
                ':cantidad_pagos' => $datos['cantidad_pagos'] ?? 0,
                ':monto_total' => $datos['monto_total'] ?? 0,
                ':iglesia_id' => $datos['iglesia_id'],
                ':distrito_id' => $datos['distrito_id'],
                ':usuario_id' => $datos['usuario_id'],
                ':talla_camisa_id' => $datos['talla_camisa_id'],
                ':condicion_medica_id' => $datos['condicion_medica_id']
            ]);

            $persona_id = $this->pdo->lastInsertId();

            // 2. Insertar inscripción a la actividad (solo los campos que existen en la tabla)
            $sql2 = "INSERT INTO Inscripcion_Actividad (persona_id, actividad_id, estado, observaciones)
                     VALUES (:persona_id, :actividad_id, :estado, :observaciones)";
            
            $stmt2 = $this->pdo->prepare($sql2);
            $stmt2->execute([
                ':persona_id' => $persona_id,
                ':actividad_id' => $datos['actividad_id'],
                ':estado' => $datos['estado_inscripcion'] ?? 'inscrito',
                ':observaciones' => $datos['observaciones'] ?? null
            ]);

            // 3. Si hay pago (estado parcial o pagado), insertar en tabla Pago y Detalle_Pago
            if (isset($datos['cantidad_pagos']) && $datos['cantidad_pagos'] > 0) {
                // Insertar en tabla Pago
                $sql3 = "INSERT INTO Pago (persona_id, actividad_id, monto_total, fecha_pago)
                         VALUES (:persona_id, :actividad_id, :monto_total, NOW())";
                
                $stmt3 = $this->pdo->prepare($sql3);
                $stmt3->execute([
                    ':persona_id' => $persona_id,
                    ':actividad_id' => $datos['actividad_id'],
                    ':monto_total' => $datos['monto_total']
                ]);

                $pago_id = $this->pdo->lastInsertId();

                // Insertar en tabla Detalle_Pago
                $sql4 = "INSERT INTO Detalle_Pago (pago_id, monto, metodo_pago, fecha_abono)
                         VALUES (:pago_id, :monto, :metodo_pago, NOW())";
                
                $stmt4 = $this->pdo->prepare($sql4);
                $stmt4->execute([
                    ':pago_id' => $pago_id,
                    ':monto' => $datos['cantidad_pagos'],
                    ':metodo_pago' => $datos['metodo_pago'] ?? 'efectivo'
                ]);
            }

            $this->pdo->commit();
            return $persona_id;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            // Log del error para debugging
            error_log("Error en registrarPersonaEInscripcion: " . $e->getMessage());
            error_log("Datos enviados: " . print_r($datos, true));
            return false;
        }
    }
    public function listarPersonaEInscripcion() {
        $stmt = $this->pdo->prepare("SELECT * FROM persona  where estado = 'inscrito'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function persona(){
        $stmt = $this->pdo->prepare("SELECT * FROM persona");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarPersonasDetalladas() {
        $sql = "SELECT 
                    p.*, 
                    i.nombre AS iglesia,
                    d.nombre AS distrito,
                    t.talla AS talla_camisa,
                    c.descripcion AS condicion_medica
                FROM Persona p
                LEFT JOIN Iglesia i ON p.iglesia_id = i.id
                LEFT JOIN Distrito d ON p.distrito_id = d.id
                LEFT JOIN Talla_Camisa t ON p.talla_camisa_id = t.id
                LEFT JOIN Condicion_Medica c ON p.condicion_medica_id = c.id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

}
?>