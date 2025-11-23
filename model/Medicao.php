<?php
require_once __DIR__ . '/conexao.php';

class Medicao {

    public static function listarUltimosDias($dias) {
        $db = new db();
        $link = $db->conecta_mysql();
        $stmt = mysqli_prepare($link, "SELECT * FROM medicoes WHERE datahora >= DATE_SUB(NOW(), INTERVAL ? DAY) ORDER BY datahora DESC");
        mysqli_stmt_bind_param($stmt, "i", $dias);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $medicoes = [];
        while($row = mysqli_fetch_assoc($result)) {
            $medicoes[] = $row;
        }
        mysqli_stmt_close($stmt);
        return $medicoes;
    }

    public static function listarUltimosMeses($meses) {
        $db = new db();
        $link = $db->conecta_mysql();
        $stmt = mysqli_prepare($link, "SELECT * FROM medicoes WHERE datahora >= DATE_SUB(NOW(), INTERVAL ? MONTH) ORDER BY datahora DESC");
        mysqli_stmt_bind_param($stmt, "i", $meses);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $medicoes = [];
        while($row = mysqli_fetch_assoc($result)) {
            $medicoes[] = $row;
        }
        mysqli_stmt_close($stmt);
        return $medicoes;
    }

    public static function listarUltimosAnos($anos) {
        $db = new db();
        $link = $db->conecta_mysql();
        $stmt = mysqli_prepare($link, "SELECT * FROM medicoes WHERE datahora >= DATE_SUB(NOW(), INTERVAL ? YEAR) ORDER BY datahora DESC");
        mysqli_stmt_bind_param($stmt, "i", $anos);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $medicoes = [];
        while($row = mysqli_fetch_assoc($result)) {
            $medicoes[] = $row;
        }
        mysqli_stmt_close($stmt);
        return $medicoes;
    }
}
