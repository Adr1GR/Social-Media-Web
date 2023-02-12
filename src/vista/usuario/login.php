<?php
    if (isset($_SESSION['usuario'])) {
        header('Location: index.php');
    }
    $usuario = $datosParaVista['datos'];
    $nombre = $usuario ? $usuario->getNombre() : '';
    $errores = $usuario ? $usuario->getErrores() : [];
?>

<div class="container">
    <h1>Inicia sesión</h1>

    <form action="index.php?controlador=usuario&accion=login" method="post">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de usuario</label><br>
            <input type="text" id="nombre" name="nombre" value="<?= $nombre ?>">
        </div>
        <?php
            if (isset($errores['nombre']) && !empty($errores['nombre'])) {
                echo '<p class="alert alert-danger">' . $errores['nombre'] . '</p>';
            }
        ?>
        <div class="mb-3">
            <label for="clave" class="form-label">Contraseña</label><br>
            <input type="password" id="clave" name="clave">
        </div>
        <?php
            if (isset($errores['clave']) && !empty($errores['clave'])) {
                echo '<p class="alert alert-danger">' . $errores['clave'] . '</p>';
            }
        ?>
        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>
</div>
