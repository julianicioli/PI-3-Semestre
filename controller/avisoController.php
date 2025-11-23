<?php
// avisoController.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../model/Cidadao.php';
require_once __DIR__ . '/../vendor/autoload.php'; // PHPMailer

/**
 * Função para envio automático de aviso por e-mail
 * @param array $emails Lista de e-mails destinatários
 * @param string $mensagem Mensagem do alerta
 * @return void
 */
function enviarAvisoAutomatico(array $emails, string $mensagem): void {
    if (empty($emails) || empty($mensagem)) return;

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'alerta.aquasense@gmail.com'; // seu e-mail
        $mail->Password   = 'gmgo hnfr xgbh xwat';       // senha de app do Gmail
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('alerta.aquasense@gmail.com', 'AquaSense Alertas');
        $mail->Subject = 'Alerta do Sistema AquaSense';
        $mail->Body    = $mensagem;
        $mail->isHTML(false);

        foreach ($emails as $email) {
            $mail->addAddress($email);
        }

        $mail->send();
    } catch (Exception $e) {
        error_log("Erro ao enviar aviso automático: {$mail->ErrorInfo}");
    }
}

// Envio manual via formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar_aviso'])) {

    $mensagem = $_POST['mensagem'] ?? '';
    $emailsSelecionados = $_POST['emails'] ?? [];

    if (empty($mensagem) || empty($emailsSelecionados)) {
        die("Erro: Mensagem ou destinatários não selecionados.");
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'alerta.aquasense@gmail.com'; // seu e-mail
        $mail->Password   = 'gmgo hnfr xgbh xwat';       // senha de app do Gmail
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('alerta.aquasense@gmail.com', 'AquaSense Alertas');
        $mail->Subject = 'Alerta do Sistema AquaSense';
        $mail->Body    = $mensagem;
        $mail->isHTML(false);

        foreach ($emailsSelecionados as $email) {
            $mail->addAddress($email);
        }

        $mail->send();
        $msgSucesso = "Aviso enviado com sucesso!";
    } catch (Exception $e) {
        $msgErro = "Erro ao enviar o aviso: {$mail->ErrorInfo}";
    }
}
