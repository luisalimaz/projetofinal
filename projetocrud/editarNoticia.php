<?php
session_start();
include_once './config/config.php';
include_once './classes/Noticia.php';

$noticia = new Noticia($db);

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $data = $_POST['data'];
    $noticia = $_POST['noticia'];
    $imagem = $_FILES['imagem'];
    $noticia->atualizar($id, $titulo, $autor, $data, $noticia, $imagem);
    header('Location: portal.php');
    exit();
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $row = $noticia->lerPorId($id);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Notícias</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #fce4ec; /* Fundo rosa claro */
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        header {
            background: linear-gradient(135deg, #f06292, #ec407a); /* Tons de rosa */
            color: white;
            padding: 20px 0;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
            border-bottom: 2px solid #ad1457;
            position: relative;
        }

        header h1 {
            font-size: 2.5rem;
            margin: 0;
        }

        header h3 {
            font-size: 1.5rem;
            margin-top: 10px;
            font-weight: 700;
            color: #fff;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.4);
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 160px);
            padding: 20px;
            margin-top: 100px;
        }

        .box {
            width: 100%;
            max-width: 450px;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            text-align: center;
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #ec407a;
        }

        form label {
            font-size: 1rem;
            margin-bottom: 5px;
            display: block;
        }

        form input[type="text"],
        form input[type="date"],
        form input[type="file"],
        form select,
        form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border: 2px solid #f06292; /* Bordas rosa claro */
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1rem;
        }

        form textarea {
            resize: vertical;
        }

        form button {
            width: 100%;
            padding: 10px;
            background-color: #ec407a; /* Botão rosa escuro */
            color: white;
            font-size: 1.1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #ad1457; /* Tom mais escuro para hover */
        }

        .box p {
            text-align: center;
            font-size: 0.9rem;
            margin-top: 10px;
        }

        .mensagem p {
            color: #f44336;
            text-align: center;
            margin-top: 10px;
            font-size: 1rem;
        }

        .footer {
            text-align: center;
            padding: 15px;
            background-color: #333;
            color: white;
            margin-top: 100px;
            width: 100%;
        }

        @media (max-width: 768px) {
            header h1 {
                font-size: 2.2rem;
            }

            header h3 {
                font-size: 1.3rem;
            }

            .container {
                height: auto;
                padding: 10px;
            }

            form {
                padding: 15px;
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>Editar Notícias</h1>
    <h3>Edite suas Notícias</h3>
</header>

<div class="container">
    <div class="box">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <label for="titulo">Título</label>
            <input type="text" name="titulo" value="<?php echo $row['titulo']; ?>" required>
            <label for="autor">Autor</label>
            <input type="text" name="autor" value="<?php echo $row['autor']; ?>" required>
            <label for="data">Data</label>
            <input type="date" name="data" value="<?php echo $row['data']; ?>" required>
            <label for="noticia">Notícia</label>
            <input type="text" name="noticia" value="<?php echo $row['noticia']; ?>" required>
            <label for="imagem">Imagem</label>
            <input type="file" name="imagem" required>
            
            <button type="submit">Editar</button>
        </form>
    </div>    
</div>

<footer>
    <div class="footer">
        <p>&copy; 2024 Portal de Notícias | Todos os direitos reservados</p>
    </div>
</footer>

</body>
</html>
