<?php
    require_once('conexao.php');

    $bancodedados = new db();

    $link = $bancodedados->conecta_mysql();

    $sql = "insert into cadastrofuncionario(nome, rg, cpf, numero_registro, cargo, senha) values('$nome', '$rg', '$cpf', '$numero_registro', '$cargo', '$senha')";
?>
