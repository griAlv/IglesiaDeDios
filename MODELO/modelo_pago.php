<?php
include_once(__DIR__ . "/../config/database.php");

class modelo_pago {
    private $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }

    public function registrarPago($persona_id, $actividad_id, $monto, $metodo_pago) {
        try {
            // Iniciar una transacción para asegurar la consistencia de los datos
            $this->pdo->beginTransaction();

            // 1. Verificar si ya existe un registro en la tabla Pago para esta persona y actividad
            $sql = "SELECT id, monto_total FROM Pago WHERE persona_id = :persona_id AND actividad_id = :actividad_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':persona_id', $persona_id);
            $stmt->bindParam(':actividad_id', $actividad_id);
            $stmt->execute();
            $pagoExistente = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($pagoExistente) {
                // Si ya existe, actualizamos el monto total en la tabla Pago
                $pago_id = $pagoExistente['id'];
                $nuevoMontoTotal = $pagoExistente['monto_total'] + $monto;
                $sql = "UPDATE Pago SET monto_total = :nuevoMonto WHERE id = :pago_id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':nuevoMonto', $nuevoMontoTotal);
                $stmt->bindParam(':pago_id', $pago_id);
                $stmt->execute();

            } else {
                // Si no existe, creamos un nuevo registro en la tabla Pago
                $sql = "INSERT INTO Pago (persona_id, actividad_id, monto_total) VALUES (:persona_id, :actividad_id, :monto_total)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':persona_id', $persona_id);
                $stmt->bindParam(':actividad_id', $actividad_id);
                $stmt->bindParam(':monto_total', $monto);
                $stmt->execute();
                $pago_id = $this->pdo->lastInsertId();
            }

            // 2. Insertar un nuevo registro en la tabla Detalle_Pago para el abono actual
            $sql = "INSERT INTO Detalle_Pago (pago_id, monto, metodo_pago) VALUES (:pago_id, :monto, :metodo_pago)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':pago_id', $pago_id);
            $stmt->bindParam(':monto', $monto);
            $stmt->bindParam(':metodo_pago', $metodo_pago);
            $stmt->execute();

            // Confirmar la transacción
            $this->pdo->commit();
            return $pago_id;

        } catch (PDOException $e) {
            // Revertir la transacción si algo sale mal
            $this->pdo->rollBack();
            error_log("Error en la transacción de pago: " . $e->getMessage());
            return false;
        }
    }

   
    public function obtenerPagosPorPersonaYActividad($persona_id, $actividad_id) {
        $sql = "SELECT p.monto_total, dp.* FROM Pago p
                JOIN Detalle_Pago dp ON p.id = dp.pago_id
                WHERE p.persona_id = :persona_id AND p.actividad_id = :actividad_id
                ORDER BY dp.fecha_abono ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':persona_id', $persona_id);
        $stmt->bindParam(':actividad_id', $actividad_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>