<?php
include_once './config/config.php';
include_once './classes/Noticia.php';
include_once './classes/usuario.php';



try {
    $usuario = new Usuario($db);
    // Lista todos os usuários para exibição no select
    $usuarios = $usuario->ler();
} catch (Exception $e) {
    die("Erro: " . $e->getMessage());
}

$database = new Database();
$db = $database->getConnection();
$noticia = new Noticia($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'] ?? '';
    $data = $_POST['data'] ?? '';
    $autor = $_POST['autor'] ?? '';
    $noticiaTexto = $_POST['noticia'] ?? '';
    $imagem = '';

    if (!empty($_FILES['imagem']['name'])) {
        $target_dir = "img/";
        $imagem = $target_dir . basename($_FILES["imagem"]["name"]);
        if (!move_uploaded_file($_FILES["imagem"]["tmp_name"], $imagem)) {
            echo "Erro ao fazer upload da imagem.";
            exit();
        }
    }

    if ($noticia->cadastrar($titulo, $data, $autor, $noticiaTexto, $imagem)) {
        echo "<script>alert('Notícia cadastrada com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar notícia.');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Notícia</title>
    <style>
        /* Reset básico de margens e padding */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Estilo do corpo da página */
body {
    font-family: 'Arial', sans-serif;
    height: 100vh; 
    margin: 0;
    color: #333;
    padding: 20px;
    background-color: #fce4ec; /* Rosa claro de fundo */
}

/* Estilo do título */
h1 {
    text-align: center;
    color: #d81b60; /* Rosa escuro para o título */
    margin-bottom: 30px;
}

/* Estilo do formulário */
form {
    background-color: #ffffff;
    padding: 30px;
    max-width: 700px;
    margin: 0 auto;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Estilo dos labels */
label {
    display: block;
    font-size: 25px;
    color: #d81b60; /* Rosa escuro para os labels */
    font-weight: bold;
    margin-bottom: 10px;
}

/* Estilo dos inputs e textarea */
input[type="text"],
input[type="date"],
textarea,
input[type="file"] {
    width: 100%;
    padding: 12px;
    text-align: center;
    margin-bottom: 20px;
    border: 1px solid #f8bbd0; /* Rosa suave para bordas */
    background-color: #f1c6d1; /* Rosa claro como fundo */
    border-radius: 8px;
    font-size: 20px;
    color: #d81b60; /* Rosa escuro para texto */
    transition: border-color 0.3s ease;
}

/* Estilo para o foco nos campos */
input[type="text"]:focus,
input[type="date"]:focus,
textarea:focus,
input[type="file"]:focus {
    border-color: #f50057; /* Rosa vibrante no foco */
    outline: none;
}

/* Estilo do textarea */
textarea {
    resize: vertical;
    min-height: 150px;
}

/* Estilo do botão de submit */
button[type="submit"] {
    background-color: #d81b60; /* Rosa escuro para o botão */
    color: white;
    font-size: 16px;
    padding: 15px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s ease;
}

/* Efeito de hover no botão */
button[type="submit"]:hover {
    background-color: #c2185b; /* Rosa mais escuro no hover */
}

/* Estilo do script */
script {
    margin-top: 10px;
    text-align: center;
    font-size: 14px;
}

/* Responsividade para dispositivos móveis */
@media (max-width: 750px) {
    form {
        padding: 20px;
        margin: 10px;
    }
}
/* Adiciona margens para os links de "Adicionar Usuário" e "Logout" */
a {
    margin-top: 10px;
    display: inline-block;
}

    </style>
</head>

<body>
    <form action="cadastrarNoticia.php" method="POST" enctype="multipart/form-data">
        <h1>Cadastrar Nova Notícia</h1> 
        <a href="portal.php">Voltar</a>
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" placeholder="Digite o Titulo" required>

        <label for="data">Data:</label>
        <input type="date" id="data" name="data" required>

        <label for="autor">Autor</label>
            <select name="autor" id="autor" required>
                <option value="">Selecione o autor</option>
                <?php foreach ($usuarios as $usuario) : ?>
                    <option value="<?php echo $usuario['id']; ?>">
                        <?php echo htmlspecialchars($usuario['nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

        <label for="noticia">Notícia:</label>
        <textarea id="noticia" name="noticia" rows="5" required placeholder="Escreva um resumo da Noticia"></textarea>

        <label for="imagem">Imagem:</label>
        <input type="file" id="imagem" name="imagem">

        <button type="submit">Salvar</button>
    </form>
</body>

</html>