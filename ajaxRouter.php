<?php
include("conexao.php");
if (!isset($_POST['func'])) {
    echo "Função não especificada.";
    exit;
}

session_start();
$func = $_POST['func'];
$_SESSION['func'] = $func;
$funcoesPermitidas = ['add', 'edit'];
if (!in_array($func, $funcoesPermitidas)) {
    exit('Função inválida');
}
switch ($func) {
    case 'add':
?>
<form method="POST" class="form">
    <h2>Cadastrar partida</h2>
    <section class="info">
        <h3>Informações Gerais</h3>
        <label for="data">Data do jogo</label>
        <input type="date" name="data" class="medium" required>
        <br>
        <label for="ano">Ano do jogo</label>
        <input type="number" name="ano" required>
         <br>
         <label for="estadio">Estádio</label>
         <input type="text" name="estadio" required>
         <br>
        <label for="fase">Fase</label>
        <select name="fase" class="medium" required>
            <option>Grupo H</option>
            <option>Grupo G</option>
            <option>Grupo F</option>
            <option>Grupo E</option>
            <option>Grupo D</option>
            <option>Grupo C</option>
            <option>Grupo B</option>
            <option>Grupo A</option>
            <option>Oitavas</option>
            <option>Quartas</option>
            <option>Semifinal</option>
            <option>Final</option>
        </select>
    </section>
    <section class="placar">
        <h3>Placar</h3>
        <div>
            <input type="text" name="selecao_1" placeholder="1° Seleção" class="medium" required>
            <label for="gols_1">Gols</label>
            <input type="number" name="gols_1" class="small" max="10" min="0">
        </div>
        <span>VS</span>
        <div>
            <input type="text" name="selecao_2" placeholder="2° Seleção" class="medium" required>
            <label for="gols_2">Gols</label>
            <input type="number" name="gols_2" class="small" max="10" min="0">
        </div>
    </section>
    <button type="submit">Cadastrar</button>
    <button type='button' onclick='closeFocusForm()' class='closeFormBtn'> X </button>
</form>
<?php
    exit;
    case 'edit':
        if (!isset($_POST['id'])) {
            echo "ID não informado.";
            break;
        }
        $_SESSION['id'] = intval($_POST['id']);
        $id = intval($_POST['id']);
        $sql = "SELECT * FROM partidas WHERE id = $id";
        $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
?>
<form method="POST" class="form">
    <h2>Editar partida</h2>
    <section class="info">
        <h3>Informações Gerais</h3>
        <label for="data">Data do jogo</label>
        <input type="date" name="data" class="medium" required value="<?= htmlspecialchars($row['data']) ?>">
        <br>
        <label for="ano">Ano do jogo</label>
        <input type="number" name="ano" required value="<?= htmlspecialchars($row['ano_copa']) ?>">
         <br>
         <label for="estadio">Estádio</label>
         <input type="text" name="estadio" required value="<?= htmlspecialchars($row['estadio']) ?>">
         <br>
        <label for="fase">Fase</label>
        <select name="fase" class="medium">
            <option <?= $row['fase']=="Grupo H"?"selected":"" ?>>Grupo H</option>
            <option <?= $row['fase']=="Grupo G"?"selected":"" ?>>Grupo G</option>
            <option <?= $row['fase']=="Grupo F"?"selected":"" ?>>Grupo F</option>
            <option <?= $row['fase']=="Grupo E"?"selected":"" ?>>Grupo E</option>
            <option <?= $row['fase']=="Grupo D"?"selected":"" ?>>Grupo D</option>
            <option <?= $row['fase']=="Grupo C"?"selected":"" ?>>Grupo C</option>
            <option <?= $row['fase']=="Grupo B"?"selected":"" ?>>Grupo B</option>
            <option <?= $row['fase']=="Grupo A"?"selected":"" ?>>Grupo A</option>
            <option <?= $row['fase']=="Oitavas"?"selected":"" ?>>Oitavas</option>
            <option <?= $row['fase']=="Quartas"?"selected":"" ?>>Quartas</option>
            <option <?= $row['fase']=="Semifinal"?"selected":"" ?>>Semifinal</option>
            <option <?= $row['fase']=="Final"?"selected":"" ?>>Final</option>
        </select>
    </section>
    <section class="placar">
        <h3>Placar</h3>
        <div>
            <input type="text" name="selecao_1" placeholder="1° Seleção" class="medium" required value="<?= htmlspecialchars($row['selecao_1']) ?>">
            <label for="gols_1">Gols</label>
            <input type="number" name="gols_1" class="small" max="10" min="0" value="<?= htmlspecialchars($row['gols_selecao_1']) ?>">
        </div>
        <span>VS</span>
        <div>
            <input type="text" name="selecao_2" placeholder="2° Seleção" class="medium" required value="<?= htmlspecialchars($row['selecao_2']) ?>">
            <label for="gols_2">Gols</label>
            <input type="number" name="gols_2" class="small" max="10" min="0" value="<?= htmlspecialchars($row['gols_selecao_2']) ?>">
        </div>
    </section>
    <button type="submit">Salvar</button>
    <button type='button' onclick='closeFocusForm()' class='closeFormBtn'> X </button>
</form>
<?php
        exit;
    default:
        echo "Função não reconhecida->";
        echo $func;
        break;
}
?>