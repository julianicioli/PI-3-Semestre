<?php
require_once "../conexao.php";

$db = new db();
$link = $db->conecta_mysql();

$res = mysqli_query($link, "SELECT * FROM simulacoes ORDER BY criado_em DESC");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Relatório de Simulações</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="p-4">

<h2 class="mb-4">Relatório de Simulações</h2>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nível</th>
            <th>Temperatura</th>
            <th>Umidade</th>
            <th>Pressão</th>
            <th>Bateria</th>
            <th>Data/Hora</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($res)): ?>
        <tr>
            <td><?= $row["id"] ?></td>
            <td><?= $row["nivel"] ?> mm</td>
            <td><?= $row["temperatura"] ?> °C</td>
            <td><?= $row["umidade"] ?>%</td>
            <td><?= $row["pressao"] ?> hPa</td>
            <td><?= $row["bateria"] ?> mV</td>
            <td><?= $row["criado_em"] ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
