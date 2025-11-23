<h2>Medições do Rio</h2>

<form method="GET">
    <label>Filtrar período:</label>
    <select name="filtro">
        <option value="7dias">Últimos 7 dias</option>
        <option value="1mes">Último mês</option>
        <option value="1ano">Último ano</option>
    </select>
    <button type="submit">Filtrar</button>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Data/Hora</th>
            <th>Nível (mm)</th>
            <th>Vazão (L/s)</th>
            <th>Temperatura (°C)</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($medicoes as $m): ?>
            <tr>
                <td><?= $m['datahora'] ?></td>
                <td><?= $m['nivel'] ?></td>
                <td><?= $m['vazao'] ?></td>
                <td><?= $m['temperatura'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="exportarRelatorio.php?filtro=<?= $filtro ?>" class="btn btn-primary">Gerar Relatório</a>
