
<?php
include_once './config/config.php';
include_once './classes/usuario.php';

session_start();
    $usuario = new Usuario($db);
    $nome_usuario =  $_SESSION['usuario_nome'];
    
    $dados = $usuario->ler();
    function saudacao()
{
    $hora = date('H');
    if ($hora >= 6 && $hora < 12) {
        return "Bom dia";
    } else if ($hora >= 12 && $hora < 18) {
        return "Boa tarde";
    } else {
        return "Boa noite";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Portal</title>
    <style>
        /* Reset básico de margens e padding */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Estilo do corpo da página */
body {
    font-family: Arial, sans-serif;
    background-color: #fce4ec; /* Rosa claro de fundo */
    color: #333;
    padding: 20px;
}

/* Estilo do cabeçalho */
h1 {
    color: #d81b60; /* Rosa escuro para o título */
    font-size: 24px;
    margin-bottom: 20px;
}

/* Estilo dos links */
a {
    color: #ec407a; /* Rosa vibrante para os links */
    text-decoration: none;
    margin-right: 15px;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
    color: #c2185b; /* Rosa mais escuro no hover */
}

/* Estilo da tabela */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px 15px;
    text-align: left;
    border: 1px solid #f1c6d1; /* Rosa suave para as bordas */
}

th {
    background-color: #f48fb1; /* Rosa claro para o fundo do cabeçalho */
    color: white;
}

td img {
    max-width: 100px;
    height: auto;
}

tr:nth-child(even) {
    background-color: #f8bbd0; /* Rosa mais claro nas linhas pares */
}

tr:hover {
    background-color: #f1c6d1; /* Rosa mais suave no hover */
}

/* Estilo das células da tabela com links */
td a {
    color: #ff4081; /* Rosa chamativo para os links nas células */
}

td a:hover {
    color: #c2185b; /* Rosa mais escuro para hover nos links */
}

/* Estilo para o layout geral */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Adiciona um espaçamento adicional entre as tabelas e os links */
table {
    margin-top: 20px;
}

/* Adiciona margens para os links de "Adicionar Usuário" e "Logout" */
a {
    margin-top: 10px;
    display: inline-block;
}

    </style>
</head>
<body>
    <h1><?php echo saudacao() . ", " . $nome_usuario; ?>!</h1>
    <a href="registrar.php">Adicionar Usuário</a>
    <a href="logout.php">Logout</a>
    <a href="portal.php">Voltar</a>
<br>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Sexo</th>
            <th>Fone</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
        <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nome']; ?></td>
                <td><?php echo ($row['sexo'] === 'M') ? 'Masculino' : 'Feminino'; ?></td>
                <td><?php echo $row['fone']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                    <a href="editar.php?id=<?php echo $row['id']; ?>">Editar</a>
                    <a href="deletar.php?id=<?php echo $row['id']; ?>">Deletar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body> </html>
