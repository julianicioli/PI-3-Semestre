<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../model/conexao.php'); // permanece intacto

$numero_registro = trim($_POST['numero_registro'] ?? '');
$senha = $_POST['senha'] ?? '';

$msg = '';
$msg_class = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($numero_registro === '' || $senha === '') {
        $msg = 'Número de registro e senha são obrigatórios.';
        $msg_class = 'erro';
    } else {
        try {
            $bancodedados = new db();
            $link = $bancodedados->conecta_mysql();

            $sql = "SELECT id, nome, senha FROM cadastrofuncionario WHERE numero_registro = ?";
            $stmt = $link->prepare($sql);
            $stmt->bind_param('s', $numero_registro);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                $msg = 'Número de registro ou senha incorretos.';
                $msg_class = 'erro';
            } else {
                $funcionario = $result->fetch_assoc();
                // Alternativa temporária: senha em texto simples
                if ($senha === $funcionario['senha']) {
                    $_SESSION['funcionario_id'] = $funcionario['id'];
                    $_SESSION['funcionario_nome'] = $funcionario['nome'];
                    // sinaliza sucesso para mostrar modal e redirecionar em client-side
                    $loginSuccess = true;
                    $redirectAfter = 'adminDashboard.php';
                } else {
                    $msg = 'Número de registro ou senha incorretos.';
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

    <!-- Favicon -->
    <link rel="icon" type="ico" href="../img/favicon.ico" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="ico" href="../img/favicon.ico" />
    <title>Login Administrador</title>
    <link rel="stylesheet" href="../css/global.css">
    <style>
    .modal { display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.45); backdrop-filter: blur(5px); justify-content: center; align-items: center; z-index: 1000; animation: fadeIn 0.3s ease; }
    .modal.visible { display: flex; }
    .modal-box { background: #fff; width: 320px; padding: 30px 25px; border-radius: 18px; text-align: center; font-family: Arial, sans-serif; box-shadow: 0 8px 30px rgba(0,0,0,0.15); animation: pop 0.25s ease-out; }
    .icon { width: 70px; height: 70px; border-radius: 50%; border: 3px solid #2ecc71; display: flex; justify-content: center; align-items: center; margin: 0 auto 15px auto; }
    .checkmark { width: 28px; height: 14px; border-left: 3px solid #2ecc71; border-bottom: 3px solid #2ecc71; transform: rotate(-45deg); animation: draw 0.4s ease-out; }
    .modal-box h2 { margin-top: 5px; color: #2ecc71; font-size: 22px; }
    .modal-box p { color: #555; margin: 10px 0 20px; }
    .modal-box button { background: #2ecc71; color: #fff; border: none; padding: 10px 25px; border-radius: 10px; cursor: pointer; font-size: 15px; transition: 0.2s; }
    .modal-box button:hover { background: #27ae60; }
    @keyframes pop { from { transform: scale(0.8); opacity: 0; } to   { transform: scale(1); opacity: 1; } }
    @keyframes fadeIn { from { opacity: 0; } to   { opacity: 1; } }
    @keyframes draw { from { width: 0; height: 0; } to   { width: 28px; height: 14px; } }
    </style>
</head>

<body>
    <div>
        <img class="logo" src="../img/logo.png" alt="Logo da empresa">
        <h2 class="frase">Informação rápida, cidade segura</h2>
    </div>
    <div>
        <form class="formfuncionario" action="" method="post">
            <h1 class="title">Login Funcionário</h1>

            <?php if (!empty($msg)): ?>
                <div class="mensagem <?php echo $msg_class; ?>">
                    <?php echo $msg; ?>
                </div>
            <?php endif; ?>

            <label class="dados" for="numero_registro">Número de Registro:</label>
            <input type="text" name="numero_registro" id="numero_registro"
                placeholder="Digite seu número de registro..." required
                value="<?php echo htmlspecialchars($numero_registro); ?>">

            <label class="dados" for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" placeholder="Digite sua senha..." required>

            <input class="botão" type="submit" value="Entrar" href="adminDashboard.php">
        </form>
    </div>
    <div id="modal-login" class="modal">
        <div class="modal-box">
            <div class="icon">
                <span class="checkmark"></span>
            </div>
            <h2>Bem-vindo(a)!</h2>
            <p>Login realizado com sucesso.</p>
            <button onclick="fecharModalLogin()">Continuar</button>
        </div>
    </div>
    <footer>
    <script>
    function abrirModalLogin(){
        const m = document.getElementById('modal-login');
        if (!m) return;
        m.classList.add('visible');
        m.setAttribute('aria-hidden','false');
    }

    function fecharModalLogin(){
        const m = document.getElementById('modal-login');
        if (!m) return;
        m.classList.remove('visible');
        m.setAttribute('aria-hidden','true');
    }

    <?php if (!empty($loginSuccess)): ?>
    window.addEventListener('DOMContentLoaded', function(){
        try{
            abrirModalLogin();
            setTimeout(function(){ window.location.href = '<?php echo $redirectAfter; ?>'; }, 2000);
        }catch(e){ console.error(e); }
    });
    <?php endif; ?>
    </script>
        <p class="rodape"><b>Desenvolvido por Aquasense &copy; 2025</b></p>
    </footer>
</body>

</html>