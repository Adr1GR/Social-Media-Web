<?php
$entrada = $datosParaVista['datos'];
$texto = $entrada ? $entrada->getTexto() : '';
$errores = $entrada ? $entrada->getErrores() : [];
?>

<div class="container">
    <h1>Nueva entrada</h1>
    <form action="index.php?controlador=entrada&accion=nuevo" method="post" enctype="multipart/form-data">
        <input type="hidden" name="autor" value="<?= $sesion->getId() ?>">
        <div class="mb-3">
            <label for="texto" class="form-label">
                ¿En qué estás pensando? Tienes 128 caracteres para plasmarlo... el resto se ignorará
            </label>
            <textarea 
                class="form-control"
                name="texto" 
                id="texto" 
                rows="3"
                placeholder="Escribe aquí el texto"><?= $texto ?></textarea>
        </div>
        <?php
            if (isset($errores['texto']) && $errores['texto'] !== null) {
                echo '<p class="alert alert-danger">' . $errores['texto'] . '</p>';
            }
        ?>
        <div class="mb-3">
            <label for="imagen">Selecciona una imagen para acompañar a tu entrada</label>
            <input class="form-control" type="file" name="imagen" id="imagen">
        </div>
        <?php
            if (isset($errores['imagen']) && $errores['imagen'] !== null) {
                echo '<p class="alert alert-danger">' . $errores['imagen'] . '</p>';
            }
        ?>
        <button type="submit" class="btn btn-primary">Publicar</button>
    </form>
</div>
