<?php
require_once "../controller/ChuvaController.php";

$controller = new ChuvaController();
$resultado = $controller->index();

// DEBUG — depois pode remover
// echo "<pre>"; print_r($resultado); echo "</pre>";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Probabilidade de Chuva</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .card { padding: 20px; border-radius: 10px; background: #f8f9fa; width: 520px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .prob { font-size: 28px; font-weight: bold; }
        .erro { color: #b00020; }
    </style>
</head>
<body>

<h2>Sistema de Previsão Local</h2>

<div class="card">
<?php
if (!is_array($resultado) || $resultado["status"] !== "ok") {
    echo "<p class='erro'>Erro: "
         . htmlspecialchars($resultado["msg"] ?? "Erro inesperado") 
         . "</p>";
} else {
    $dados = $resultado["dados"];
?>
    <p class="prob">Probabilidade de chuva: 
        <strong><?= $resultado["prob_chuva"] ?>%</strong>
    </p>

    <h4>Dados utilizados:</h4>
    <ul>
        <li>Umidade: <?= round($dados["umidade"] * 100, 1) ?>%</li>
        <li>Temperatura: <?= $dados["temperatura"] ?> °C</li>
        <li>Pressão atual: <?= $dados["pressao_atual"] ?> hPa</li>
        <li>Pressão ~3h atrás: <?= $dados["pressao_antiga"] ?> hPa</li>
        <li>Variação da pressão: <?= $dados["delta_pressao"] ?> hPa</li>
    </ul>
<?php } ?>
</div>

</body>
</html>
