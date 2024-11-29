<?php
include_once "./config/config.php";
include_once "./classes/database.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Controle de Notícias</title>
    <style>* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f8e6f7; /* Rosa claro para o fundo */
    color: #5e2a83; /* Roxo escuro para o texto */
}

header {
    background-color: #e91e63; /* Rosa vibrante para o cabeçalho */
    color: white;
    padding: 20px;
    text-align: center;
}

#logo_cabecalho {
    margin-bottom: 10px;
    margin-right: 900px;
}

#botao_sair {
    background-color: #ec407a; /* Rosa mais suave para o botão sair */
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    font-weight: bold;
    border-radius: 5px;
    transition: background-color 0.3s;
}

#botao_sair:hover {
    background-color: #d81b60; /* Rosa mais intenso no hover */
}

.container {
    display: flex;
    justify-content: center;
    gap: 20px;
    padding: 40px;
}

.container a {
    text-decoration: none;
    background-color: #f06292; /* Rosa claro para os links */
    color: white;
    padding: 15px 30px;
    font-size: 18px;
    font-weight: bold;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.container a:hover {
    background-color: #ec407a; /* Rosa mais forte no hover */
}

/* Responsividade */
@media (max-width: 768px) {
    .container {
        flex-direction: column;
        align-items: center;
    }

    .container a {
        width: 100%;
        text-align: center;
        margin-bottom: 10px;
    }
}
</style>
</head>
<body>
    <header>
        <img id="logo_cabecalho" src="img/noticia.png" alt="logo">
         <a id="botao_sair" href="TelaPrincipal.php" class="botao-sair">SAIR</a>
    </header>
    <div class="container">
        
    <a id="botao_cadastrar" href="cadastrarNoticia.php" class="botao-login">Cadastrar Notícia</a>
    <a id="botao_gerenciarNoticia" href="gerenciarNoticias.php" class="botao-login">Gerenciar Notícias</a>
    <a id="botao_gerenciarUsuario" href="gerenciarUsuarios.php" class="botao-login">Gerenciar<br>Usuários</a>
    </div>
</body>
</html>