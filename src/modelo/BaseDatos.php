<?php
namespace dwesgram\modelo;

use todolist\config\{BD_HOST, BD, BD_USUARIO, BD_CLAVE};

trait BaseDatos
{
    private static \mysqli|null $conexion = null;

    public static function getConexion(): \mysqli
    {
        if (self::$conexion === null) {
            self::$conexion = new \mysqli(BD_HOST, BD_USUARIO, BD_CLAVE, BD, 3306);
        }

        return self::$conexion;
    }
}
