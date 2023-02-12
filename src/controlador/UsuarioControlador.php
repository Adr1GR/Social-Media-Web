<?php
namespace dwesgram\controlador;

use dwesgram\controlador\Controlador;
use dwesgram\modelo\Usuario;
use dwesgram\modelo\UsuarioBd;

class UsuarioControlador extends Controlador
{

    // Función que loguea al usuario
    public function login(): Usuario|null
    {
        // Si el usuario ya está autenticado, redirigir a la página de inicio
        if ($this->autenticado()) {
            header('Location: index.php');
            return null;
        }
        
        // Si no hay datos de POST, mostrar el formulario de login
        if (!$_POST) {
            $this->vista = 'usuario/login';
            return null;
        }

        $usuario = Usuario::validarDatosLogin($_POST);
        if (!$usuario->esValido()) {
            $this->vista = 'usuario/login';
            return $usuario;
        }
        
        $usuarioBd = UsuarioBd::getUsuarioPorNombre($usuario->getNombre());
        if ($usuarioBd && $usuario->validarClavesIguales($usuarioBd->getClave())) {
            $_SESSION['usuario'] = [
                'id' => $usuarioBd->getId(),
                'nombre' => $usuario->getNombre(),
                'avatar' => $usuarioBd->getAvatar()
            ];
            header('Location: index.php');
            return null;
        } else {
            $usuario->setErrores('clave', 'El usuario y/o la contraseña no son correctos');
        }
        
        $this->vista = 'usuario/login';
        return $usuario;
    }

    // Función que registra un nuevo usuario
    public function registro(): Usuario|null
    {
        // Si el usuario ya está autenticado, no puede registrarse
        if ($this->autenticado()) {
            header('Location: index.php');
            return null;
        }

        // Si no hay datos de POST, mostrar el formulario de registro
        if (!$_POST) {
            $this->vista = 'usuario/registro';
            return null;
        }

        $usuario = Usuario::crearUsuarioDesdePost($_POST);
        $usuario->insertarImagen($_FILES);
        if ($usuario->esValido()) {
            $usuario->setId(UsuarioBd::insertar($usuario));
            $_SESSION['usuario'] = [
                'id' => $usuario->getId(),
                'nombre' => $usuario->getNombre(),
                'avatar' => $usuario->getAvatar()
            ];
            header('Location: index.php');
            return $usuario;
        } else {
            $this->vista = 'usuario/registro';
            return $usuario;
        }
    }

    // Función que cierra la sesión del usuario
    public function logout(): void
    {
        if (!$this->autenticado()) {
            return;
        }
        session_destroy();
        header('Location: index.php');
    }

    // Funcion que devuelve el usuario autenticado o null si no lo está
    public function detalle(): Usuario|null
    {
        $id = $_GET && isset($_GET['id']) ? htmlspecialchars($_GET['id']) : null;
        $this->vista = "usuario/detalle"; 
        return UsuarioBd::getUsuarioPorId($id);
    }

}