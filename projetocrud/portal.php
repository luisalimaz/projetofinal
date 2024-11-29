<?php
session_start();
include_once './config/config.php';
include_once './classes/usuario.php';
include_once 'classes/Noticia.php';


// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
    
}
$usuario = new Usuario($db);


// Processar exclusão de usuário
if (isset($_GET['deletar'])) {
    $id = $_GET['deletar'];
    $usuario->deletar($id);
    header('Location: portal.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $titulo = $_POST['titulo'];
        $data = $_POST['data'];
        $autor_id = $_POST['autor'];
        $noticia = $_POST['noticia'];
        $imagem = null;

        // Upload da imagem
        if (!empty($_FILES['imagem']['name'])) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = basename($_FILES['imagem']['name']);
            $filePath = $uploadDir . uniqid() . '_' . $fileName;

            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $filePath)) {
                $imagem = $filePath;
            } else {
                throw new Exception('Erro ao fazer upload da imagem.');
            }
        }

        // Inserir notícia no banco
        $stmt = $db->prepare("INSERT INTO noticias (titulo, data, autor_id, noticia, imagem) VALUES (:titulo, :data, :autor, :noticia, :imagem)");
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':autor', $autor_id);
        $stmt->bindParam(':noticia', $noticia);
        $stmt->bindParam(':imagem', $imagem);
        $stmt->execute();

        echo "Notícia cadastrada com sucesso!";
    } catch (Exception $e) {
        die('Erro ao salvar notícia: ' . $e->getMessage());
    }
}
// Obter dados do usuário logado
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$nome_usuario = $dados_usuario['nome'];
// Obter dados dos usuários
$dados = $usuario->ler();
// Função para determinar a saudação
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <title>Document</title>
    <style>


        /* Resetando algumas propriedades padrão para uma aparência consistente */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Definições básicas de fontes e cores */
body {
    font-family: Arial, sans-serif;
    background-color: #fce4ec; /* Cor de fundo em tom suave de rosa */
    color: #333;
    line-height: 1.6;
}

/* Header - área superior da página */
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #d81b60; /* Tom de rosa mais forte para o header */
    padding: 15px 30px;
}

header div img {
    max-height: 50px; /* Limita a altura da logo */
}

header h2 {
    color: white;
    font-size: 24px;
    font-weight: bold;
}

/* Main - conteúdo principal da página */
main {
    padding: 30px;
    text-align: center;
}

/* Título principal */
h3.sub-titulo {
    font-size: 22px;
    margin-bottom: 20px;
    color: #880e4f; /* Rosa escuro para o subtítulo */
}

/* Links para ações do usuário */
main div a {
    display: inline-block;
    margin: 10px 15px;
    padding: 10px 20px;
    text-decoration: none;
    color: #fff;
    background-color: #ec407a; /* Rosa médio para os links */
    border-radius: 5px;
    font-size: 18px;
    transition: background-color 0.3s ease;
}

/* Efeito hover nos links */
main div a:hover {
    background-color: #ad1457; /* Rosa mais escuro para hover */
}

/* Responsividade - Adaptações para dispositivos menores */
@media (max-width: 768px) {
    header {
        flex-direction: column;
        text-align: center;
        padding: 20px;
    }

    header h2 {
        font-size: 20px;
        margin-top: 10px;
    }

    main {
        padding: 20px;
    }

    main div a {
        font-size: 16px;
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
    <header>
        <div><img src="img/noticia.png" alt=""></div>
        <div>
        <a href="index.php">Voltar</a>
            <h2>Portal de noticia</h2>
        </div>
    </header>

    <main>
        <h3 class="sub-titulo">O que deseja fazer?</h3>
        <div>
            <a href="./registrar.php">Cadastrar usuario</a>
            <a href="./cadastrarNoticia.php">Cadastrar noticias</a>
            <a href="./consultarNoticia.php">Consultar noticias</a>
            <a href="./consultarUsuario.php">Consultar usuarios</a>
        </div>
    </main>
</body>

</html>