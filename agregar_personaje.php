<?php 
$archiPersonajes = 'datos/personajes.json';
$archiobras = 'datos/obras.json';

$codigoObra = $_GET['codigo'] ?? '';

$personajes = file_exists($archiPersonajes) ? json_decode(file_get_contents($archiPersonajes), true) : [];
$obras = file_exists($archiobras) ? json_decode(file_get_contents($archiobras), true) : [];

$personaje = [
  'cedula' => '',
  'foto_url' => '',
  'nombre' => '',
  'apellido' => '',
  'fecha_nacimiento' => '',
  'sexo' => 'Masculino',
  'habilidades' => '',
  'comida_favorita' => '',
  'codigo_obra' => $codigoObra,
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $personaje = [
    'cedula' => $_POST['cedula'],
    'foto_url' => $_POST['foto_url'],
    'nombre' => $_POST['nombre'],
    'apellido' => $_POST['apellido'],
    'fecha_nacimiento' => $_POST['fecha_nacimiento'],
    'sexo' => $_POST['sexo'],
    'habilidades' => $_POST['habilidades'],
    'comida_favorita' => $_POST['comida_favorita'],
    'codigo_obra' => $_POST['codigo_obra'],
  ];

  $personajes[] = $personaje;
  file_put_contents($archiPersonajes, json_encode($personajes, JSON_PRETTY_PRINT));

  echo "<div class='alert alert-success'> Personaje registrado correctamente. <a href='agregar_personaje.php'>Registrar otro</a></div>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Agregar Personaje</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="p-4">

<h2>Agregar Personaje <?= $codigoObra ? "a la Obra " . htmlspecialchars($codigoObra) : '' ?></h2>

<form method="post" class="w-50">
  <div class="mb-3">
    <label class="form-label" for="cedula">Cedula</label>
    <input id="cedula" name="cedula" type="text" class="form-control" required value="<?= htmlspecialchars($personaje['cedula']) ?>">
  </div>

  <div class="mb-3">
    <label class="form-label" for="foto_url">URL de Foto</label>
    <input id="foto_url" name="foto_url" type="url" class="form-control" required value="<?= htmlspecialchars($personaje['foto_url']) ?>">
  </div>

  <div class="mb-3">
    <label class="form-label" for="nombre">Nombre</label>
    <input id="nombre" name="nombre" type="text" class="form-control" required value="<?= htmlspecialchars($personaje['nombre']) ?>">
  </div>

  <div class="mb-3">
    <label class="form-label" for="apellido">Apellido</label>
    <input id="apellido" name="apellido" type="text" class="form-control" required value="<?= htmlspecialchars($personaje['apellido']) ?>">
  </div>

  <div class="mb-3">
    <label class="form-label" for="fecha_nacimiento">Fecha de Nacimiento</label>
    <input id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="form-control" required value="<?= htmlspecialchars($personaje['fecha_nacimiento']) ?>">
  </div>

  <div class="mb-3">
    <label class="form-label" for="sexo">Sexo</label>
    <select id="sexo" name="sexo" class="form-select" required>
      <option value="Masculino" <?= $personaje['sexo'] === 'Masculino' ? 'selected' : '' ?>>Masculino</option>
      <option value="Femenino" <?= $personaje['sexo'] === 'Femenino' ? 'selected' : '' ?>>Femenino</option>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label" for="habilidades">Habilidades</label>
    <input id="habilidades" name="habilidades" type="text" class="form-control" required value="<?= htmlspecialchars($personaje['habilidades']) ?>">
  </div>

  <div class="mb-3">
    <label class="form-label" for="comida_favorita">Comida Favorita</label>
    <input id="comida_favorita" name="comida_favorita" type="text" class="form-control" required value="<?= htmlspecialchars($personaje['comida_favorita']) ?>">
  </div>

  <div class="mb-3">
    <label class="form-label" for="codigo_obra">Obra Relacionada</label>
    <?php if ($codigoObra): ?>
      <input type="text" class="form-control" readonly value="<?= htmlspecialchars($codigoObra) ?>">
      <input type="hidden" name="codigo_obra" value="<?= htmlspecialchars($codigoObra) ?>">
    <?php else: ?>
      <select id="codigo_obra" name="codigo_obra" class="form-select" required>
        <option value="">-- Selecciona una obra --</option>
        <?php foreach ($obras as $obra): ?>
          <option value="<?= htmlspecialchars($obra['codigo']) ?>" <?= $obra['codigo'] === $personaje['codigo_obra'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($obra['nombre']) ?> (<?= htmlspecialchars($obra['codigo']) ?>)
          </option>
        <?php endforeach; ?>
      </select>
    <?php endif; ?>
  </div>

  <button type="submit" class="btn btn-success">Guardar</button>
  <a href="index.php" class="btn btn-secondary">Volver</a>
</form>

</body>
</html>
