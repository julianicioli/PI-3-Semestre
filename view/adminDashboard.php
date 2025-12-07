<?php
require_once __DIR__ . '/../controller/adminController.php';
require_once __DIR__ . '/../model/Medicao.php';
require_once __DIR__ . '/../controller/avisoController.php'; // incluir função de alerta automático

// Variáveis do modal de sucesso
$avisoEnviado = false;
$redirectAfter = 'adminDashboard.php';

// Verifica se o aviso foi enviado com sucesso
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar_aviso'])) {
    // Processa o envio do aviso
    if (!empty($_POST['emails']) && !empty($_POST['mensagem'])) {
        $emails = $_POST['emails'];
        $mensagem = $_POST['mensagem'];
        
        // Chama a função do controller para enviar os avisos
        enviarAvisoAutomatico($emails, $mensagem);
        
        $avisoEnviado = true;
    }
}

// Configurações
$nivelCritico = 200; // mm
$bairroAlerta = 'Vila Penha do Rio do Peixe';

// Pegar listas únicas de ruas e bairros do banco
$ruas = array_unique(array_column($cidadaos, 'rua'));
$bairroList = array_unique(array_column($cidadaos, 'bairro'));

// Pegar medições do banco
$medicoes = Medicao::listarUltimosDias(7); // últimos 7 dias
$datas = [];
$nivelAgua = [];
$alertaDisparado = false;

foreach($medicoes as $m) {
    $datas[] = date('d/m H:i', strtotime($m['data']));
    $nivelAgua[] = $m['nivel_agua'];

    // Verifica se alguma medição atinge nível crítico
    if($m['nivel_agua'] >= $nivelCritico) {
        $alertaDisparado = true;
    }
}

// Disparo automático do aviso se atingir nível crítico
if ($alertaDisparado) {
    $emailsAlerta = [];
    foreach($cidadaos as $c) {
        if ($c['bairro'] === $bairroAlerta) {
            $emailsAlerta[] = $c['email'];
        }
    }

    if (!empty($emailsAlerta)) {
        $mensagem = "⚠️ Atenção! O nível do rio atingiu $nivelCritico mm no bairro $bairroAlerta. Com previsão de preciptação de chuva em 85%. Tome precauções!";
        enviarAvisoAutomatico($emailsAlerta, $mensagem);
    }
}
?>

<!DOCTYPE html>

