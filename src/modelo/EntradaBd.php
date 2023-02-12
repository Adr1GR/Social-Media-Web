<?php
namespace dwesgram\modelo;

use dwesgram\modelo\Entrada;
use dwesgram\modelo\BaseDatos;

class EntradaBd
{
    use BaseDatos;

    public static function getEntradas(): array
    {
        try {
            $resultado = [];
            $conexion = BaseDatos::getConexion();
            $queryResultado = $conexion->query("select id, texto, imagen, autor, creado from entrada order by creado desc");
            if ($queryResultado !== false) {
                while (($fila = $queryResultado->fetch_assoc()) != null) {
                    $entrada = new Entrada(
                        id: $fila['id'],
                        texto: $fila['texto'],
                        imagen: $fila['imagen'],
                        fechaCreacion: $fila['creado'],
                        autor: $fila['autor']
                    );
                    $resultado[] = $entrada;
                }
            }
            return $resultado;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }

    public static function getEntradaPorId($id): Entrada|null
    {
        try {
            $resultado = [];
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("select texto, imagen, autor, creado from entrada where id = ?");
            $sentencia->bind_param("i", $id);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $fila = $resultado->fetch_assoc();
            if ($fila == null) {
                return null;
            } else {
                return new Entrada(
                    id: $id,
                    texto: $fila['texto'],
                    imagen: $fila['imagen'],
                    fechaCreacion: $fila['creado'],
                    autor: $fila['autor']
                );
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public static function insertar(Entrada $entrada): int|null
    {
        try {
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("insert into entrada (texto, imagen, autor) values (?,?,?)");
            $texto = $entrada->getTexto();
            $imagen = $entrada->getImagen();
            $autor = $entrada->getAutor();
            $sentencia->bind_param('ssi', $texto, $imagen, $autor); //Cambiar 1 por $entrada->getAutor()
            $sentencia->execute();
            return $conexion->insert_id;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public static function eliminarEntrada($id): bool
    {
        try {
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("delete from entrada where id = ?");
            $sentencia->bind_param('i', $id);
            $sentencia->execute();
            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function getIdUsuarioFromEntrada() {
        try {
            $resultado = [];
            $conexion = BaseDatos::getConexion();
            $queryResultado = $conexion->query("select autor from entrada");
            if ($queryResultado !== false) {
                while (($fila = $queryResultado->fetch_assoc()) != null) {
                    $resultado[$fila['id']] = $fila['autor'];
                }
            }
            return $resultado;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }
}