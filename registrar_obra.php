<?php
$archivo = 'datos/obras.json';
$codigo = $_GET['codigo'] ?? '';
$obras = file_exists($archivo) ? json_decode(file_get_contents($archivo), true) : [];

$obra = [
  'codigo' => '',
  'foto_url' => '',
  'tipo' => 'Serie',
  'nombre' => '',
  'descripcion' => '',
  'pais' => '',
  'autor' => ''
];

if ($codigo) {
  foreach ($obras as $o) {
    if ($o['codigo'] === $codigo) {
      $obra = $o;
      break;
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $obra = [
    'codigo' => $_POST['codigo'],
    'foto_url' => $_POST['foto_url'],
    'tipo' => $_POST['tipo'],
    'nombre' => $_POST['nombre'],
    'descripcion' => $_POST['descripcion'],
    'pais' => $_POST['pais'],
    'autor' => $_POST['autor']
  ];

  $actualizado = false;
  foreach ($obras as &$o) {
    if ($o['codigo'] === $obra['codigo']) {
      $o = $obra;
      $actualizado = true;
      break;
    }
  }
  if (!$actualizado) {
    $obras[] = $obra;
  }

  file_put_contents($archivo, json_encode($obras, JSON_PRETTY_PRINT));

  echo "<div class='alert alert-success'> Obra registrada correctamente. <a href='registrar_obra.php'>Registrar otra</a></div>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Registrar Obra</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="p-4">
  <h2>Registrar Obra</h2>
  <form method="post" class="w-50">
    <div class="mb-3">
      <label class="form-label" for="codigo">Codigo</label>
      <input id="codigo" name="codigo" class="form-control" required value="<?= htmlspecialchars($obra['codigo']) ?>" <?= $codigo ? 'readonly' : '' ?>>
      <?php if ($codigo): ?>
        <small class="text-muted">No se puede cambiar el codigo al editar.</small>
      <?php endif; ?>
    </div>

    <div class="mb-3">
      <label class="form-label" for="foto_url">URL de Foto</label>
      <input id="foto_url" name="foto_url" type="url" class="form-control" required value="<?= htmlspecialchars($obra['foto_url']) ?>">
    </div>

    <div class="mb-3">
      <label class="form-label" for="tipo">Tipo</label>
      <select id="tipo" name="tipo" class="form-select" required>
        <option value="Serie" <?= $obra['tipo'] === 'Serie' ? 'selected' : '' ?>>Serie</option>
        <option value="Pelicula" <?= $obra['tipo'] === 'Pelicula' ? 'selected' : '' ?>>Pelicula</option>
        <option value="Otro" <?= $obra['tipo'] === 'Otro' ? 'selected' : '' ?>>Otro</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label" for="nombre">Nombre</label>
      <input id="nombre" name="nombre" class="form-control" required value="<?= htmlspecialchars($obra['nombre']) ?>">
    </div>

    <div class="mb-3">
      <label class="form-label" for="descripcion">Descripcion</label>
      <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required><?= htmlspecialchars($obra['descripcion']) ?></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label" for="pais">Pais</label>
      <input id="pais" name="pais" class="form-control" required value="<?= htmlspecialchars($obra['pais']) ?>">
    </div>

    <div class="mb-3">
      <label class="form-label" for="autor">Autor</label>
      <input id="autor" name="autor" class="form-control" required value="<?= htmlspecialchars($obra['autor']) ?>">
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="index.php" class="btn btn-secondary">Volver</a>
  </form>
</body>
</html>
