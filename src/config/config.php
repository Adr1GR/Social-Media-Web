<?php
namespace dwesgram\config;

// Configuración de la base de datos.
define('BD_HOST', 'db-dwesgram');
define('BD', 'dwes');
define('BD_USUARIO', 'dwes');
define('BD_CLAVE', 'dwes');

// Opciones por defecto.
define('CONTROLADOR_POR_DEFECTO', 'entrada');
define('ACCION_POR_DEFECTO', 'lista');

// Carpeta donde se almacenan las imágenes
define('CARPETA_IMAGENES', 'imagenes');
define('CARPETA_AVATARES', 'imagenes/avatares');

// Extensiones de imágenes permitidas
define('MIME_IMAGENES_PERMITIDOS', ['image/png', 'image/jpeg', 'image/jpg']);

// Avatar por defecto
define('AVATAR_POR_DEFECTO', 'assets/img/bender.png');
