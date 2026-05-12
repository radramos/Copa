<?php
require_once "../conexao.php";

$mensagem = "";

// 1. Busca os dados atuais do utilizador para preencher o formulário
if (isset($_GET["codigo"])) {
    $codigo = $_GET["codigo"];
    $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE codigo = ?");
    $stmt->bind_param("i", $codigo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        die("Utilizador não encontrado.");
    }
    $usuario = $resultado->fetch_assoc();
    $stmt->close();
}

// 2. Processa a atualização quando o formulário é enviado (POST)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $codigo        = $_POST["codigo"];
    $nome          = $_POST["nome"];
    $email         = $_POST["email"];
    $senha         = $_POST["senha"];
    $administrador = isset($_POST["administrador"]) ? 1 : 0;

    // Se a senha estiver vazia, não atualizamos o campo senha no banco
    if (empty($senha)) {
        $stmt = $conexao->prepare("UPDATE usuarios SET nome = ?, email = ?, administrador = ? WHERE codigo = ?");
        $stmt->bind_param("ssii", $nome, $email, $administrador, $codigo);
    } else {
        $stmt = $conexao->prepare("UPDATE usuarios SET nome = ?, email = ?, senha = ?, administrador = ? WHERE codigo = ?");
        $stmt->bind_param("sssii", $nome, $email, $senha, $administrador, $codigo);
    }

    if ($stmt->execute()) {
        header("Location: index.php?sucesso=editado");
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
    <title>Editar Utilizador</title>
</head>
<body>
    <h1>Editar Utilizador (Código: <?php echo $usuario['codigo']; ?>)</h1>

    <?php if ($mensagem): ?>
        <p style="color: red;"><b><?php echo $mensagem; ?></b></p>
    <?php endif; ?>

    <form method="POST" action="editar.php">
        <input type="hidden" name="codigo" value="<?php echo $usuario['codigo']; ?>">

        <label>Nome:</label><br>
        <input type="text" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required><br><br>

        <label>Nova Senha (deixe em branco para não alterar):</label><br>
        <input type="password" name="senha"><br><br>

        <label>
            <input type="checkbox" name="administrador" <?php echo $usuario['administrador'] ? 'checked' : ''; ?>> 
            Administrador
        </label><br><br>

        <button type="submit">Salvar Alterações</button>
    </form>

    <br>
    <a href="index.php">Cancelar e Voltar</a>
</body>
</html>