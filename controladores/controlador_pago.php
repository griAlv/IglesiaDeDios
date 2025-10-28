<?php
include_once(__DIR__ . '/../MODELO/modelo_pago.php');

class controlador_pago {
    private $modelo_pago;

    public function __construct() {
        $this->modelo_pago = new modelo_pago();
    }

    /**
     * Registers a payment and its details.
     * @param int $persona_id The ID of the person making the payment.
     * @param int $actividad_id The ID of the activity the payment is for.
     * @param float $monto The amount of the payment.
     * @param string $metodo_pago The payment method used.
     * @return array An associative array with the status and a message.
     */
    public function registrarPago($persona_id, $actividad_id, $monto, $metodo_pago) {
        // Basic data validation
        if (!is_numeric($persona_id) || !is_numeric($actividad_id) || !is_numeric($monto) || $monto <= 0) {
            return ['status' => 'error', 'message' => 'Datos de pago no válidos.'];
        }

        $resultado = $this->modelo_pago->registrarPago($persona_id, $actividad_id, $monto, $metodo_pago);

        if ($resultado) {
            return ['status' => 'success', 'message' => 'Pago registrado correctamente.', 'pago_id' => $resultado];
        } else {
            return ['status' => 'error', 'message' => 'Error al registrar el pago.'];
        }
    }

    /**
     * Retrieves all payments for a specific person and activity.
     * @param int $persona_id The person's ID.
     * @param int $actividad_id The activity's ID.
     * @return array An array of payment details.
     */
    public function obtenerPagos($persona_id, $actividad_id) {
        if (!is_numeric($persona_id) || !is_numeric($actividad_id)) {
            return ['status' => 'error', 'message' => 'IDs no válidos.'];
        }

        $pagos = $this->modelo_pago->obtenerPagosPorPersonaYActividad($persona_id, $actividad_id);
        
        if ($pagos) {
            return ['status' => 'success', 'data' => $pagos];
        } else {
            return ['status' => 'error', 'message' => 'No se encontraron pagos.'];
        }
    }
}
?>