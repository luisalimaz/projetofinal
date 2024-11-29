<?php
include_once './config/config.php'; // Conexão com o banco de dados
include_once './classes/Noticia.php'; // Classe Notícia

// Criar uma instância da classe Noticia
$database = new Database();
$db = $database->getConnection();
$noticia = new Noticia($db);

// Usando o método select() para recuperar as últimas notícias
$query = "SELECT * FROM noticias ORDER BY data DESC LIMIT 5"; // Buscar as 5 notícias mais recentes
$stmt = $db->prepare($query);
$stmt->execute();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>PORTAL DE NOTÍCIAS</title>
    <style>
/* General Body Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f8f0f6; /* Soft pink background */
    margin: 0;
    padding: 0;
    color: #333; /* Text color remains consistent */
}

/* Header Styling */
header {
    background-color: #e91e63; /* Pink header background */
    color: #fff;
    padding: 15px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

#logo_cabecalho {
    width: 32px; /* Set logo width to 32px */
    height: auto; /* Maintain aspect ratio */
}

#botao_login {
    font-size: 18px;
    display: flex;
    align-items: center;
}

/* Button Styling */
.botao-login {
    background-color: #ec407a; /* Lighter pink for the button */
    color: #fff;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.botao-login:hover {
    background-color: #d81b60; /* Darker pink on hover */
}

/* Container Styling */
.container {
    padding: 30px;
    max-width: 1000px;
    margin: 30px auto;
    background-color: #fff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    border-radius: 8px;
    text-align: left;
}

/* News Article Styling */
.noticia {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #f1c6d1; /* Soft pink border */
}

.noticia img {
    width: 100%;
    height: auto;
    border-radius: 5px;
    margin-bottom: 15px;
}

.noticia h2 {
    font-size: 28px;
    color: #e91e63; /* Pink headline */
    margin: 20px 0;
}

.noticia p {
    font-size: 18px;
    line-height: 1.8;
    color: #555;
}

.data-autor {
    font-size: 14px;
    color: #888;
    margin-bottom: 15px;
}

/* Footer Styling */
footer {
    background-color: #e91e63; /* Matching pink footer */
    color: #fff;
    text-align: center;
    padding: 20px;
    margin-top: 40px;
    font-size: 14px;
    letter-spacing: 1px;
}

footer a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
}

footer a:hover {
    text-decoration: underline;
}

    </style>
</head>

<body>
    <header>
        <img id="logo_cabecalho" src="img/noticia.png" alt="logo">
        <a id="botao_login" href="login.php" class="botao-login">Login</a>
    </header>

    <div class="container">
        <?php
        // Verifica se há notícias
        if ($stmt->rowCount() > 0) {
            // Percorre as notícias e exibe
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='noticia'>
                        <h2>" . htmlspecialchars($row['titulo']) . "</h2>
                        <p class='data-autor'>Publicado em " . date("d/m/Y", strtotime($row['data'])) . " por " . htmlspecialchars($row['autor']) . "</p>
                        <img src='" . htmlspecialchars($row['imagem']) . "' alt='Imagem da Notícia'>
                        <p>" . htmlspecialchars($row['noticia']) . "</p>
                    </div>";
            }
        } else {
            echo "<p>Não há notícias cadastradas no momento.</p>";
        }
        ?>
    </div>

    <footer>
        <p>&copy; 2024 Portal de Notícias</p>
    </footer>
</body>

</html>