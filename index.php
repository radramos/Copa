<?php
include("conexao.php");
session_start();
if(isset($_SESSION['func']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    switch($_SESSION['func']){
        case "add":
             $sql = "INSERT INTO partidas 
            (data, selecao_1, selecao_2, gols_selecao_1, gols_selecao_2, estadio, fase, ano_copa)
            VALUES (
                '{$_POST['data']}',
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
            break;
        case "edit":
            $id = intval($_SESSION['id']);
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
            echo "<p>Partida atualizada!</p>";
        break;
        default:
        echo "<p>func nao identificado</p>";
    }
}
$_SESSION['func'] = null;

// -
$where = [];

if (!empty($_GET['ano'])) {
    $ano = intval($_GET['ano']);
    $where[] = "ano_copa = $ano";
}

$sel1 = !empty($_GET['selecao1']) ? mysqli_real_escape_string($conn, $_GET['selecao1']) : "";
$sel2 = !empty($_GET['selecao2']) ? mysqli_real_escape_string($conn, $_GET['selecao2']) : "";

if (!empty($sel1) && !empty($sel2)) {

    $where[] = "(
        (selecao_1 LIKE '%$sel1%' AND selecao_2 LIKE '%$sel2%')
        OR
        (selecao_1 LIKE '%$sel2%' AND selecao_2 LIKE '%$sel1%')
    )";

} elseif (!empty($sel1)) {

    $where[] = "(
        selecao_1 LIKE '%$sel1%' 
        OR 
        selecao_2 LIKE '%$sel1%'
    )";

} elseif (!empty($sel2)) {

    $where[] = "(
        selecao_1 LIKE '%$sel2%' 
        OR 
        selecao_2 LIKE '%$sel2%'
    )";
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


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Sistema Copa do Mundo</title>
</head>
<body>
    <header>
        <h1>⚽ Sistema Copa do Mundo</h1>
        <h2>Bem-vindo ao sistema</h2>
        <p>Gerencie partidas da Copa do Mundo.</p>
        <hr>
    </header>
    <main>
        <button onclick='openAddPartida()'>Cadastrar nova partida</button>
        <form method="GET">
            Buscar por ano:
            <input type="number" name="ano">

            Buscar por seleção:
            <input type="text" name="selecao1" placeholder="Ex: Brazil">

            <input type="text" name="selecao2" placeholder="Ex: Spain">

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
        <dialog action="POST" id="formulario"></dialog>
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
    $data = date("d/m/Y", strtotime($row['data']));

    $v1 = $row['gols_selecao_1'] == $row['gols_selecao_2'] ? "style='color:grey;font-weight:bold'" :
         ($row['gols_selecao_1'] > $row['gols_selecao_2'] ? "style='color:green;font-weight:bold'" : 
            "style='color:red;font-weight:bold'");
    $v2 = $row['gols_selecao_1'] == $row['gols_selecao_2'] ? "style='color:grey;font-weight:bold'" : ($row['gols_selecao_2'] > $row['gols_selecao_1'] ? "style='color:green;font-weight:bold'" : "style='color:red;font-weight:bold'");
    echo "<tr>";
    echo "<td>{$data}</td>";

    echo "<td>
        <span $v1>{$row['selecao_1']} {$row['gols_selecao_1']}</span> x 
        <span $v2>{$row['gols_selecao_2']} {$row['selecao_2']}</span>
    </td>";

    echo "<td>{$row['fase']}</td>";
    echo "<td>{$row['ano_copa']}</td>";
    echo "<td>{$row['estadio']}</td>";

    // echo "<td>
    //     <a href='editar.php?id={$row['id']}'>Editar</a> |
    //     <a href='excluir.php?id={$row['id']}' onclick='return confirm(\"Tem certeza?\")'>Excluir</a>
    // </td>";
    echo"<td>
<button onclick='openEditPartida({$row['id']})'>Editar</button> | 
<a href='excluir.php?id={$row['id']}' onclick='return confirm(\"Tem certeza?\")'>Excluir</a>
</td>
    ";

    echo "</tr>";
}
?>

        </table>
    </main>
    <footer>
        <hr>
        <p>Projeto PHP - Copa do Mundo - Engenharia de Software 1° ADS 2026</p>
        <p>Karen Mayumi | Maryellen Custódio | Raphael Anderson</p>
    </footer>
    <script type="module">
        import * as moduloPartidas from './ajax.js';
        Object.assign(window,moduloPartidas);
    </script>
</body>
</html>