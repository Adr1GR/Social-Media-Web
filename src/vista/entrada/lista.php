<?php

use dwesgram\modelo\UsuarioBd;
use dwesgram\modelo\MeGustaBd;

if (!empty($datosParaVista['datos'])) {
    echo "<h3>Entradas publicadas:</h3>";
    echo "<hr>";
    echo "<div class='d-flex'>";
    echo "<div class='mx-auto row mb-5'>";
    foreach ($datosParaVista['datos'] as $entrada) {
        $texto = $entrada->getTexto();
        $idPublicacion = $entrada->getId();
        $autorId = $entrada->getAutor();
        $autorNombre = UsuarioBd::getUsuarioPorId($autorId)->getNombre();
        $imagen = $entrada->getImagen();
        echo <<<END
            <div class="card p-3" style="width: 23rem;">
                <img class="card-img-top" src="$imagen" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">$texto</h5>
                    <p class="card-text">Publicado por $autorNombre</p>
                    <a href="index.php?controlador=entrada&accion=detalle&id=$idPublicacion" class="btn btn-primary">Detalles</a>
            END;
    if ($sesion->haySesion() && $sesion->getId() == $autorId) {
        echo '<a href="index.php?controlador=entrada&accion=eliminar&id=' . $idPublicacion . '" class="btn btn-danger">Eliminar</a>';
    }
    if (!MeGustaBd::checkMeGusta($sesion->getId(), $idPublicacion) && $sesion->haySesion() && $sesion->getId() != $autorId) {
        echo '<form action="index.php?controlador=megusta&accion=crearMeGusta" method="post" enctype="multipart/form-data">';
        echo '<input type="hidden" name="idUsuario" value="' . ($sesion->haySesion() ? $sesion->getId() : null) . '">';
        echo '<input type="hidden" name="idPublicacion" value="' . $idPublicacion . '">';
        echo '<button type="submit" class="btn btn-primary">Like</button> </form>';
    } else if ($sesion->haySesion() && $sesion->getId() != $autorId){
        echo '<form action="index.php?controlador=megusta&accion=eliminarMeGusta" method="post" enctype="multipart/form-data">';
        echo '<input type="hidden" name="idUsuario" value="' . ($sesion->haySesion() ? $sesion->getId() : null) . '">';
        echo '<input type="hidden" name="idPublicacion" value="' . $idPublicacion . '">';
        echo '<button type="submit" class="btn btn-danger">Dislike</button> </form>';
    }
    echo '<p>Likes: ' . MeGustaBd::countMegustaFromPost($idPublicacion);
                echo "</div>";
            echo "</div>";
    }
    echo "</div>";
    echo "</div>";
} else {
    echo "<h3>No hay entradas publicadas</h3>";
}
?>