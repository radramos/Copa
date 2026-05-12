<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Matéria-Prima</title>
</head>
<body>
    <h1>Indústria de Cosméticos - Cadastro de Matéria-Prima</h1>
    
    <form method="POST" action="cadastrar_materia.php">
        <label>Nome da Matéria-Prima:</label><br>
        <input type="text" name="nome" required><br><br>

        <label>Fornecedor:</label><br>
        <input type="text" name="fornecedor" required><br><br>

        <label>Lote:</label><br>
        <input type="text" name="lote" required><br><br>

        <label>Data de Validade:</label><br>
        <input type="date" name="validade" required><br><br>

        <label>Quantidade (em kg/un):</label><br>
        <input type="number" step="0.001" name="qtde" required><br><br>
        <!-- step="0.001": Como se trata de uma indústria de cosméticos, a precisão é fundamental. Esse atributo permite que o utilizador insira gramas (ex: 0,505 kg) no formulário. -->
        <button type="submit">Gravar Matéria-Prima</button>
    </form>

    <br>
    <a href="../index.php">Voltar ao Menu Principal</a>
</body>
</html>