<?php
namespace dwesgram\modelo;

use dwesgram\modelo\Modelo;

class Entrada extends Modelo
{
    private array $errores = [];

    public function __construct(
        private string|null $texto,
        private int|null $id = null,
        private string|null $imagen = null,
        private string|null $fechaCreacion = null,
        private int|null $autor = null,
        //private int|null $likes = null
    ) {
        $this->errores = [
            'texto' => $texto === null || empty($texto) ? 'El texto no puede estar vacío' : null,
            'imagen' => null
        ];
    }

    public static function crearEntradaDesdePost(array $post): Entrada
    {
        /** TODO:
         *  -Añadir gestion del usuario
        **/
        $texto = $post && isset($post['texto']) ? htmlspecialchars(trim($post['texto'])) : null;
        $autor = $post && isset($post['autor']) ? htmlspecialchars(trim($post['autor'])) : null;
        
        return new Entrada(
            texto: $texto,
            autor: $autor
        );
    }

    public function insertarImagen (array $file)
    {
        if ($file && isset($file['imagen']) && $file['imagen']['error'] === UPLOAD_ERR_OK){
            $permitidos = array("png", "jpg");
            $extension =  pathinfo($file['imagen']['name'], PATHINFO_EXTENSION);
            $mimesPermitidos = array("image/jpg", "image/png", "image/jpeg");
            $fichero = $file['imagen']['tmp_name'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_fichero = finfo_file($finfo, $fichero);
            if (in_array($extension, $permitidos) && in_array($mime_fichero, $mimesPermitidos)) {
                $tiempoactualirrepetible = getdate();
                $file['imagen']['name'] = $tiempoactualirrepetible['0'] . "." . $extension;
                $rutaFicheroDestino = './assets/posts/' . basename($file['imagen']['name']);
                move_uploaded_file($file['imagen']['tmp_name'], $rutaFicheroDestino);
                $this->imagen = $rutaFicheroDestino;
            } else {
                $this->errores['imagen'] = 'Extensión de archivo no permitida';
            }
        }
    }

    public function esValido(): bool
    {
        return empty($this->errores['texto']) && empty($this->errores['imagen']);
    }

    public function getId(): int|null
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTexto(): string
    {
        return $this->texto ? $this->texto : '';
    }

    public function getImagen(): string|null
    {
        return $this->imagen ? $this->imagen : 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f7/Color_icon_gray.svg/300px-Color_icon_gray.svg.png';
    }

    public function setImagen($imagen): void
    {
        $this->imagen = $imagen;
    }

    public function getAutor(): int
    {
        return $this->autor;
    }

    public function getErrores(): array
    {
        return $this->errores;
    }
}
