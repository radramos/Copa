<?php
$servidor = "localhost";
$usuario  = "root";
$senhaDB  = "";
$banco    = "cosmeticos_db";

$conexao = new mysqli($servidor, $usuario, $senhaDB, $banco);

if ($conexao->connect_error) {
    die("Erro ao conectar no banco de dados: " . $conexao->connect_error);
}

$conexao->set_charset("utf8");
?>