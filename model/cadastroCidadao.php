<?php
    $nome = $_POST['nome'];
    $cep = $_POST['cep'];
    $estado = $_POST['estado'];  
    $cidade = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $rua = $_POST['rua'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
   

    // Recebe dados do formulário
    require_once __DIR__ . '/conexao.php';

    $bancodedados = new db();
    $link = $bancodedados->conecta_mysql();

    // Prepared statement seguro
    $stmt = mysqli_prepare($link, "INSERT INTO cadastrocidadao (nome, cep, estado, cidade, bairro, rua, cpf, email, senha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die('Prepare failed: ' . mysqli_error($link));
    }

    mysqli_stmt_bind_param($stmt, 'sssssssss', $nome, $cep, $estado, $cidade, $bairro, $rua, $cpf, $email, $senha);

    if (mysqli_stmt_execute($stmt)) {
        // redireciona para a página do formulário indicando sucesso
        header('Location: ../TelaCadastroCidadao.html?sucesso=1');
        exit;
    } else {
        echo 'Erro ao cadastrar: ' . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);
?>