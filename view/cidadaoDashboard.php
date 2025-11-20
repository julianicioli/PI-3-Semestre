<?php
session_start();

if (!isset($_SESSION['cidadao_id'])) {
    header('Location: loginCidadao.php');
    exit;
}

$nome = $_SESSION['cidadao_nome'];
?>