<?php
include("conexao.php");
include("header.php");

$where = [];

if (!empty($_GET['ano'])) {
    $ano = intval($_GET['ano']);
    $where[] = "ano_copa = $ano";
}

if (!empty($_GET['selecao'])) {
    $sel = mysqli_real_escape_string($conn, $_GET['selecao']);
    $where[] = "(selecao_1 LIKE '%$sel%' OR selecao_2 LIKE '%$sel%')";
}

if (!empty($_GET['fase'])) {
    $fase = mysqli_real_escape_string($conn, $_GET['fase']);
    $where[] = "fase LIKE '%$fase%'";
}

$whereSQL = "";
if (count($where) > 0) {
    $whereSQL = "WHERE " . implode(" AND ", $where);
}

$sql = "SELECT * FROM partidas $whereSQL ORDER BY ano_copa DESC, data DESC";
$result = mysqli_query($conn, $sql);
?>

<h2>Listar Partidas</h2>

<form method="GET">
    Buscar por ano:
    <input type="number" name="ano">

    Buscar por seleção:
    <input type="text" name="selecao" placeholder="Ex: Brazil">

    Buscar por fase:
    <select name="fase">
        <option value="">Todas</option>
        <option>Final</option>
        <option>Semifinal</option>
        <option>Quartas</option>
        <option>Oitavas</option>
        <option>Group</option>
    </select>

    <button type="submit">Buscar</button>
</form>

<br>

<table border="1" cellpadding="10">
<tr>
    <th>Data</th>
    <th>Jogo</th>
    <th>Fase</th>
    <th>Ano</th>
    <th>Estádio</th>
    <th>Ações</th>
</tr>

<?php
while ($row = mysqli_fetch_assoc($result)) {

    $v1 = $row['gols_selecao_1'] > $row['gols_selecao_2'] ? "style='color:green;font-weight:bold'" : "";
    $v2 = $row['gols_selecao_2'] > $row['gols_selecao_1'] ? "style='color:green;font-weight:bold'" : "";

    echo "<tr>";
    echo "<td>{$row['data']}</td>";

    echo "<td>
        <span $v1>{$row['selecao_1']} {$row['gols_selecao_1']}</span> x 
        <span $v2>{$row['gols_selecao_2']} {$row['selecao_2']}</span>
    </td>";

    echo "<td>{$row['fase']}</td>";
    echo "<td>{$row['ano_copa']}</td>";
    echo "<td>{$row['estadio']}</td>";

    echo "<td>
        <a href='editar.php?id={$row['id']}'>Editar</a> |
        <a href='excluir.php?id={$row['id']}' onclick='return confirm(\"Tem certeza?\")'>Excluir</a>
    </td>";

    echo "</tr>";
}
?>

</table>

<?php include("footer.php"); ?>