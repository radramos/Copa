<?php
require_once "../conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"]; // Em um sistema real, usaríamos password_hash
    $administrador = isset($_POST["administrador"]) ? 1 : 0;

    $stmt = $conexao->prepare("INSERT INTO usuarios (nome, email, senha, administrador) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $nome, $email, $senha, $administrador);
    
    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Cadastrar Usuário</title></head>
<body>
    <h1>Cadastrar Novo Usuário</h1>
    <form method="POST">
        <label>Nome:</label><br><input type="text" name="nome" required><br><br>
        <label>Email:</label><br><input type="email" name="email" required><br><br>
        <label>Senha:</label><br><input type="password" name="senha" required><br><br>
        <label><input type="checkbox" name="administrador"> Administrador</label><br><br>
        <button type="submit">Cadastrar</button>
    </form>
    <br><a href="index.php">Voltar para a lista</a>
</body>
</html>