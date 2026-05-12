<?php
require_once "../conexao.php";

$mensagem = "";

// 1. Busca os dados atuais do produto para preencher o formulário
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $stmt = $conexao->prepare("SELECT * FROM materias_primas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        echo "Matéria-prima não encontrada.";
        exit;
    }
    $materia = $resultado->fetch_assoc();
    $stmt->close();
}

// 2. Processa a atualização quando o formulário é enviado (POST)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id         = $_POST["id"];
    $nome       = $_POST["nome"];
    $fornecedor = $_POST["fornecedor"];
    $lote       = $_POST["lote"];
    $validade   = $_POST["validade"];
    $qtde       = $_POST["qtde"];

    $stmt = $conexao->prepare("UPDATE materias_primas SET nome = ?, fornecedor = ?, lote = ?, validade = ?, qtde = ? WHERE id = ?");
    $stmt->bind_param("ssssdi", $nome, $fornecedor, $lote, $validade, $qtde, $id);

    if ($stmt->execute()) {
        header("Location: index_materia.php?sucesso=editado");
        exit;
    } else {
        $mensagem = "Erro ao atualizar: " . $stmt->error;
    }
    $stmt->close();
}
$conexao->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Matéria-Prima</title>
</head>
<body>
    <h1>Editar Matéria-Prima (ID: <?php echo $materia["id"]; ?>)</h1>

    <?php if ($mensagem): ?>
        <p style="color: red;"><b><?php echo $mensagem; ?></b></p>
    <?php endif; ?>

    <form method="POST" action="editar_materia.php">
        <input type="hidden" name="id" value="<?php echo $materia["id"]; ?>">

        <label>Nome:</label><br>
        <input type="text" name="nome" value="<?php echo htmlspecialchars($materia["nome"]); ?>" required><br><br>

        <label>Fornecedor:</label><br>
        <input type="text" name="fornecedor" value="<?php echo htmlspecialchars($materia["fornecedor"]); ?>" required><br><br>

        <label>Lote:</label><br>
        <input type="text" name="lote" value="<?php echo htmlspecialchars($materia["lote"]); ?>" required><br><br>

        <label>Validade:</label><br>
        <input type="date" name="validade" value="<?php echo $materia["validade"]; ?>" required><br><br>

        <label>Quantidade:</label><br>
        <input type="number" step="0.001" name="qtde" value="<?php echo $materia["qtde"]; ?>" required><br><br>

        <button type="submit">Salvar Alterações</button>
    </form>

    <br>
    <a href="index_materia.php">Cancelar e Voltar</a>
</body>
</html>