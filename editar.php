<?php
include("conexao.php");
include("header.php");

$id = intval($_GET['id']);

if ($_POST) {
    $sql = "UPDATE partidas SET
        data = '{$_POST['data']}',
        selecao_1 = '{$_POST['selecao_1']}',
        selecao_2 = '{$_POST['selecao_2']}',
        gols_selecao_1 = {$_POST['gols_1']},
        gols_selecao_2 = {$_POST['gols_2']},
        estadio = '{$_POST['estadio']}',
        fase = '{$_POST['fase']}',
        ano_copa = {$_POST['ano']}
        WHERE id = $id";

    mysqli_query($conn, $sql);

    echo "<p>Atualizado!</p>";
}

$sql = "SELECT * FROM partidas WHERE id = $id";
$row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
?>

<h2>Editar Partida</h2>

<form method="POST">
    Data: <input type="date" name="data" value="<?= $row['data'] ?>">

    Seleção 1: <input type="text" name="selecao_1" value="<?= $row['selecao_1'] ?>">
    Seleção 2: <input type="text" name="selecao_2" value="<?= $row['selecao_2'] ?>">

    Gols 1: <input type="number" name="gols_1" value="<?= $row['gols_selecao_1'] ?>">
    Gols 2: <input type="number" name="gols_2" value="<?= $row['gols_selecao_2'] ?>">

    Estádio: <input type="text" name="estadio" value="<?= $row['estadio'] ?>">

    Fase:
    <select name="fase">
        <option <?= $row['fase']=="Grupos"?"selected":"" ?>>Grupos</option>
        <option <?= $row['fase']=="Oitavas"?"selected":"" ?>>Oitavas</option>
        <option <?= $row['fase']=="Quartas"?"selected":"" ?>>Quartas</option>
        <option <?= $row['fase']=="Semifinal"?"selected":"" ?>>Semifinal</option>
        <option <?= $row['fase']=="Final"?"selected":"" ?>>Final</option>
    </select>

    Ano: <input type="number" name="ano" value="<?= $row['ano_copa'] ?>">

    <button type="submit">Salvar</button>
</form>

<?php include("footer.php"); ?>