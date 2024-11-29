<?php
session_start();
include_once './config/config.php';
include_once './classes/usuario.php';

$usuario = new Usuario($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

   //var_dump($email, $senha);
   //exit;
    if ($dados_usuario = $usuario->login($email, $senha)) {
        
        $_SESSION['usuario_id'] = $dados_usuario['id'];
        $_SESSION['usuario_nome'] = $dados_usuario['nome'];

        header('Location: portal.php');
        exit();
    } else {
        $mensagem_erro = "Email ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
     /* Resetando algumas margens e preenchimento padrões */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Estilo do corpo da página */
body {
    font-family: 'Arial', sans-serif;
    background: linear-gradient(90deg, #f8b0b0 0%, #ff80a1 50%, #f8b0b0 100%); /* Tons de rosa para o fundo */
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Container geral para centralizar todo o conteúdo */
#container {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

/* Container do formulário de login */
.container {
    background-color: #ff80a1; /* Rosa claro */
    padding: 40px;
    border-radius: 10px;
    max-width: 450px;
    width: 100%;
    box-shadow: 2px 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

/* Título do formulário */
#titulo {
    font-size: 24px;
    color: white;
    margin-bottom: 30px;
    letter-spacing: 2px;
    text-transform: uppercase;
}

/* Estilos do formulário */
form {
    display: flex;
    flex-direction: column;
}

/* Estilo para os campos de input */
input[type="email"],
input[type="password"] {
    padding: 12px;
    margin: 10px 0;
    border: 2px solid #ff66b2; /* Rosa mais claro para as bordas */
    border-radius: 5px;
    font-size: 16px;
    background-color: #f8e1e6; /* Rosa muito suave para o fundo */
}

/* Estilo do botão de submit */
input[type="submit"] {
    padding: 12px;
    margin-top: 10px;
    background-color: #ec407a; /* Rosa intenso para o botão */
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #d81b60; /* Rosa ainda mais intenso no hover */
}

/* Link para a página de registro */
p a {
    color: #9b59b6; /* Roxo para o link */
    text-decoration: none;
}

p {
    margin: 10px;
    color: white;
}

p a:hover {
    text-decoration: underline;
}

/* Mensagem de erro */
.error-message {
    color: white;
    background-color: #f44336; /* Vermelho para erro */
    padding: 10px;
    margin-top: 10px;
    text-align: center;
    font-weight: bold;
    border-radius: 5px;
}

/* Responsividade */
@media (max-width: 480px) {
    #titulo {
        font-size: 20px;
    }

    .container {
        padding: 20px;
        width: 90%;
    }

    input[type="email"],
    input[type="password"],
    input[type="submit"] {
        font-size: 14px;
    }
}
    </style>
</head>

<body>
    <div id="container">
        <div class="container">
            <h1 id="titulo">Login</h1>
            <form method="POST">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
                <label for="senha">Senha:</label>
                <input type="password" name="senha" required>
                <input type="submit" value="Entrar">
            </form>

            <p>Não tem uma conta? <br> <a href="./registrar.php">Registre-se aqui</a></p> <br>
            <p>Esqueceu a senha? <a href="./solicitar_recuperacao.php">Clique Aqui</a></p>

            <?php  if (isset($mensagem_erro)): ?>
                <div class="error-message">
                    <?php echo $mensagem_erro; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
