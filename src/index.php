<?php
require_once('vendor/autoload.php');
require_once('config/config.php');
session_start();

/**********************************************************************************************************************
 * 1.- Obtener controlador y acción
 * 
 * Estos datos vienen por GET. Si no hubiera nada en el GET entonces se carga el controlador y la acción por defecto
 * que se encuentran definidos en el fichero "config/config.php".
 *********************************************************************************************************************/
$controlador = $_GET && isset($_GET['controlador']) ? htmlspecialchars($_GET['controlador']) : CONTROLADOR_POR_DEFECTO;
$accion = $_GET && isset($_GET['accion']) ? htmlspecialchars($_GET['accion']) : ACCION_POR_DEFECTO;

/**********************************************************************************************************************
 * 2.- Incluir el controlador
 * 
 * Hay que hacer el "include_once" (o el "require_once") del controlador que se tiene que usar.
 * 
 * Conocemos el nombre del controlador porque llega por GET y sabemos, además, que los controladores están dentro de
 * la carpeta "controlador" que hay en el root path del proyecto. Con esto es suficiente para incluir el fichero donde
 * está el controlador.
 *********************************************************************************************************************/
$controladorNombreClase = ucfirst(strtolower($controlador)) . 'Controlador';
$controladorPath = "controlador/$controladorNombreClase.php";
include_once($controladorPath);

/**********************************************************************************************************************
 * 3.- Crear el objeto controlador
 * 
 * Para crear el objeto usamos la característica de PHP llamada "variable functions" en la que podemos tener el nombre
 * de una función o clase en una variable y usar los paréntesis para activarla o llamarla.
 * 
 * Además, como estamos usando nombre de espacios, tenemos que añadir el namespace completo.
 *********************************************************************************************************************/
$controladorNamespace = "dwesgram\controlador\\$controladorNombreClase";
$controladorObjeto = new $controladorNamespace();

/**********************************************************************************************************************
 * 4.- Cargar la vista
 * 
 * Para cargar la vista hay que llamar al método del controlador indicado por la acción que venía por GET.
 * 
 * Todos los controladores tiene un método llamado "getVista" que devuelve la ruta a la vista sin la extensión ".php".
 * 
 * Además, creamos un array con un elemento llamado 'datos' vacío donde se tienen los datos que necesita la vista, ya
 * que los métodos (de tipo acción) pueden devolver datos que se van a necesitar en la vista. Esta es la estrategia 
 * que vamos a usar para inyectar datos a las vistas desde los controladores.
 * 
 * Al final, tan solo tenemos que hacer el "include_once" o el "require_once" con la vista.
 *********************************************************************************************************************/
use dwesgram\utils\Sesion;

$sesion = new Sesion();

$accion = strtolower($accion);

$datosParaVista['datos'] = [];
if (!method_exists($controladorObjeto, $accion)) {
    echo "No existe el método $accion para el controlador $controladorNamespace";
    exit();
}

$datosParaVista['datos'] = $controladorObjeto->$accion();

$vista = "vista/" . $controladorObjeto->getVista() . ".php";

require_once("vista/plantillas/cabecera.php");
require_once($vista);
require_once("vista/plantillas/pie.php");