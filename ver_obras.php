<?php
$obras = file_exists('datos/obras.json') ? json_decode(file_get_contents('datos/obras.json'), true) : [];
$personajes = file_exists('datos/personajes.json') ? json_decode(file_get_contents('datos/personajes.json'), true) : [];

function cuentaPersonajes($codigoObra, $personajes) {
  $total = 0;
  foreach ($personajes as $p) {
    if ($p['codigo_obra'] == $codigoObra) {
      $total++;
    }
  }
  return $total;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Listado de Obras Registradas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="p-4">

<h2>Listado de Obras Registradas</h2>

<table class="table table-striped table-bordered">
  <thead class="table-dark">
    <tr>
      <th>Nombre</th>
      <th>Tipo</th>
      <th>Pais</th>
      <th>Personajes</th>
      <th>Accion</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($obras as $obra): ?>
    <tr>
      <td><?= htmlspecialchars($obra['nombre']) ?></td>
      <td><?= htmlspecialchars($obra['tipo']) ?></td>
      <td><?= htmlspecialchars($obra['pais']) ?></td>
      <td><?= cuentaPersonajes($obra['codigo'], $personajes) ?></td>
      <td>
        <a href="detalle.php?codigo=<?= urlencode($obra['codigo']) ?>" target="_blank" class="btn btn-primary btn-sm">Detalle</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<div class="text-center mt-4">
  <a href="index.php" class="btn btn-secondary">Volver</a>
</div>

</body>
</html>
