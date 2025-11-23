<?php
require_once __DIR__ . '/../controller/adminController.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cidadãos - Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<style>
body { background-color: #f4f6f8; }
.sidebar {
  width: 240px; height: 100vh; position: fixed; left: 0; top: 0;
  background-image: url('../img/backgroundSidebar.png'); background-size: cover; color: #fff; padding: 1.5rem;
}
.sidebar a { color: #fff; text-decoration: none; display: flex; align-items: center; margin-bottom: .8rem; font-weight: 500; }
.sidebar a:hover { opacity: 0.8; }
.sidebar i { margin-right: .5rem; }
main { margin-left: 260px; padding: 2rem; }
.card { border: none; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
h3 { margin-top: 2rem; }
</style>
</head>
<body>

<div class="sidebar">
    <h4 class="fw-bold mb-4 text-center">AQUASENSE UI</h4>
    <a href="adminDashboard.php"><i class="bi bi-bar-chart-line"></i> Dashboard</a>
    <hr class="border-light">
    <small class="text-white-50 d-block text-center">v2.0 • PHP MVC</small>
</div>

<main>
<h2 class="fw-semibold mb-4">Cidadãos</h2>

<!-- Filtro por região -->
<form method="POST" class="mb-3 d-flex gap-2">
    <input type="text" name="regiao" placeholder="Cidade ou Estado" class="form-control" value="<?= $_POST['regiao'] ?? '' ?>">
    <button class="btn btn-primary">Filtrar</button>
    <a href="adminCidadaos.php" class="btn btn-secondary">Limpar</a>
</form>

<!-- Botão enviar aviso -->
<form method="POST" action="../controller/avisoController.php" class="mb-4">
    <input type="hidden" name="regiao" value="<?= $_POST['regiao'] ?? '' ?>">
    <button type="submit" name="enviar_aviso" class="btn btn-danger">Enviar aviso de risco de transbordo</button>
</form>

<div class="card p-3">
<table class="table table-bordered table-hover">
<thead>
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
    <tr>
        <td><?= $c['nome'] ?></td>
        <td><?= $c['cpf'] ?></td>
        <td><?= $c['email'] ?></td>
        <td><?= $c['rua'] ?></td>
        <td><?= $c['bairro'] ?></td>
        <td><?= $c['cidade'] ?></td>
        <td><?= $c['estado'] ?></td>
        <td>
            <a href="?excluir_cidadao=<?= $c['id'] ?>" class="btn btn-danger btn-sm">Excluir</a>
            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarCidadao<?= $c['id'] ?>">Editar</button>
        </td>
    </tr>

    <!-- Modal Edição -->
    <div class="modal fade" id="editarCidadao<?= $c['id'] ?>" tabindex="-1">
      <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Cidadão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" value="<?= $c['id'] ?>">
                <input class="form-control mb-2" name="nome" value="<?= $c['nome'] ?>">
                <input class="form-control mb-2" name="cep" value="<?= $c['cep'] ?>">
                <input class="form-control mb-2" name="estado" value="<?= $c['estado'] ?>">
                <input class="form-control mb-2" name="cidade" value="<?= $c['cidade'] ?>">
                <input class="form-control mb-2" name="rua" value="<?= $c['rua'] ?>">
                <input class="form-control mb-2" name="bairro" value="<?= $c['bairro'] ?>">
                <input class="form-control mb-2" name="cpf" value="<?= $c['cpf'] ?>">
                <input class="form-control mb-2" name="email" value="<?= $c['email'] ?>">
                <input class="form-control mb-2" name="senha" value="<?= $c['senha'] ?>">
            </div>
            <div class="modal-footer">
                <button type="submit" name="atualizar_cidadao" class="btn btn-primary">Salvar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </form>
      </div>
    </div>

    <?php endforeach; ?>
<?php else: ?>
<tr><td colspan="8" class="text-center">Nenhum cidadão encontrado.</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
