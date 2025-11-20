<?php
header("Content-Type: application/json");

// Permite requisições JS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . "/conexao.php";

$db = new db();
$link = $db->conecta_mysql();

// Recebe JSON do JavaScript
$json = file_get_contents("php://input");
$data = json_decode($json, true);

// Verificação de segurança básica
if (!$data) {
    echo json_encode([
        "status" => "erro",
        "msg" => "JSON inválido recebido",
        "json_recebido" => $json
    ]);
    exit;
}

// Mapeia os nomes enviados pelo JS → nomes do banco
$nivel     = $data["nivel"];        // JS → PHP
$temperatura = $data["temperatura"];
$umidade   = $data["umidade"];
$pressao   = $data["pressao"];
$bateria   = $data["bateria"];

// Query corrigida com nomes da tabela REAL
$stmt = mysqli_prepare(
    $link,
    "INSERT INTO sensor_readings (nivel_mm, temp_c, umid, press, batt)
     VALUES (?, ?, ?, ?, ?)"
);

mysqli_stmt_bind_param($stmt, "idiii",
    $nivel,         // int
    $temperatura,   // decimal(5,2)
    $umidade,       // int
    $pressao,       // int
    $bateria        // int
);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(["status" => "ok"]);
} else {
    echo json_encode([
        "status" => "erro",
        "msg" => mysqli_stmt_error($stmt)
    ]);
}

mysqli_stmt_close($stmt);
mysqli_close($link);
