<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

include_once(__DIR__ . "/../controladores/controlador_localidad.php");

$controlador = new controlador_localidad();

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

switch ($method) {
    case 'GET':
        if ($action === 'listar') {
            $controlador->listar();
        } elseif ($action === 'obtener' && isset($_GET['id'])) {
            $controlador->obtener($_GET['id']);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Acción no válida'
            ]);
        }
        break;
        
    case 'POST':
        if ($action === 'agregar') {
            $controlador->agregar();
        } elseif ($action === 'actualizar' && isset($_GET['id'])) {
            $controlador->actualizar($_GET['id']);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Acción no válida'
            ]);
        }
        break;
        
    case 'DELETE':
        if ($action === 'eliminar' && isset($_GET['id'])) {
            $controlador->eliminar($_GET['id']);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Acción no válida'
            ]);
        }
        break;
        
    default:
        echo json_encode([
            'success' => false,
            'message' => 'Método no permitido'
        ]);
        break;
}
?>
