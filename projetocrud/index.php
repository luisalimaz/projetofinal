<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Portal de Notícias</title>
    <style>/* Reset de margens, padding e box-sizing */
/* Definindo o esquema de cores roxas */
:root {
    --roxo-escuro: #6a0dad;
    --roxo-medio: #9b4f96;
    --roxo-claro: #d8a6e1;
    --lavanda: #e5c8f0;
}

/* Estilos globais */
body {
    background-color: var(--lavanda);
    font-family: Arial, sans-serif;
    color: var(--roxo-escuro);
    margin: 0;
    padding: 0;
}

/* Cabeçalho */
header {
    background-color: var(--roxo-escuro);
    color: white;
    text-align: center;
    padding: 20px;
}

header h1 {
    margin: 0;
    font-size: 2em;
}

/* Seção principal */
main {
    padding: 40px;
    text-align: center;
}

main h2 {
    font-size: 1.8em;
    color: var(--roxo-medio);
}

main p {
    font-size: 1.2em;
    color: var(--roxo-claro);
    line-height: 1.5;
}

/* Botões */
button {
    background-color: var(--roxo-medio);
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 1em;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: var(--roxo-escuro);
}

/* Rodapé */
footer {
    background-color: var(--roxo-escuro);
    color: white;
    text-align: center;
    padding: 15px;
    position: fixed;
    bottom: 0;
    width: 100%;
}

footer p {
    margin: 0;
}

</style>
</head>

<body>
    <!-- Cabeçalho -->
    <header>
        <div class="logo">
            <img src="img/noticias.png" alt="Logo" >
        </div>
        <div class="login">
            <a href="login.php" class="">Login</a>
        </div>
    </header>

    <?php
    include_once './config/config.php';
    include_once './classes/Noticia.php';
    $noticias = new Noticia($db);
    $dados = $noticias->ler();
    ?>

    <main>
        <h1>Bem-vindo ao Portal de Notícias</h1>

        <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)) : ?>
            <section class="noticias">

                <article>
                    <img src="<?php echo htmlspecialchars($row['imagem']); ?>" alt="Imagem da manchete" class="imagem-manchete">
                    <div class="manchete-conteudo">
                        <h2><?php echo htmlspecialchars($row['titulo']); ?></h2>
                        <p><?php echo htmlspecialchars($row['conteudo']); ?></p>
                    </div>
                </article>

            <?php endwhile; ?>
            </section>

    </main>

    <footer>
        <p>&copy; 2024 Portal de Notícias ||Todos os direitos reservados a Maria.</p>
    </footer>
</body>

</html>
