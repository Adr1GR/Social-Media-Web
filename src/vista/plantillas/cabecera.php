<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DWESgram</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">DWESgram</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <?php
          if ($sesion->haySesion()) {
        ?>
        <li class="nav-item">
          <a class="nav-link" href="index.php?controlador=entrada&accion=nuevo">Crear entrada</a>
        </li>
        <?php
          }
          if (!$sesion->haySesion()) {
        ?>
        <li class="nav-item">
          <a class="nav-link" href="index.php?controlador=usuario&accion=login">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?controlador=usuario&accion=registro">Register</a>
        </li>
        <?php
          } else {
        ?>
        <li class="nav-item">
          <a class="nav-link" href="index.php?controlador=usuario&accion=logout">Logout (<?= $sesion->getNombre() ?>)</a>
        </li>
        <li class="nav-item">
          <img style="height: 40px; width: 40px; border-radius: 50%" src="<?= $sesion->getAvatar() ?>" alt="avatarUser">
        </li>
        <?php
          }
        ?>
      </ul>
    </div>
  </div>
</nav>
