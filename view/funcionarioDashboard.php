<?php
session_start();

if (!isset($_SESSION['funcionario_id'])) {
    header('Location: loginFuncionario.php');
    exit;
}

$nome = $_SESSION['funcionario_nome'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Favicon -->
  <link rel="icon" type="ico" href="../img/favicon.ico" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Funcionário</title>
<link rel="stylesheet" href="../css/global.css">
</head>
<body>
<div class="dashboard-container">
    <h1>Bem-vindo, <?php echo htmlspecialchars($nome); ?>!</h1>
    <p>Área restrita do funcionário.</p>
    <form action="../controller/logoutFuncionario.php" method="post">
        <input class="botão" type="submit" value="Sair">
    </form>
</div>
</body>
</html>