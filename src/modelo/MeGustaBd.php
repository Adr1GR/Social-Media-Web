<?php
namespace dwesgram\modelo;

use dwesgram\modelo\MeGusta;
use dwesgram\modelo\BaseDatos;

class MeGustaBd
{
    use BaseDatos;

    public static function crearMeGusta(MeGusta $meGusta): array|null
    {
        try {
            $errores = [];
            $idUsuario = $meGusta->getIdUsuario();
            $idPublicacion = $meGusta->getIdPublicacion();
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("insert into megusta (usuario, entrada) values (?, ?)");
            $sentencia->bind_param("ii", $idUsuario, $idPublicacion);
            $sentencia->execute();
            if ($sentencia->affected_rows == 0) {
                $errores[] = "No se ha podido crear el me gusta";
            }
            return $errores;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public static function eliminarMeGusta(MeGusta $meGusta): array|null
    {
        try {
            $errores = [];
            $idUsuario = $meGusta->getIdUsuario();
            $idPublicacion = $meGusta->getIdPublicacion();
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("delete from megusta where usuario = ? and entrada = ?");
            $sentencia->bind_param("ii", $idUsuario, $idPublicacion);
            $sentencia->execute();
            if ($sentencia->affected_rows == 0) {
                $errores[] = "No se ha podido eliminar el me gusta";
            }
            return $errores;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public static function checkMeGusta($idUsuario, $idPublicacion): bool|null
    {
        try {
            /* $idUsuario = $meGusta->getIdUsuario();
            $idPublicacion = $meGusta->getIdPublicacion(); */
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("select * from megusta where usuario = ? and entrada = ?");
            $sentencia->bind_param("ii", $idUsuario, $idPublicacion);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            if ($resultado->num_rows == 0) {
                return false;
            } else {
                return true;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public static function countMegustaFromPost($idPublicacion): int|null
    {
        try {
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("select count(*) as total from megusta where entrada = ?");
            $sentencia->bind_param("i", $idPublicacion);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $fila = $resultado->fetch_assoc();
            return $fila['total'];
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

}
