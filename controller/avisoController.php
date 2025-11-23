<?php
require_once __DIR__ . '/../model/Cidadao.php';

// Autoload do Composer
require_once __DIR__ . '/../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['enviar_aviso'])) {

    $regiao = trim($_POST['regiao']); // cidade ou estado filtrado
    $cidadaos = Cidadao::listarTodos();

    // Filtrar por região se fornecida
    if($regiao) {
        $cidadaos = array_filter($cidadaos, function($c) use($regiao){
            return stripos($c['cidade'], $regiao) !== false || stripos($c['estado'], $regiao) !== false;
        });
    }

    if(empty($cidadaos)) {
        echo "Nenhum cidadão encontrado para esta região.";
        exit;
    }

    // Configurações de SMTP
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.seuservidor.com'; // SMTP do seu provedor
        $mail->SMTPAuth   = true;
        $mail->Username   = 'seuemail@dominio.com';
        $mail->Password   = 'sua_senha';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('seuemail@dominio.com', 'AquaSense Alertas');
        $mail->Subject = 'Alerta: Risco de transbordo do rio';
        $mail->Body    = 'Atenção! O rio está com risco de transbordo. Por favor, siga as instruções de segurança da sua região.';

        // Envio em loop
        foreach($cidadaos as $c) {
            $mail->addAddress($c['email'], $c['nome']);
            $mail->send();
            $mail->clearAddresses();
        }

        echo "Avisos enviados com sucesso!";
        header("Location: ../view/adminCidadaos.php");
        exit;

    } catch (Exception $e) {
        echo "Erro ao enviar emails: {$mail->ErrorInfo}";
    }
}
?>
