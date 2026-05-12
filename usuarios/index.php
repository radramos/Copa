<?php
require_once "../conexao.php";

// Busca todos os usuários cadastrados
$resultado = $conexao->query("SELECT * FROM usuarios ORDER BY codigo ASC");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Usuários - Indústria de Cosméticos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .btn-novo { background-color: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; }
        .btn-voltar { background-color: #6c757d; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>

    <h1>Lista de Usuários do Sistema</h1>

    <div style="margin-bottom: 30px;">
        <a href="cadastrar.php" class="btn-novo">Cadastrar Novo Usuário</a>
        <a href="../index.php" class="btn-voltar">Voltar ao Menu Principal</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Administrador</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($u = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $u["codigo"]; ?></td>
                    <td><?php echo htmlspecialchars($u["nome"]); ?></td>
                    <td><?php echo htmlspecialchars($u["email"]); ?></td>
                    <td><?php echo $u["administrador"] ? "Sim" : "Não"; ?></td>
                    <td>
                        <a href="editar.php?codigo=<?php echo $u["codigo"]; ?>">Editar</a> 
                        | 
                        <a href="excluir.php?codigo=<?php echo $u["codigo"]; ?>" 
                           onclick="return confirm('Tem certeza que deseja excluir este usuário?');" 
                           style="color: red;">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>
<?php 
$conexao->close(); 
?>