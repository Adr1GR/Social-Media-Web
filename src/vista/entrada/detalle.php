<?php

use dwesgram\modelo\UsuarioBd;
use dwesgram\modelo\MeGustaBd;

if (!empty($datosParaVista['datos'])) {
    $entrada = $datosParaVista['datos'];
    $idPublicacion = $entrada->getId();
    $autorId = $entrada->getAutor();
    $autorNombre = UsuarioBd::getUsuarioPorId($autorId)->getNombre();
    echo '<h1>' . $entrada->getTexto() . '</h1>';
    echo '<img src="' . $entrada->getImagen() . '" style="width: 30rem;"></img>';
    echo '<h5>Publicado por ' . $autorNombre . '</h5>';
    if ($sesion->haySesion() && $sesion->getId() == $autorId) {
        echo '<a href="index.php?controlador=entrada&accion=eliminar&id=' . $idPublicacion . '" class="btn btn-danger">Eliminar</a>';
    }
    if (!MeGustaBd::checkMeGusta($sesion->getId(), $idPublicacion) && $sesion->haySesion() && $sesion->getId() != $autorId) {
        echo '<form action="index.php?controlador=megusta&accion=crearMeGusta" method="post" enctype="multipart/form-data">';
        echo '<input type="hidden" name="idUsuario" value="' . ($sesion->haySesion() ? $sesion->getId() : null) . '">';
        echo '<input type="hidden" name="idPublicacion" value="' . $idPublicacion . '">';
        echo '<input type="hidden" name="vista" value="' . $vista . '">';
        echo '<button type="submit" class="btn btn-primary">Like</button> </form>';
    } else if ($sesion->haySesion() && $sesion->getId() != $autorId){
        echo '<form action="index.php?controlador=megusta&accion=eliminarMeGusta" method="post" enctype="multipart/form-data">';
        echo '<input type="hidden" name="idUsuario" value="' . ($sesion->haySesion() ? $sesion->getId() : null) . '">';
        echo '<input type="hidden" name="idPublicacion" value="' . $idPublicacion . '">';
        echo '<input type="hidden" name="vista" value="' . $vista . '">';
        echo '<button type="submit" class="btn btn-danger">Dislike</button> </form>';
    }
    echo '<p>Likes: ' . MeGustaBd::countMegustaFromPost($idPublicacion);
} else {
    echo "<p>La entrada que busca no existe</p>";
}
