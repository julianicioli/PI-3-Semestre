<?php
session_start();
session_unset();
session_destroy();
header('Location: ../view/loginFuncionario.php'); // volta para a raiz
exit;
?>