<?php
require_once "../conexao.php";
if (isset($_GET["codigo"])) {
    $codigo = $_GET["codigo"];
    $stmt = $conexao->prepare("DELETE FROM usuarios WHERE codigo = ?");
    $stmt->bind_param("i", $codigo);
    $stmt->execute();
    $stmt->close();
}
header("Location: index.php");
exit;