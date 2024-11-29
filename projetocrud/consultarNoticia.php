<?php
session_start();
include_once './config/config.php';
include_once './classes/Noticia.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $noticia = new Noticia($db);
    $noticia->deletar($id);
    header('Location: consultarNoticia.php');
    exit();
}

$usuario = new Noticia($db);

if (isset($_GET['deletar'])) {
    $id = $_GET['deletar'];
    $usuario->deletar($id);
    header('Location:consultarNoticia.php');
    exit();
}

// Obter dados do usuário logado
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$nome_usuario =  $_SESSION['usuario_nome'];

// Obter dados das notícias, com busca se houver
$busca = "";
if (isset($_GET['buscar'])) {
    $busca = $_GET['buscar'];
    $dados = $usuario->buscarPorTitulo($busca); 
} else {
    $dados = $usuario->ler();
}

function saudacao() {
    $hora = date('H');
    if ($hora >= 6 && $hora < 12) {
        return "Bom dia";
    } elseif ($hora >= 12 && $hora < 18) {
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
    background-color: #fce4ec; /* Rosa claro como fundo */
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
    color: #e91e63; /* Rosa vibrante para os links */
    text-decoration: none;
    margin-right: 15px;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
    color: #c2185b; /* Rosa mais escuro para hover */
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
    border: 1px solid #f1c6d1; /* Rosa bem suave para as bordas */
}

th {
    background-color: #f48fb1; /* Rosa claro para o fundo da cabeçalho */
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
    color: #ff4081; /* Rosa chamativo para links nas células */
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
    
    <!-- Formulário de busca -->
    <form method="GET" action="consultarNoticia.php">
        <input type="int" name="buscar" value="<?php echo $busca; ?>" placeholder="Buscar notícia" />
        <button type="submit">Buscar</button>
    </form>
    
    <a href="cadastrarNoticia.php">Adicionar Notícia</a>
    <a href="logout.php">Logout</a>
    <a href="portal.php">Voltar</a>
    <br>
    
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Data</th>
            <th>Autor</th>
            <th>Notícia</th>
            <th>Imagem</th>
            <th>Ações</th>
        </tr>
        <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['titulo']; ?></td>
                <td><?php echo $row['data']; ?></td>
                <td><?php echo $row['autor']; ?></td>
                <td><?php echo $row['noticia']; ?></td>
                <td>
                    <!-- Exibir a imagem utilizando a tag <img> -->
                    <img src="<?php echo $row['imagem']; ?>" alt="Imagem da notícia" width="100">
                </td>
                <td>
                    <!-- Links de edição e exclusão -->
                    <a href="editarNoticia.php?id=<?php echo $row['id']; ?>">Editar</a>
                    <a href="consultarNoticia.php?deletar=<?php echo $row['id']; ?>">Deletar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
