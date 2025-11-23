<?php
require_once __DIR__ . '/../model/Medicao.php';

$filtro = $_GET['filtro'] ?? '7dias';

switch($filtro){
    case '7dias': $medicoes = Medicao::listarUltimosDias(7); break;
    case '1mes':  $medicoes = Medicao::listarUltimosMeses(1); break;
    case '1ano':  $medicoes = Medicao::listarUltimosAnos(1); break;
}

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=relatorio_medicoes.csv');

$output = fopen('php://output', 'w');
fputcsv($output, ['Data/Hora','Nível','Vazão','Temperatura']);

foreach($medicoes as $m) {
    fputcsv($output, [$m['datahora'], $m['nivel'], $m['vazao'], $m['temperatura']]);
}
fclose($output);
exit;
