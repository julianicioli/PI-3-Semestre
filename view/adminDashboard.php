<?php
// adminDashboard.php
require_once __DIR__ . '/../controller/adminController.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>

<!-- Favicon -->
  <link rel="icon" type="ico" href="../img/favicon.ico" />

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Administrador</title>
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

  /* imagem de fundo */
  background-image: url('../img/backgroundSidebar.png');
  background-size: cover;      /* cobre toda a sidebar */
  background-position: center; /* centraliza a imagem */
  background-repeat: no-repeat; /* não repete */
  
  color: #fff;
  padding: 1.5rem;
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
    <h4 class="fw-bold mb-4 text-center"> AQUASENSE UI</h4>
    <a href="../index.html"><i class="bi bi-bar-chart-line"></i> Dashboard</a>
    <hr class="border-light">
    <small class="text-white-50 d-block text-center">v2.0 • PHP MVC</small>
</div>

<main>
    <h2 class="fw-semibold mb-4">Dashboard Administrador</h2>

    <!-- Cidadãos -->
    <h3>Cidadãos</h3>
    <div class="card p-3 mb-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Email</th>
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
                        <td>
                            <a href="?excluir_cidadao=<?= $c['id'] ?>" class="btn btn-danger btn-sm">Excluir</a>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarCidadao<?= $c['id'] ?>">Editar</button>
                        </td>
                    </tr>

                    <!-- Modal Edição Cidadão -->
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
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Funcionários -->
    <h3>Funcionários</h3>
    <div class="card p-3 mb-4">
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#novoFuncionario">Novo Funcionário</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Cargo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($funcionarios)): ?>
                    <?php foreach($funcionarios as $f): ?>
                    <tr>
                        <td><?= $f['nome'] ?></td>
                        <td><?= $f['cpf'] ?></td>
                        <td><?= $f['cargo'] ?></td>
                        <td>
                            <a href="?excluir_funcionario=<?= $f['id'] ?>" class="btn btn-danger btn-sm">Excluir</a>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarFuncionario<?= $f['id'] ?>">Editar</button>
                        </td>
                    </tr>

                    <!-- Modal Edição Funcionário -->
                    <div class="modal fade" id="editarFuncionario<?= $f['id'] ?>" tabindex="-1">
                      <div class="modal-dialog">
                        <form method="POST" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Editar Funcionário</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" value="<?= $f['id'] ?>">
                                <input class="form-control mb-2" name="nome" value="<?= $f['nome'] ?>">
                                <input class="form-control mb-2" name="rg" value="<?= $f['rg'] ?>">
                                <input class="form-control mb-2" name="cpf" value="<?= $f['cpf'] ?>">
                                <input class="form-control mb-2" name="numero_registro" value="<?= $f['numero_registro'] ?>">
                                <input class="form-control mb-2" name="cargo" value="<?= $f['cargo'] ?>">
                                <input class="form-control mb-2" name="senha" value="<?= $f['senha'] ?>">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="atualizar_funcionario" class="btn btn-primary">Salvar</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                      </div>
                    </div>

                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Novo Funcionário -->
    <div class="modal fade" id="novoFuncionario" tabindex="-1">
      <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Funcionário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input class="form-control mb-2" name="nome" placeholder="Nome">
                <input class="form-control mb-2" name="rg" placeholder="RG">
                <input class="form-control mb-2" name="cpf" placeholder="CPF">
                <input class="form-control mb-2" name="numero_registro" placeholder="Número de Registro">
                <input class="form-control mb-2" name="cargo" placeholder="Cargo">
                <input class="form-control mb-2" name="senha" placeholder="Senha">
            </div>
            <div class="modal-footer">
                <button type="submit" name="novo_funcionario" class="btn btn-success">Cadastrar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </form>
      </div>
    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
