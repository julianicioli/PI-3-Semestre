<?php
require_once __DIR__ . '/conexao.php';

class Medicao {

    private static function listarPorIntervalo($intervalo, $tipo) {
        $db = new db();
        $link = $db->conecta_mysql();
        $query = "SELECT * FROM medicoes WHERE data >= DATE_SUB(NOW(), INTERVAL ? $tipo) ORDER BY data DESC";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, "i", $intervalo);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $medicoes = [];
        while($row = mysqli_fetch_assoc($result)) {
            $medicoes[] = $row;
        }
        mysqli_stmt_close($stmt);
        return $medicoes;
    }

    public static function listarUltimosDias($dias) {
        return self::listarPorIntervalo($dias, "DAY");
    }

    public static function listarUltimosMeses($meses) {
        return self::listarPorIntervalo($meses, "MONTH");
    }

    public static function listarUltimosAnos($anos) {
        return self::listarPorIntervalo($anos, "YEAR");
    }
}
