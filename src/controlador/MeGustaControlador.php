<?php
namespace dwesgram\controlador;

use dwesgram\controlador\Controlador;
use dwesgram\modelo\MeGusta;
use dwesgram\modelo\MeGustaBd;
use dwesgram\modelo\UsuarioBd;
use dwesgram\modelo\EntradaBd;


class MeGustaControlador extends Controlador
{

    public function crearMeGusta(): MeGusta|null
    {
        // Comprobamos que el usuario esté autenticado
        if (!$this->autenticado()) {
            $this->vista = 'usuario/login';
            return null;
        }

        // Si no son validos los datos mostramos la pagina de error
        $meGusta = MeGusta::crearMeGustaDesdePost($_POST);
        if (!$meGusta->esValido()) {
            $this->vista = 'errores/403';
            return null;
        }

        // Comprobamos que el usuario y la publicacion exista
        $usuario = UsuarioBd::getUsuarioPorId($meGusta->getIdUsuario());
        $publicacion = EntradaBd::getEntradaPorId($meGusta->getIdPublicacion());
        if ($usuario == null || $publicacion == null) {
            $this->vista = 'errores/403';
            return null;
        }

        // Comprobamos que el usuario no es el dueño de la publicacion
        if ($usuario->getId() == $publicacion->getAutor()) {
            $this->vista = 'errores/403';
            return null;
        }

        // Comprobamos que no exista el megusta
        if (MeGustaBd::checkMeGusta($meGusta->getIdUsuario(), $meGusta->getIdPublicacion())) {
            $this->vista = 'errores/403';
            return null;
        }

        MeGustaBd::crearMeGusta($meGusta);
        header('Location: index.php?controlador=entrada&accion=detalle&id=' . $meGusta->getIdPublicacion());
        return $meGusta;
    }

    public function eliminarMeGusta(): MeGusta|null
    {
        // Comprobamos que el usuario esté autenticado
        if (!$this->autenticado()) {
            $this->vista = 'usuario/login';
            return null;
        }

        // Si no son validos los datos mostramos la pagina de error
        $meGusta = MeGusta::crearMeGustaDesdePost($_POST);
        if (!$meGusta->esValido()) {
            $this->vista = 'errores/403';
            return null;
        }

        // Comprobamos que el usuario y la publicacion exista
        $usuario = UsuarioBd::getUsuarioPorId($meGusta->getIdUsuario());
        $publicacion = EntradaBd::getEntradaPorId($meGusta->getIdPublicacion());
        if ($usuario == null || $publicacion == null) {
            $this->vista = 'errores/403';
            return null;
        }

        // Comprobamos que el usuario no es el dueño de la publicacion
        if ($usuario->getId() == $publicacion->getAutor()) {
            $this->vista = 'errores/403';
            return null;
        }

        // Comprobamos que no exista el megusta
        if (!MeGustaBd::checkMeGusta($meGusta->getIdUsuario(), $meGusta->getIdPublicacion())) {
            $this->vista = 'errores/403';
            return null;
        }

        MeGustaBd::eliminarMeGusta($meGusta);
        header('Location: index.php?controlador=entrada&accion=detalle&id=' . $meGusta->getIdPublicacion());
        return $meGusta;
    }
}