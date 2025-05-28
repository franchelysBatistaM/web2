<?php
$obras = [];
if (file_exists('datos/obras.json')) {
    $json = file_get_contents('datos/obras.json');
    $obras = json_decode($json, true);
}
$cantidaDeobra = count($obras);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Maneja tus obras vistas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container text-center mt-5">
    <div class="card shadow p-4">
      <h1 class="mb-4 text-primary"> Maneja tus obras vistas </h1>
      <p class="lead">
        Bienvenido. Por favor elige una opcion:
      </p>
      <p class="text-muted">
        Ahora mismo tienes <strong><?php echo $cantidaDeobra; ?></strong> obra registrada.
      </p>

      <div class="row justify-content-center">
        <div class="col-md-4 mb-3">
          <a href="registrar_obra.php" class="btn btn-outline-primary w-100">
            Registrar Obra
          </a>
        </div>
        <div class="col-md-4 mb-3">
          <a href="agregar_personaje.php" class="btn btn-outline-success w-100">
            Agregar Personaje
          </a>
        </div>
        <div class="col-md-4 mb-3">
          <a href="ver_obras.php" class="btn btn-outline-secondary w-100">
            Ver Obras Registradas
          </a>
        </div>
      </div>
    </div>
  </div>

  <footer class="text-center mt-5 text-muted">
    Franchelys Batista 2024-0239
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
