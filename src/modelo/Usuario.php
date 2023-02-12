<?php
namespace dwesgram\modelo;

use dwesgram\modelo\Modelo;
use dwesgram\modelo\UsuarioBd;

class Usuario extends Modelo
{
    private array $errores = [];

    public function __construct(
        private string|null $nombre = null,
        private int|null $id = null,
        private string|null $avatar = null,
        private string|null $email = null,
        private string|null $clave = null
    ){
        $this->errores = [
            'nombre' => '',
            'email' => '',
            'clave' => '',
            'repiteclave' => '',
            'avatar' => '',
        ];
    }

    public static function crearUsuarioDesdePost(array $post): Usuario
    {
        $usuario = new Usuario(
            nombre: $post && isset($post['nombre']) ? htmlspecialchars(trim($post['nombre'])) : null,
            email: $post && isset($post['email']) ? htmlspecialchars(trim($post['email'])) : null,
            clave: $post && isset($post['clave']) ? $post['clave'] : null
        );
        $repiteClave = $post && isset($post['repiteclave']) ? $post['repiteclave'] : null;
        if ($usuario->nombre == null || empty($usuario->nombre)) {
            $usuario->errores['nombre'] = "El nombre no puede estar vacío";
        } else {
            $otro = UsuarioBd::getUsuarioPorNombre($usuario->nombre);
            if ($otro && $otro !== null) {
                $usuario->errores['nombre'] = "El nombre ya está en uso";
            }
        }
        if ($usuario->email == null || empty($usuario->email)) {
            $usuario->errores['email'] = "El email no puede estar vacío";
        }   else {
            $otro = UsuarioBd::getUsuarioPorEmail($usuario->email);
            if ($otro && $otro !== null) {
                $usuario->errores['email'] = "El email ya está en uso";
            }
        }
        if ($usuario->clave == null || empty($usuario->clave)) {
            $usuario->errores['clave'] = "La clave no puede estar vacía";
        } else if ($usuario->clave && strlen($usuario->clave) < 8){
            $usuario->errores['clave'] = "La clave debe tener al menos 8 caracteres"; 
        }
        if (empty($repiteClave)) {
            $usuario->errores['repiteclave'] = "Debe repetir la clave";
        } else if ($usuario->clave != $repiteClave) {
            $usuario->errores['repiteclave'] = "Las claves no coinciden";
        }
        return $usuario;
    }

    public function insertarImagen (array $file)
    {
        if ($file && isset($file['avatar']) && $file['avatar']['error'] === UPLOAD_ERR_OK){
            $permitidos = array("png", "jpg");
            $extension =  pathinfo($file['avatar']['name'], PATHINFO_EXTENSION);
            $mimesPermitidos = array("image/jpg", "image/png", "image/jpeg");
            $fichero = $file['avatar']['tmp_name'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_fichero = finfo_file($finfo, $fichero);
            if (in_array($extension, $permitidos) && in_array($mime_fichero, $mimesPermitidos)) {
                $tiempoactualirrepetible = getdate();
                $file['avatar']['name'] = $tiempoactualirrepetible['0'] . "." . $extension;
                $rutaFicheroDestino = './assets/avatars/' . basename($file['avatar']['name']);
                move_uploaded_file($file['avatar']['tmp_name'], $rutaFicheroDestino);
                $this->avatar = $rutaFicheroDestino;
            } else {
                $this->errores['avatar'] = 'Extensión de archivo no permitida';
            }
        }
    }

    public function esValido(): bool
    {
        return empty($this->errores['nombre']) 
        && empty($this->errores['email']) 
        && empty($this->errores['clave']) 
        && empty($this->errores['repiteclave'])
        && empty($this->errores['avatar']);
    }

    public static function validarDatosLogin(array $post): Usuario
    {
        $usuario = new Usuario(
            nombre: $post && isset($post['nombre']) ? htmlspecialchars(trim($post['nombre'])) : null,
            clave: $post && isset($post['clave']) ? htmlspecialchars(trim($post['clave'])) : null
        );

        if(mb_strlen($usuario->getNombre()) === 0){
            $usuario->errores['nombre'] = 'El nombre no puede estar vacío';
        }
        if(mb_strlen($usuario->getClave()) === 0)
        $usuario->errores['clave'] = 'La contraseña no puede estar vacía';

        return $usuario;
    }
    
    public function validarClavesIguales(string $clave): bool
    {
        if (password_verify($this->clave ,$clave)) {
            return true;
        } else {
            return false;
        }
    }

    public function getErrores(): array
    {
        return $this->errores;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAvatar(){
        return $this->avatar ? $this->avatar : './assets/avatars/bender.png';
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getClave(): string
    {
        return $this->clave;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setAvatar(string $avatar): void
    {
        $this->avatar = $avatar;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setClave(string $clave): void
    {
        $this->clave = $clave;
    }

    public function setErrores(string $error, string $mensaje): void
    {
        $this->errores[$error] = $mensaje;
    }
}