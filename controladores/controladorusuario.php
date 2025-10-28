<?php
include_once(__DIR__ . "/../MODELO/modeloUsuario.php");

class ControladorUsuario {
    private $modeloUsuario;
    
    public function __construct() {
        $this->modeloUsuario = new ModeloUsuario();
    }
    
    public function login() {
        if ($_POST) {
            $email = $_POST['email'];
            $PASSWORD = $_POST['PASSWORD'];
         
            $usuario = $this->modeloUsuario->login($email, $PASSWORD);
            
            if ($usuario) {
                session_start();
                $_SESSION['usuario'] = $usuario;
                $_SESSION['idrol'] = $usuario['idrol'];
                $_SESSION['estado'] = $usuario['estado'];
                $redirects = [
                    '4' => '/iglesia/vistas/admin/index.php',
                    '2' => '/iglesia/vistas/distrital/index.php',
                    '3' => '/iglesia/vistas/usuario_registrado/index.php',
                    '1' => '/iglesia/vistas/nacional/index.php',
                ]; 
                if (isset($redirects[$usuario['idrol']])) {
                    header("Location: " . $redirects[$usuario['idrol']]);
                    exit();
                } else {
                    return "Rol de usuario no reconocido";
                }
            } else {
                return "Usuario o contraseña incorrectos";
            }
        }
    }
    
    
    public function listarUsuarios() {
        $usuarios = $this->modeloUsuario->listarUsuarios();
        return $usuarios;
    }
    
    public function verificarSesion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        
        if (!isset($_SESSION['usuario'])) {
            header("Location: /iglesia/vistas/visitas/login.php");
            exit();
        }
        return $_SESSION['usuario'];
    }
    

    public function verificarRol($rolesPermitidos) {
        
        if (!isset($_SESSION['idrol']) || !in_array($_SESSION['idrol'], $rolesPermitidos)) {
            header("Location: /iglesia/vistas/error/sin_permisos.php");
            exit();
        }
    }
    public function nuevoUsuario($nombre, $email,  $PASSWORD,$estado,$rol) {
        $resultado = $this->modeloUsuario->existeUsuario($email);
        if (!$resultado) {
            $this->modeloUsuario->nuevoUsuario($nombre, $email, $PASSWORD,$estado,$rol);
        }else{
           throw new Exception("El email ya está registrado");
        }
       
    }

    public function editarUsuario($id, $nombre, $email,$PASSWORD,$estado,$idrol) {
        $respuesta=$this->modeloUsuario->editarUsuario($id, $nombre, $email,$PASSWORD,$estado,$idrol);
        if($respuesta){
            return ['status' => 'success', 'message' => 'Usuario editado exitosamente.'];
        }else{
            return ['status' => 'error', 'message' => 'Error al editar el usuario.'];
        }
    }

    public function getUsuarioPorId($id) {
        return $this->modeloUsuario->getUsuarioPorId($id);
    }
}

function login() {
    $controlador = new ControladorUsuario();
    return $controlador->login();
}

function logout() {
    $controlador = new ControladorUsuario();
    return $controlador->logout();
}

function verificarSesion() {
    $controlador = new ControladorUsuario();
    return $controlador->verificarSesion();
}

function verificarRol($roles) {
    $controlador = new ControladorUsuario();
    return $controlador->verificarRol($roles);
}
?>