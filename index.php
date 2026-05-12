<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Gestão - Indústria de Cosméticos</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; }
        .container { display: flex; justify-content: center; gap: 20px; margin-top: 30px; }
        .card { 
            border: 2px solid #333; 
            padding: 20px; 
            width: 250px; 
            border-radius: 10px; 
            text-decoration: none; 
            color: #333; 
            background-color: #f4f4f4;
            transition: 0.3s;
        }
        .card:hover { background-color: #ddd; transform: scale(1.05); }
    </style>
</head>
<body>

    <h1>Controle de Produção e Estoque</h1>
    <p>Bem-vindo ao sistema de gerenciamento da Indústria de Cosméticos.</p>

    <div class="container">
        <a href="materias/index_materia.php" class="card">
            <h2>Matérias-Primas</h2>
            <p>Gerenciar estoque, lotes e validade de insumos.</p>
        </a>

        <a href="usuarios/index.php" class="card">
            <h2>Usuários</h2>
            <p>Controle de acesso e administradores.</p>
        </a>
    </div>

</body>
</html>