<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="ico" href="../img/favicon.ico" />
<title>Dashboard Administrador</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
.modal { display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.45); backdrop-filter: blur(5px); justify-content: center; align-items: center; z-index: 1000; animation: fadeIn 0.3s ease; }
.modal.visible { display: flex; }
.modal-box { background: #fff; width: 320px; padding: 30px 25px; border-radius: 18px; text-align: center; font-family: Arial, sans-serif; box-shadow: 0 8px 30px rgba(0,0,0,0.15); animation: pop 0.25s ease-out; }
.icon { width: 70px; height: 70px; border-radius: 50%; border: 3px solid #2ecc71; display: flex; justify-content: center; align-items: center; margin: 0 auto 15px auto; }
.checkmark { width: 28px; height: 14px; border-left: 3px solid #2ecc71; border-bottom: 3px solid #2ecc71; transform: rotate(-45deg); animation: draw 0.4s ease-out; }
.modal-box h2 { margin-top: 5px; color: #2ecc71; font-size: 22px; }
.modal-box p { color: #555; margin: 10px 0 20px; }
.modal-box button { background: #2ecc71; color: #fff; border: none; padding: 10px 25px; border-radius: 10px; cursor: pointer; font-size: 15px; transition: 0.2s; }
.modal-box button:hover { background: #27ae60; }
@keyframes pop { from { transform: scale(0.8); opacity: 0; } to   { transform: scale(1); opacity: 1; } }
@keyframes fadeIn { from { opacity: 0; } to   { opacity: 1; } }
@keyframes draw { from { width: 0; height: 0; } to   { width: 28px; height: 14px; } }
</style>

<style>
body { background-color: #f4f6f8; }
.sidebar { width: 240px; height: 100vh; position: fixed; left: 0; top: 0; background-image: url('../img/backgroundSidebar.png'); background-size: cover; background-position: center; background-repeat: no-repeat; color: #fff; padding: 1.5rem; }
.sidebar a { color: #fff; text-decoration: none; display: flex; align-items: center; margin-bottom: .8rem; font-weight: 500; }
.sidebar a:hover { opacity: 0.8; }
.sidebar i { margin-right: .5rem; }
main { margin-left: 260px; padding: 2rem; }
.card { border: none; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 1.5rem; padding: 1.5rem; }
h2, h3 { margin-top: 1rem; }
.table-responsive { max-height: 600px; overflow-y: auto; }
textarea { width: 100%; height: 80px; padding: 0.5rem; margin-bottom: 0.5rem; border-radius: 5px; border: 1px solid #ccc; }
.alerta-critico { background-color: #ffcccc; padding: 0.75rem; border-radius: 5px; margin-bottom: 1rem; font-weight: bold; color: #900; }
</style>
</head>
<body>

<div class="sidebar">
    <h4 class="fw-bold mb-4 text-center">AQUASENSE UI</h4>
    <a href="../index.php"><i class="bi bi-bar-chart-line"></i> Dashboard</a>
    <a href="adminDashboard.php"><i class="bi bi-bell"></i> Avisos</a>
    <a href="relatorio.php"><i class="bi bi-file-earmark-text"></i> Gerar Relatórios</a>
    <hr class="border-light">
    <small class="text-white-50 d-block text-center">v2.0 • PHP MVC</small>
</div>

<main>
<h2 class="fw-semibold mb-4">Dashboard Administrador</h2>

<?php if(!empty($alertaDisparado)): ?>

<div class="alerta-critico">
    ⚠️ Atenção! O nível do rio atingiu o valor crítico de <?= $nivelCritico ?> mm no bairro <?= $bairroAlerta ?>, com probablidade de preciptação de chuva em 85%. Envio de alerta disparado.
</div>
<?php endif; ?>

<!-- Gráfico de nível de água -->

<div class="card mb-4">
    <h3 class="mb-3">Nível de Água do Rio (últimos 7 dias)</h3>
    <canvas id="graficoNivel" style="max-height:300px;"></canvas>
</div>

<h3>Cidadãos</h3>
<div class="card p-3 mb-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Email</th>
                    <th>Rua</th>
                    <th>Bairro</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($cidadaos)): ?>
                    <?php foreach($cidadaos as $c): ?>
                    <tr class="text-center">
                        <td><?= htmlspecialchars($c['nome']) ?></td>
                        <td><?= htmlspecialchars($c['cpf']) ?></td>
                        <td><?= htmlspecialchars($c['email']) ?></td>
                        <td class="rua"><?= htmlspecialchars($c['rua']) ?></td>
                        <td class="bairro"><?= htmlspecialchars($c['bairro']) ?></td>
                        <td><?= htmlspecialchars($c['cidade']) ?></td>
                        <td><?= htmlspecialchars($c['estado']) ?></td>
                        <td class="d-flex justify-content-center gap-1">
                            <a href="?excluir_cidadao=<?= $c['id'] ?>" class="btn btn-danger btn-sm" title="Excluir"><i class="bi bi-trash-fill"></i></a>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarCidadao<?= $c['id'] ?>" title="Editar"><i class="bi bi-pencil-square"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="9" class="text-center">Nenhum cidadão encontrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<h3>Filtrar e enviar aviso</h3>
<form method="POST">
    <div class="row mb-3">
        <div class="col">
            <label for="filtroRua">Filtrar por Rua:</label>
            <select id="filtroRua" class="form-select" onchange="selecionarPorRua()">
                <option value="">--Selecionar Rua--</option>
                <?php foreach($ruas as $r): ?>
                    <option value="<?= htmlspecialchars($r) ?>"><?= htmlspecialchars($r) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col">
            <label for="filtroBairro">Filtrar por Bairro:</label>
            <select id="filtroBairro" class="form-select" onchange="selecionarPorBairro()">
                <option value="">--Selecionar Bairro--</option>
                <?php foreach($bairroList as $b): ?>
                    <option value="<?= htmlspecialchars($b) ?>"><?= htmlspecialchars($b) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>


<div class="mb-3">
    <label>Mensagem de alerta:</label>
    <textarea name="mensagem" placeholder="Mensagem de alerta" required><?= $_POST['mensagem'] ?? '' ?></textarea>
</div>

<div class="table-responsive mb-3">
    <table class="table table-bordered">
        <thead class="table-dark text-center">
            <tr>
                <th>Selecionar</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Cidade</th>
                <th>Rua</th>
                <th>Bairro</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($cidadaos as $c): ?>
            <tr>
                <td><input type="checkbox" class="email-checkbox" name="emails[]" value="<?= htmlspecialchars($c['email']) ?>"></td>
                <td><?= htmlspecialchars($c['nome']) ?></td>
                <td><?= htmlspecialchars($c['email']) ?></td>
                <td><?= htmlspecialchars($c['cidade']) ?></td>
                <td class="rua"><?= htmlspecialchars($c['rua']) ?></td>
                <td class="bairro"><?= htmlspecialchars($c['bairro']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

            <button type="submit" name="enviar_aviso" class="btn btn-danger"><i class="bi bi-exclamation-triangle-fill"></i> Enviar Aviso</button>
        </form>

        <div id="modal-login" class="modal">
            <div class="modal-box">
                <div class="icon">
                    <span class="checkmark"></span>
                </div>
                <h2>Aviso enviado!</h2>
                <button onclick="fecharModalLogin()">Ok</button>
            </div>
        </div>

<script>
function selecionarPorRua() {
    let ruaSelecionada = document.getElementById('filtroRua').value;
    document.querySelectorAll('.email-checkbox').forEach(cb => cb.checked = false);
    if(ruaSelecionada) {
        document.querySelectorAll('tr').forEach(tr => {
            let tdRua = tr.querySelector('.rua');
            let cb = tr.querySelector('.email-checkbox');
            if(tdRua && tdRua.textContent === ruaSelecionada && cb) cb.checked = true;
        });
    }
}

function selecionarPorBairro() {
    let bairroSelecionado = document.getElementById('filtroBairro').value;
    document.querySelectorAll('.email-checkbox').forEach(cb => cb.checked = false);
    if(bairroSelecionado) {
        document.querySelectorAll('tr').forEach(tr => {
            let tdBairro = tr.querySelector('.bairro');
            let cb = tr.querySelector('.email-checkbox');
            if(tdBairro && tdBairro.textContent === bairroSelecionado && cb) cb.checked = true;
        });
    }
}
</script>

<script>
const ctx = document.getElementById('graficoNivel').getContext('2d');
const graficoNivel = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($datas) ?>,
        datasets: [{
            label: 'Nível de Água (mm)',
            data: <?= json_encode($nivelAgua) ?>,
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            tension: 0.3,
            fill: true,
            pointRadius: 4,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: true } },
        scales: { y: { beginAtZero: true } }
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function abrirModalLogin(){
        const m = document.getElementById('modal-login');
        if (!m) return;
        m.classList.add('visible');
        m.setAttribute('aria-hidden','false');
    }

    function fecharModalLogin(){
        const m = document.getElementById('modal-login');
        if (!m) return;
        m.classList.remove('visible');
        m.setAttribute('aria-hidden','true');
    }

    <?php if (!empty($avisoEnviado)): ?>
    window.addEventListener('DOMContentLoaded', function(){
        try{
            abrirModalLogin();
        }catch(e){ console.error(e); }
    });
    <?php endif; ?>
    </script>
</body>
</html>
