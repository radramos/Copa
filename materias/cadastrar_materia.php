<?php
require_once "../conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome       = $_POST["nome"];
    $fornecedor = $_POST["fornecedor"];
    $lote       = $_POST["lote"];
    $validade   = $_POST["validade"];
    $qtde       = $_POST["qtde"];

    // "ssssd" -> string, string, string, string, double(decimal)
    $stmt = $conexao->prepare("INSERT INTO materias_primas (nome, fornecedor, lote, validade, qtde) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssd", $nome, $fornecedor, $lote, $validade, $qtde);

    if ($stmt->execute()) {
        $stmt->close();
        $conexao->close();
        // Por enquanto, redireciona para o formulário com sucesso (depois criaremos a lista)
        header("Location: form_cadastra_materia.php?sucesso=1");
        exit;
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }
}
?>