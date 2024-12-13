<?php
// Configuração do banco de dados
$servidor = "localhost"; // Endereço do servidor
$usuario = "root";       // Usuário do banco de dados
$senha = "";             // Senha (se não tiver senha, deixe em branco)
$banco = "cadastro_db";  // Nome do banco de dados

// Criando a conexão
$conn = new mysqli($servidor, $usuario, $senha, $banco);

// Verificando a conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Inicializando variáveis
$mensagem = "";

// Função para verificar as credenciais de login
function verificarLogin($email, $senha) {
    global $conn;

    // Preparando a consulta para verificar se o e-mail e a senha correspondem
    $sql = "SELECT * FROM usuarios WHERE email = ? AND senha = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    // Se o número de linhas for maior que 0, o login foi bem-sucedido
    return $result->num_rows > 0;
}

// Processando o envio do formulário apenas quando ele for submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificando se todos os campos foram preenchidos
    if (!empty($_POST['email']) && !empty($_POST['senha'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Verificando se o login é válido
        if (verificarLogin($email, $senha)) {
            // Redireciona para a página principal após login bem-sucedido
            header("Location: /TAYS/index.php");
            exit(); // Certifica que o código a seguir não será executado após o redirecionamento
        } else {
            $mensagem = "<div class='alert error'>Erro: E-mail ou senha incorretos.</div>";
        }
    } else {
        // Caso o formulário esteja vazio, exibe um alerta
        $mensagem = "<div class='alert error'>Erro: Todos os campos devem ser preenchidos.</div>";
    }
}

// Fechando a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            color: #333;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
        }

        .alert.success {
            background-color: #4CAF50;
            color: white;
        }

        .alert.error {
            background-color: #f44336;
            color: white;
        }

        .instruções {
            color: red;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>

        <!-- Exibir mensagem de erro ou sucesso -->
        <?php echo $mensagem; ?>

        <form method="post" action="">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required placeholder="Digite seu email">

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required placeholder="Digite sua senha">

            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
