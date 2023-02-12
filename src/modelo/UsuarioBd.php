<?php
namespace dwesgram\modelo;

use dwesgram\modelo\Usuario;
use dwesgram\modelo\BaseDatos;

class UsuarioBd
{
    use BaseDatos;

    public static function getUsuarioPorId($id): Usuario|null
    {
        try {
            $resultado = [];
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("select nombre, avatar, email, clave from usuario where id = ?");
            $sentencia->bind_param("i", $id);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $fila = $resultado->fetch_assoc();
            if ($fila == null) {
                return null;
            } else {
                return new Usuario(
                    id: $id,
                    nombre: $fila['nombre'],
                    avatar: $fila['avatar'],
                    email: $fila['email'],
                    clave: $fila['clave'],
                );
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public static function getUsuarioPorNombre($nombre): Usuario|null
    {
        try {
            $resultado = [];
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("select id, avatar, email, clave from usuario where nombre = ?");
            $sentencia->bind_param("s", $nombre);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $fila = $resultado->fetch_assoc();
            if ($fila == null) {
                return null;
            } else {
                return new Usuario(
                    id: $fila['id'],
                    avatar: $fila['avatar'],
                    email: $fila['email'],
                    clave: $fila['clave']
                );
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public static function getUsuarioPorEmail($email): Usuario|null
    {
        try {
            $resultado = [];
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("select id, nombre, avatar, clave from usuario where email = ?");
            $sentencia->bind_param("s", $email);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $fila = $resultado->fetch_assoc();
            if ($fila == null) {
                return null;
            } else {
                return new Usuario(
                    id: $fila['id'],
                    nombre: $fila['nombre'],
                    avatar: $fila['avatar'],
                    clave: $fila['clave']
                );
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public static function checkRepeatedEmail($email): bool
    {
        try {
            $resultado = [];
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("select id from usuario where email = ?");
            $sentencia->bind_param("s", $email);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $fila = $resultado->fetch_assoc();
            if ($fila == null) {
                return false;
            } else {
                return true;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function insertar(Usuario $usuario): int|null
    {
        try {
            $nombre = $usuario->getNombre();
            $avatar = $usuario->getAvatar();
            $email = $usuario->getEmail();
            $clave = password_hash($usuario->getClave(), PASSWORD_BCRYPT);
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("insert into usuario (nombre, avatar, email, clave) values (?, ?, ?, ?)");
            $sentencia->bind_param("ssss", $nombre, $avatar, $email, $clave);
            $sentencia->execute();
            return $conexion->insert_id;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }
}