<?php
require_once "../conexao.php";

// Busca os dados da classe principal: matéria-prima
$resultado = $conexao->query("SELECT * FROM materias_primas ORDER BY nome ASC");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Estoque de Matéria-Prima</title>
</head>
<body>
    <h1>Estoque de Matéria-Prima - Indústria de Cosméticos</h1>

    <div style="margin-bottom: 20px;">
        <a href="form_cadastra_materia.php">Cadastrar Nova Matéria</a> | 
        <a href="../index.php">Voltar ao Menu Principal</a>
    </div>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Fornecedor</th>
                <th>Lote</th>
                <th>Validade</th>
                <th>Quantidade (kg/un)</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($materia = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $materia["id"]; ?></td>
                    <td><?php echo htmlspecialchars($materia["nome"]); ?></td>
                    <td><?php echo htmlspecialchars($materia["fornecedor"]); ?></td>
                    <td><?php echo htmlspecialchars($materia["lote"]); ?></td>
                    <td><?php echo date("d/m/Y", strtotime($materia["validade"])); ?></td>
                    <td><?php echo number_format($materia["qtde"], 3, ',', '.'); ?></td>
                    <td>
                        <a href="editar_materia.php?id=<?php echo $materia["id"]; ?>">Editar</a> | 
                        <a href="excluir_materia.php?id=<?php echo $materia["id"]; ?>" 
                           onclick="return confirm('Deseja excluir esta matéria-prima?');">Excluir</a>
                    </td>
                </tr>
            <?php?>
        </tbody>
    </table>
</body>
</html>
<?php $conexao->close(); ?>