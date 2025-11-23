<?php
require_once __DIR__ . '/../model/Medicao.php';

// Definir filtro do GET
$filtro = $_GET['filtro'] ?? '7dias';

switch($filtro){
    case '7dias': $medicoes = Medicao::listarUltimosDias(7); break;
    case '1mes':  $medicoes = Medicao::listarUltimosMeses(1); break;
    case '1ano':  $medicoes = Medicao::listarUltimosAnos(1); break;
    default: $medicoes = Medicao::listarUltimosDias(7); break;
}
?>

<!DOCTYPE html>

<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Relatórios - Aquasense</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<style>
body { background-color: #f4f6f8; }
.sidebar {
  width: 240px;
  height: 100vh;
  position: fixed;
  left: 0;
  top: 0;
  background-image: url('../img/backgroundSidebar.png');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  color: #fff;
  padding: 1.5rem;
}
.sidebar a { color: #fff; text-decoration: none; display: flex; align-items: center; margin-bottom: .8rem; font-weight: 500; }
.sidebar a:hover { opacity: 0.8; }
.sidebar i { margin-right: .5rem; }
main { margin-left: 260px; padding: 2rem; }
.card { border: none; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 1.5rem; }
h2, h3 { margin-top: 1rem; }
.table-responsive { max-height: 600px; overflow-y: auto; }
</style>
</head>
<body>

<div class="sidebar">
    <h4 class="fw-bold mb-4 text-center">AQUASENSE UI</h4>
    <a href="../index.php"><i class="bi bi-bar-chart-line"></i> Dashboard</a>
    <a href="adminDashboard.php"><i class="bi bi-bell""></i> Avisos</a>
    <a href="relatorio.php"><i class="bi bi-file-earmark-text"></i> Gerar Relatórios</a>
    <hr class="border-light">
    <small class="text-white-50 d-block text-center">v2.0 • PHP MVC</small>
</div>

<main>
<h2 class="fw-semibold mb-4">Relatórios de Medições do Rio</h2>

<div class="card p-3 mb-4">
    <h3 class="mb-3">Filtrar período</h3>
    <form method="GET" class="row g-2 align-items-center">
        <div class="col-auto">
            <select name="filtro" class="form-select">
                <option value="7dias" <?= $filtro=='7dias'?'selected':'' ?>>Últimos 7 dias</option>
                <option value="1mes" <?= $filtro=='1mes'?'selected':'' ?>>Último mês</option>
                <option value="1ano" <?= $filtro=='1ano'?'selected':'' ?>>Último ano</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary"><i class="bi bi-funnel-fill"></i> Filtrar</button>
            <a href="../controller/exportarRelatorio.php?filtro=<?= $filtro ?>" class="btn btn-success">Exportar CSV</a>        </div>
    </form>
</div>

<div class="card p-3">
    <h3 class="mb-3">Medições</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>Data/Hora</th>
                    <th>Nível (mm)</th>
                    <th>Vazão (L/s)</th>
                    <th>Temperatura (°C)</th>
                    <th>Umidade (%)</th>
                    <th>Pressão (hPa)</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($medicoes)): ?>
                    <?php foreach($medicoes as $m): ?>
                    <tr class="text-center">
                        <td><?= htmlspecialchars($m['data']) ?></td>
                        <td><?= htmlspecialchars($m['nivel_agua']) ?></td>
                        <td><?= htmlspecialchars($m['vazao']) ?></td>
                        <td><?= htmlspecialchars($m['temperatura']) ?></td>
                        <td><?= htmlspecialchars($m['umidade']) ?></td>
                        <td><?= htmlspecialchars($m['pressao_atmosferica']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center">Nenhuma medição encontrada para este período.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
