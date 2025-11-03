<?php
require_once __DIR__ . '/conexao.php';

class Funcionario {

    public static function listarTodos() {
        $db = new db();
        $link = $db->conecta_mysql();

        $result = mysqli_query($link, "SELECT * FROM cadastrofuncionario");
        $funcionarios = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $funcionarios[] = $row;
            }
        }
        return $funcionarios;
    }

    public static function criar($nome, $rg, $cpf, $numero_registro, $cargo, $senha) {
        $db = new db();
        $link = $db->conecta_mysql();
        $stmt = mysqli_prepare($link, "INSERT INTO cadastrofuncionario (nome, rg, cpf, numero_registro, cargo, senha) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'ssssss', $nome, $rg, $cpf, $numero_registro, $cargo, $senha);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    public static function excluir($id) {
        $db = new db();
        $link = $db->conecta_mysql();
        $stmt = mysqli_prepare($link, "DELETE FROM cadastrofuncionario WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    public static function atualizar($id, $nome, $rg, $cpf, $numero_registro, $cargo, $senha) {
        $db = new db();
        $link = $db->conecta_mysql();
        $stmt = mysqli_prepare($link, "UPDATE cadastrofuncionario SET nome=?, rg=?, cpf=?, numero_registro=?, cargo=?, senha=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "ssssssi", $nome, $rg, $cpf, $numero_registro, $cargo, $senha, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}
