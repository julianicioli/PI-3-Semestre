<?php
require_once __DIR__ . '/conexao.php';

class Cidadao {

    public static function listarTodos() {
        $db = new db();
        $link = $db->conecta_mysql();

        $result = mysqli_query($link, "SELECT * FROM cadastrocidadao");
        $cidadaos = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $cidadaos[] = $row;
            }
        }
        return $cidadaos;
    }

    public static function excluir($id) {
        $db = new db();
        $link = $db->conecta_mysql();
        $stmt = mysqli_prepare($link, "DELETE FROM cadastrocidadao WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    public static function atualizar($id, $nome, $cep, $estado, $cidade, $cpf, $email, $senha) {
        $db = new db();
        $link = $db->conecta_mysql();
        $stmt = mysqli_prepare($link, "UPDATE cadastrocidadao SET nome=?, cep=?, estado=?, cidade=?, cpf=?, email=?, senha=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "sssssssi", $nome, $cep, $estado, $cidade, $cpf, $email, $senha, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}
