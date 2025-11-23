<?php
header("Content-Type: application/json");

// Permite requisições JS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . "/conexao.php";

$db = new db();
$link = $db->conecta_mysql();

// Recebe JSON enviado pelo JS
$json = file_get_contents("php://input");
$data = json_decode($json, true);

// Verificação básica
if (!$data) {
    echo json_encode([
        "status" => "erro",
        "msg" => "JSON inválido",
        "recebido" => $json
    ]);
    exit;
}

// ====== MAPEIA CAMPOS RECEBIDOS DO JS ======
$nivel       = $data["nivel"];        // int
$temperatura = $data["temperatura"];  // decimal(5,2)
$umidade     = $data["umidade"];      // int
$pressao     = $data["pressao"];      // int
$vazao       = $data["flow"];         // int  <<< AGORA É FLOW!

// ====== PREPARA INSERT PARA A NOVA TABELA ======
$stmt = mysqli_prepare(
    $link,
    "INSERT INTO Medicoes (nivel_agua, temperatura, umidade, pressao_atmosferica, vazao)
     VALUES (?, ?, ?, ?, ?)"
);

// Tipos → "idiii"  
// i = INT  |  d = DECIMAL
mysqli_stmt_bind_param(
    $stmt,
    "idiii",
    $nivel,        // INT
    $temperatura,  // DECIMAL(5,2)
    $umidade,      // INT
    $pressao,      // INT
    $vazao         // INT
);

// ====== EXECUTA E RETORNA JSON ======
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
?>
