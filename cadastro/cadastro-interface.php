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

// Função para verificar se o email já existe
function verificarEmail($email) {
    global $conn; // Usando a conexão global

    // Preparando a consulta para verificar se o email já existe
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Se o número de linhas for maior que 0, o email já existe
    return $result->num_rows > 0;
}

// Processando o envio do formulário apenas quando ele for submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificando se todos os campos foram preenchidos
    if (!empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['senha'])) {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Verificar se o email já está cadastrado
        if (verificarEmail($email)) {
        } else {
            // Obter o maior id da tabela para gerar o próximo id
            $sql_max_id = "SELECT MAX(id) AS max_id FROM usuarios";
            $result_max_id = $conn->query($sql_max_id);
            $row = $result_max_id->fetch_assoc();
            $novo_id = $row['max_id'] + 1; // Incrementa 1 para o próximo id

            // Inserir os dados no banco de dados com o novo id
            $sql = "INSERT INTO usuarios (id, nome, email, senha) VALUES ('$novo_id', '$nome', '$email', '$senha')";
            if ($conn->query($sql) === TRUE) {
                $mensagem = "<div class='alert success'>Cadastro realizado com sucesso!</div>";
            } else {
                $mensagem = "<div class='alert error'>Erro ao cadastrar: " . $conn->error . "</div>";
            }
        }
    } else {
        // Caso o formulário esteja vazio, exibe um alerta
        $mensagem = "<div class='alert error'>Erro: Todos os campos devem ser preenchidos.</div>";
    }
}
// Fechando a conexão com o banco de dados
$conn->close();
?>
<?php
// Verificando se o botão foi clicado
if (isset($_POST['redirecionar'])) {
    // Redirecionando para a página desejada
    header("Location: /TAYS/index.php");
    exit; // É importante usar exit após header para garantir que o script pare de executar
}
?>
<?php
// Verificando se o botão de redirecionamento para login foi clicado
if (isset($_POST['irLogin'])) {
    // Redirecionando para a página de login
    header("Location: /TAYS/login/login.php");
    exit; // É importante usar exit após header para garantir que o script pare de executar
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecionar para Login</title>
    <style>
        button {
            background-color: #4CAF50; /* Verde */
            color: white; /* Texto branco */
            padding: 10px 20px; /* Espaçamento interno */
            border: none; /* Sem borda */
            border-radius: 5px; /* Bordas arredondadas */
            cursor: pointer; /* Cursor de mão ao passar o mouse */
        }

        button:hover {
            background-color: #45a049; /* Cor ao passar o mouse */
        }
        .botao-login{
            display: flex;
            padding: 10px;
            width: 110px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <!-- Formulário com um botão para redirecionar para a página de login -->
    <form method="post" action="">
        <button class="botao-login" type="submit" name="irLogin">Ir para Login</button>
    </form>
</body>
</html>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecionar com Botão</title>
    <style>
        button {
            background-color: #4CAF50; /* Verde */
            color: white; /* Texto branco */
            padding: 10px 20px; /* Espaçamento interno */
            border: none; /* Sem borda */
            border-radius: 5px; /* Bordas arredondadas */
            cursor: pointer; /* Cursor de mão ao passar o mouse */
            padding: 10px;
        }
        button:hover {
            background-color: #45a049; /* Cor ao passar o mouse */
        }
        .botao-pginicial{
            display: flex;
            padding: 10px;
            width: 190px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <!-- Formulário com um botão para redirecionar -->
    <form method="post" action="">
        <button class="botao-pginicial" type="submit" name="redirecionar">Ir para a Página Inicial</button>
    </form>
</body>
</html>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
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

        input[type="text"], input[type="email"], input[type="password"] {
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
        <h2>Formulário de Cadastro</h2>

        <!-- Exibir mensagem de erro ou sucesso -->
        <?php echo $mensagem; ?>

        <form method="post" action="">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required placeholder="Digite seu nome">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required placeholder="Digite seu email">

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required placeholder="Digite sua senha">
            
            <p class="instruções">Se não aparecer uma mensagem escrito "Cadastro realizado com sucesso!", significa que o email que você está utilizando já foi utilizado por outro usuário!</p>
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>
