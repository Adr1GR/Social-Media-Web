<?php
namespace dwesgram\controlador;

use dwesgram\controlador\Controlador;
use dwesgram\modelo\Entrada;
use dwesgram\modelo\EntradaBd;

class EntradaControlador extends Controlador
{

    public function lista(): array
    {
        $this->vista = "entrada/lista";
        return EntradaBd::getEntradas();
    }

    public function detalle(): Entrada|null
    {
        $id = $_GET && isset($_GET['id']) ? htmlspecialchars($_GET['id']) : null;
        $this->vista = "entrada/detalle"; 
        return EntradaBd::getEntradaPorId($id);
    }

    public function nuevo(): Entrada|null
    {
        if (!$this->autenticado()) {
            header('Location: index.php');
            return null;
        }

        if (!$_POST) {
            $this->vista = 'entrada/nuevo';
            return null;
        }

        $entrada = Entrada::crearEntradaDesdePost($_POST);
        $entrada->insertarImagen($_FILES);
        if ($entrada->esValido()) {
            $this->vista = 'entrada/detalle';
            $entrada->setId(EntradaBd::insertar($entrada));
            return $entrada;
        } else {
            $this->vista = 'entrada/nuevo';
            return $entrada;
        }
    }

    public function eliminar(): bool|null
    {
        if (!$this->autenticado()) {
            header('Location: index.php');
            return null;
        }


        $id = $_GET && isset($_GET['id']) ? htmlspecialchars($_GET['id']) : null;
        $sesion = new \dwesgram\utils\Sesion();
        
        if ($id !== null) {
            $entrada = EntradaBd::getEntradaPorId($id);
            if ($sesion->getId() == $entrada->getAutor()) {
                $this->vista = "entrada/eliminar";
                return EntradaBd::eliminarEntrada($id);
            }
        }
        header('Location: index.php');
        return false;
    }
}
