<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../model/conexao.php');

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

$msg = '';
$msg_class = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($email === '' || $senha === '') {
        $msg = 'E-mail e senha são obrigatórios.';
        $msg_class = 'erro';
    } else {
        try {
            $bancodedados = new db();
            $link = $bancodedados->conecta_mysql();

            $sql = "SELECT id, nome, senha FROM cadastrocidadao WHERE email = ?";
            $stmt = $link->prepare($sql);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                $msg = 'E-mail ou senha incorretos.';
                $msg_class = 'erro';
            } else {
                $cidadao = $result->fetch_assoc();
                // Comparação simples (texto puro). Depois pode usar password_hash/password_verify
                if ($senha === $cidadao['senha']) {
                    $_SESSION['cidadao_id'] = $cidadao['id'];
                    $_SESSION['cidadao_nome'] = $cidadao['nome'];
                    header("Location: cidadaoDashboard.php");
                    exit;
                } else {
                    $msg = 'E-mail ou senha incorretos.';
                    $msg_class = 'erro';
                }
            }

            $stmt->close();
            $link->close();
        } catch (Exception $e) {
            $msg = 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
            $msg_class = 'erro';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="ico" href="../img/favicon.ico" />
<title>Login Cidadão</title>
<link rel="stylesheet" href="../css/global.css">
<style>
.mensagem { margin-bottom: 15px; padding: 10px; border-radius: 5px; text-align: center; }
.mensagem.erro { background-color: #f8d7da; color: #721c24; }
.mensagem.sucesso { background-color: #d4edda; color: #155724; }
</style>
</head>
<body>
<div>
    <img class="logo" src="../img/logo.png" alt="Logo da empresa">
    <h2 class="frase">Informação rápida, cidade segura</h2>
</div>
<div>
<form class="formfuncionario" action="" method="post">
    <h1 class="title">Login Cidadão</h1>

    <?php if (!empty($msg)): ?>
        <div class="mensagem <?php echo $msg_class; ?>">
            <?php echo $msg; ?>
        </div>
    <?php endif; ?>

    <label class="dados" for="email">E-mail:</label>
    <input type="email" name="email" id="email" placeholder="Digite seu e-mail..." required value="<?php echo htmlspecialchars($email); ?>">

    <label class="dados" for="senha">Senha:</label>
    <input type="password" name="senha" id="senha" placeholder="Digite sua senha..." required>

    <input class="botão" type="submit" value="Entrar">
</form>
</div>
<footer>
<p class="rodape"><b>Desenvolvido por Aquasense &copy; 2025</b></p>
</footer>
</body>
</html>
