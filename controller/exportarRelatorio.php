<?php
require_once __DIR__ . '/../model/Medicao.php';

// Pega o filtro do GET, padrão 7 dias
$filtro = $_GET['filtro'] ?? '7dias';

// Obtém os dados de acordo com o filtro
switch($filtro){
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

// Define headers para CSV
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment;filename=relatorio_medicoes.csv');

// Abre a saída
$output = fopen('php://output', 'w');

// Cabeçalho do CSV
fputcsv($output, ['Data/Hora','Nivel (mm)','Vazao (L/s)','Temperatura (°C)','Umidade (%)','Pressao Atmosferica'], ';');

// Preenche os dados
foreach($medicoes as $m) {
    fputcsv($output, [
        $m['data'],
        $m['nivel_agua'],
        $m['vazao'],
        $m['temperatura'],
        $m['umidade'],
        $m['pressao_atmosferica']
    ], ';');
}

fclose($output);
exit;
