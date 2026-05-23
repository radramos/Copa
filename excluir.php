<?php
include("conexao.php");

$id = intval($_GET['id']);

mysqli_query($conn, "DELETE FROM partidas WHERE id=$id");

header("Location: index.php");