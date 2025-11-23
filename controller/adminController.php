<?php
require_once __DIR__ . '/../model/Cidadao.php';
require_once __DIR__ . '/../model/Funcionario.php';

$cidadaos = Cidadao::listarTodos();
$funcionarios = Funcionario::listarTodos();

// Excluir cidadão
if (isset($_GET['excluir_cidadao'])) {
    Cidadao::excluir($_GET['excluir_cidadao']);
    header("Location: adminDashboard.php");
    exit;
}

// Atualizar cidadão (agora com rua e bairro)
if (isset($_POST['atualizar_cidadao'])) {
    Cidadao::atualizar(
        $_POST['id'],
        $_POST['nome'],
        $_POST['cep'],
        $_POST['estado'],
        $_POST['cidade'],
        $_POST['rua'],
        $_POST['bairro'],
        $_POST['cpf'],
        $_POST['email'],
        $_POST['senha']
    );
    header("Location: adminDashboard.php");
    exit;
}

// Filtrar cidadãos por região (opcional, usado para envio de aviso)
$regiao = $_POST['regiao'] ?? null;
if ($regiao) {
    $cidadaos = Cidadao::listarPorRegiao($regiao);
}

require_once __DIR__ . '/../view/adminDashboard.php';
