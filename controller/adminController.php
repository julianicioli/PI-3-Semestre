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

// Excluir funcionário
if (isset($_GET['excluir_funcionario'])) {
    Funcionario::excluir($_GET['excluir_funcionario']);
    header("Location: adminDashboard.php");
    exit;
}

// Atualizar cidadão
if (isset($_POST['atualizar_cidadao'])) {
    Cidadao::atualizar(
        $_POST['id'],
        $_POST['nome'],
        $_POST['cep'],
        $_POST['estado'],
        $_POST['cidade'],
        $_POST['cpf'],
        $_POST['email'],
        $_POST['senha']
    );
    header("Location: adminDashboard.php");
    exit;
}

// Atualizar funcionário
if (isset($_POST['atualizar_funcionario'])) {
    Funcionario::atualizar(
        $_POST['id'],
        $_POST['nome'],
        $_POST['rg'],
        $_POST['cpf'],
        $_POST['numero_registro'],
        $_POST['cargo'],
        $_POST['senha']
    );
    header("Location: adminDashboard.php");
    exit;
}

// Criar novo funcionário
if (isset($_POST['novo_funcionario'])) {
    Funcionario::criar(
        $_POST['nome'],
        $_POST['rg'],
        $_POST['cpf'],
        $_POST['numero_registro'],
        $_POST['cargo'],
        $_POST['senha']
    );
    header("Location: adminDashboard.php");
    exit;
}

require_once __DIR__ . '/../view/adminDashboard.php';
