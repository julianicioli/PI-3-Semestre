<?php
require_once __DIR__ . '/../model/Medicao.php';

$periodo = $_GET['periodo'] ?? '7dias'; // padrão 7 dias

switch($periodo) {
    case '7dias':
        $medicoes = Medicao::listarUltimosDias(7);
        break;
    case '1mes':
        $medicoes = Medicao::listarUltimosMeses(1);
        break;
    case '1ano':
        $medicoes = Medicao::listarUltimosAnos(1);
        break;
    default:
        $medicoes = Medicao::listarUltimosDias(7);
}

// Para exportar CSV
if(isset($_GET['exportar']) && $_GET['exportar'] == 1) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=relatorio_medicoes.csv');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Data/Hora','Nível','Vazão','Temperatura','Umidade','Pressão']);
    foreach($medicoes as $m) {
        fputcsv($output, [
            $m['datahora'],
            $m['nivel'],
            $m['vazao'],
            $m['temperatura'],
            $m['umidade'],
            $m['pressao']
        ]);
    }
    fclose($output);
    exit;
}

require_once __DIR__ . '/../view/medicoesDashboard.php';
