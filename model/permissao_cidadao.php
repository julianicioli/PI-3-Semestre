<?php
    require_once('conexao.php');

    $bancodedados = new db();

    $link = $bancodedados->conecta_mysql();

    $sql = "insert into cadastrocidadao(nome, cep, estado, cidade, cpf, email, senha) values('$nome', $cep, $estado, $cidade, $cpf, $email, '$senha')";
?>