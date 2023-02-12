<?php
namespace dwesgram\modelo;

use dwesgram\modelo\Modelo;
use dwesgram\modelo\MeGustaBd;

class MeGusta extends Modelo
{
    private array $errores = [];

    public function __construct(
        private int|null $id = null,
        private int|string|null $idUsuario = null,
        private int|string|null $idPublicacion = null
    ){
        $this->errores = [
            'idUsuario' => '',
            'idPublicacion' => '',
        ];
    }

    public static function crearMeGustaDesdePost(array $post): MeGusta
    {
        $meGusta = new MeGusta(
            idUsuario: $post && isset($post['idUsuario']) ? htmlspecialchars(trim($post['idUsuario'])) : null,
            idPublicacion: $post && isset($post['idPublicacion']) ? htmlspecialchars(trim($post['idPublicacion'])) : null
        );
        if ($meGusta->idUsuario == null || empty($meGusta->idUsuario)) {
            $meGusta->errores['idUsuario'] = "El idUsuario no puede estar vacío";
        }
        if ($meGusta->idPublicacion == null || empty($meGusta->idPublicacion)) {
            $meGusta->errores['idPublicacion'] = "El idPublicacion no puede estar vacío";
        }
        return $meGusta;
    }

    public function esValido() {
        return empty($this->errores['idUsuario']) 
        && empty($this->errores['idPublicacion']);
    }

    public function getErrores(): array
    {
        return $this->errores;
    }

    public function getId(): int|null
    {
        return $this->id;
    }

    public function getIdUsuario(): int|null
    {
        return $this->idUsuario;
    }

    public function getIdPublicacion(): int|null
    {
        return $this->idPublicacion;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setIdUsuario(int $idUsuario): void
    {
        $this->idUsuario = $idUsuario;
    }

    public function setIdPublicacion(int $idPublicacion): void
    {
        $this->idPublicacion = $idPublicacion;
    }

    public function setErrores(array $errores): void
    {
        $this->errores = $errores;
    }
}