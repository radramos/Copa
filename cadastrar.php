<?php
include("conexao.php");
include("header.php");

if ($_POST) {

    $sql = "INSERT INTO partidas 
    (data, selecao_1, selecao_2, gols_selecao_1, gols_selecao_2, estadio, fase, ano_copa)
    VALUES (
        '{$_POST['data_partida']}',
        '{$_POST['selecao_1']}',
        '{$_POST['selecao_2']}',
        {$_POST['gols_1']},
        {$_POST['gols_2']},
        '{$_POST['estadio']}',
        '{$_POST['fase']}',
        {$_POST['ano']}
    )";

    mysqli_query($conn, $sql);

    echo "<p>Partida cadastrada!</p>";
}
?>

<h2>Cadastrar Partida</h2>

<form method="POST">
    Data: <input type="date" name="data" required>

    Seleção 1: <input type="text" name="selecao_1" required>
    Seleção 2: <input type="text" name="selecao_2" required>

    Gols 1: <input type="text" name="gols_1" required>
    Gols 2: <input type="text" name="gols_2" required>

    Estádio: <input type="text" name="estadio">

    Fase:
    <select name="fase">
        <option>Grupos</option>
        <option>Oitavas</option>
        <option>Quartas</option>
        <option>Semifinal</option>
        <option>Final</option>
    </select>

    Ano: <input type="number" name="ano" required>

    <button type="submit">Cadastrar</button>
</form>

<?php include("footer.php"); ?>