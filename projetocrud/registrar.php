<?php
include_once './config/config.php';
include_once './classes/usuario.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = new Usuario($db);

    $nome = htmlspecialchars(trim($_POST['nome']));
    $sexo = $_POST['sexo'];
    $fone = htmlspecialchars(trim($_POST['fone']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    // Verifica se o email já está cadastrado
    if ($usuario->verificarEmail($email)) {
        $mensagem_erro = "O email já está cadastrado!";
    } else {
        // Cria o usuário usando o método correto 'registrar'
        if ($usuario->registrar($nome, $email, $senha, $fone, $sexo)) {
            header('Location: login.php');
            exit();
        } else {
            $mensagem_erro = "Erro ao cadastrar. Tente novamente!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Registrar</title>
    <style>
        /* Estilos conforme fornecido */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8e6f7; /* Rosa claro para o fundo */
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #5e2a83; /* Roxo escuro para o título */
            margin-bottom: 20px;
        }

        /* Estilizando o formulário */
        form {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #d81b60; /* Rosa mais escuro para os labels */
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #f06292; /* Rosa claro nas bordas */
            border-radius: 4px;
            font-size: 16px;
            background-color: #f9e1f2; /* Rosa bem suave para o fundo dos campos */
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #ec407a; /* Rosa médio para o botão de envio */
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #d81b60; /* Rosa mais intenso no hover */
        }

        /* Estilos para mensagens de erro ou sucesso */
        .error-message,
        .success-message {
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }

        .error-message {
            background-color: #f44336; /* Vermelho para erros */
        }

        .success-message {
            background-color: #ec407a; /* Rosa para sucesso */
        }

        /* Responsividade */
        @media (max-width: 600px) {
            form {
                padding: 15px;
            }

            input[type="submit"] {
                font-size: 14px;
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
    <h1>Registrar</h1>
    <a href="portal.php">Voltar</a>
    <form method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <label for="fone">Telefone:</label>
        <input type="text" id="fone" name="fone" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        <label>Sexo:</label>
        <label><input type="radio" name="sexo" value="M" required> Masculino</label>
        <label><input type="radio" name="sexo" value="F" required> Feminino</label>
        <input type="submit" value="Cadastrar">
    </form>
    <?php if (isset($mensagem_erro)): ?>
        <p style="color: red;"><?php echo $mensagem_erro; ?></p>
    <?php endif; ?>
</body>

</html>