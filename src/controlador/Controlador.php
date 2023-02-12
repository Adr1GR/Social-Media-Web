<?php
namespace dwesgram\controlador;

abstract class Controlador
{
    protected string|null $vista = null;

    public function getVista()
    {
        return $this->vista;
    }

    public function autenticado(): bool
    {
        $sesion = new \dwesgram\utils\Sesion();
        return $sesion->haySesion();
    }
}