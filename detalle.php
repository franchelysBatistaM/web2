<?php
function cuentaDedad($fecha) {
  $nacimiento = new DateTime($fecha);
  $hoy = new DateTime();
  return $hoy->diff($nacimiento)->y;
}

function zodiacO($fecha) {
  $mes_dia = date('m-d', strtotime($fecha));
  $signos = [
    'Capricornio' => ['12-22', '01-19'],
    'Acuario'     => ['01-20', '02-18'],
    'Piscis'      => ['02-19', '03-20'],
    'Aries'       => ['03-21', '04-19'],
    'Tauro'       => ['04-20', '05-20'],
    'Geminis'     => ['05-21', '06-20'],
    'Cancer'      => ['06-21', '07-22'],
    'Leo'         => ['07-23', '08-22'],
    'Virgo'       => ['08-23', '09-22'],
    'Libra'       => ['09-23', '10-22'],
    'Escorpio'    => ['10-23', '11-21'],
    'Sagitario'   => ['11-22', '12-21'],
  ];

  foreach ($signos as $signo => [$inicio, $fin]) {
    if (($mes_dia >= $inicio && $mes_dia <= '12-31') || ($mes_dia >= '01-01' && $mes_dia <= $fin)) {
      return $signo;
    }
  }
  return 'Desconocido';
}

$codigo = $_GET['codigo'] ?? '';
$obras = file_exists('datos/obras.json') ? json_decode(file_get_contents('datos/obras.json'), true) : [];
$personajes = file_exists('datos/personajes.json') ? json_decode(file_get_contents('datos/personajes.json'), true) : [];

$obra = null;
foreach ($obras as $o) {
  if ($o['codigo'] == $codigo) {
    $obra = $o;
    break;
  }
}

if (!$obra) {
  echo "Obra no encontrada.";
  exit;
}

$personajes_de_obra = array_filter($personajes, fn($p) => $p['codigo_obra'] == $codigo);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Detalle de Obra</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

<div class="d-flex justify-content-between align-items-center mb-4">
  <h2>Detalle de Obra</h2>
  <button class="btn btn-outline-secondary" onclick="window.print()"> Imprimir</button>
</div>

<div class="card mb-4">
  <div class="row g-0">
    <div class="col-md-4">
      <img src="<?= htmlspecialchars($obra['foto_url']) ?>" class="img-fluid rounded-start" alt="Imagen de la obra">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h4 class="card-title"><?= htmlspecialchars($obra['nombre']) ?></h4>
        <p><strong>Tipo:</strong> <?= htmlspecialchars($obra['tipo']) ?></p>
        <p><strong>Pais:</strong> <?= htmlspecialchars($obra['pais']) ?></p>
        <p><strong>Autor:</strong> <?= htmlspecialchars($obra['autor']) ?></p>
        <p class="card-text"><strong>Descripcion:</strong><br><?= nl2br(htmlspecialchars($obra['descripcion'])) ?></p>
      </div>
    </div>
  </div>
</div>

<h4>Personajes</h4>
<?php if (empty($personajes_de_obra)): ?>
  <div class="alert alert-info">No hay personajes registrados para esta obra.</div>
<?php else: ?>
  <div class="row row-cols-1 row-cols-md-2 g-4">
    <?php foreach ($personajes_de_obra as $p): ?>
      <div class="col">
        <div class="card h-100">
          <div class="row g-0">
            <div class="col-md-4 text-center">
              <img src="<?= htmlspecialchars($p['foto_url']) ?>" class="img-fluid rounded-start p-2" alt="Foto">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($p['nombre'] . ' ' . $p['apellido']) ?></h5>
                <p class="card-text mb-1"><strong>Edad:</strong> <?= cuentaDedad($p['fecha_nacimiento']) ?> anios</p>
                <p class="card-text mb-1"><strong>Signo:</strong> <?= zodiacO($p['fecha_nacimiento']) ?></p>
                <p class="card-text mb-1"><strong>Sexo:</strong> <?= htmlspecialchars($p['sexo']) ?></p>
                <p class="card-text mb-1"><strong>Habilidades:</strong> <?= htmlspecialchars($p['habilidades']) ?></p>
                <p class="card-text"><strong>Comida favorita:</strong> <?= htmlspecialchars($p['comida_favorita']) ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<div class="mt-4 text-center">
  <a href="index.php" class="btn btn-primary">Volver al Inicio</a>
</div>

</body>
</html>
