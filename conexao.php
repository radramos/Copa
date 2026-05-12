<?php
$conn = mysqli_connect("localhost", "root", "", "copa_mundo");

if (!$conn) {
    die("Erro na conexão: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>