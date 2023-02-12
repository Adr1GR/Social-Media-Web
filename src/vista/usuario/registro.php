<?php
    if (isset($_SESSION['usuario'])) {
        header('Location: index.php');
    }
    $usuario = $datosParaVista['datos'];
    $nombre = $usuario ? $usuario->getNombre() : '';
    $email = $usuario ? $usuario->getEmail() : '';
    $errores = $usuario ? $usuario->getErrores() : [];
?>

<div class="container">
    <h1>Regístrate</h1>
    <form action="index.php?controlador=usuario&accion=registro" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de usuario*</label><br>
            <input type="text" id="nombre" name="nombre" value="<?= $nombre ?>">
        </div>
        <?php
            if (isset($errores['nombre']) && !empty($errores['nombre'])) {
                echo '<p class="alert alert-danger">' . $errores['nombre'] . '</p>';
            }
        ?>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail*</label><br>
            <input type="email" id="email" name="email" value="<?= $email ?>">
        </div>
        <?php
            if (isset($errores['email']) && !empty($errores['email'])) {
                echo '<p class="alert alert-danger">' . $errores['email'] . '</p>';
            }
        ?>
        <div class="mb-3">
            <label for="clave" class="form-label">Contraseña*</label><br>
            <input type="password" id="clave" name="clave">
        </div>
        <?php
            if (isset($errores['clave']) && !empty($errores['clave'])) {
                echo '<p class="alert alert-danger">' . $errores['clave'] . '</p>';
            }
        ?>
        <div class="mb-3">
            <label for="repiteclave" class="form-label">Repite la contraseña*</label><br>
            <input type="password" id="repiteclave" name="repiteclave">
        </div>
        <?php
            if (isset($errores['repiteclave']) && !empty($errores['repiteclave'])) {
                echo '<p class="alert alert-danger">' . $errores['repiteclave'] . '</p>';
            }
        ?>
        <div class="mb-3">
            <label for="avatar">Puedes elegir un avatar</label><br>
            <input class="form-control" type="file" name="avatar" id="avatar">
        </div>
        <?php
            if (isset($errores['avatar']) && !empty($errores['avatar'])) {
                echo '<p class="alert alert-danger">' . $errores['avatar'] . '</p>';
            }
        ?>
        <button type="submit" class="btn btn-primary">Crear cuenta</button>
    </form>
</div>
