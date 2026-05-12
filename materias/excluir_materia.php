<?php
require_once "../conexao.php";

// Verifica se o ID foi passado via URL
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Prepara a remoção
    $stmt = $conexao->prepare("DELETE FROM materias_primas WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->close();
        $conexao->close();
        // Redireciona de volta para a listagem de matérias
        header("Location: index_materia.php");
        exit;
    } else {
        echo "Erro ao excluir: " . $stmt->error;
    }
} else {
    // Se tentar acessar sem ID, volta para a lista
    header("Location: index_materia.php");
    exit;
}
?>