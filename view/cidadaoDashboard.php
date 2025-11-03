<?php
session_start();

if (!isset($_SESSION['cidadao_id'])) {
    header('Location: loginCidadao.php');
    exit;
}

$nome = $_SESSION['cidadao_nome'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Cidadão</title>
<link rel="stylesheet" href="css/global.css">
</head>
<body>
<div class="dashboard-container">
    <h1>Bem-vindo, <?php echo htmlspecialchars($nome); ?>!</h1>
    <p>Área restrita do cidadão.</p>
    <form action="php/logoutCidadao.php" method="post">
        <input class="botão" type="submit" value="Sair">
    </form>
</div>
</body>
</html>