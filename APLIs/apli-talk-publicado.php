<?php
// Configurações do banco de dados
$username = "root";
$password = "";
$database = "cadastro_db";
$mysqli = new mysqli("localhost", $username, $password, $database);

// Verifica a conexão
if ($mysqli->connect_error) {
    die("Conexão falhou: " . $mysqli->connect_error);
}

// Consulta para pegar os textos em ordem decrescente de ID
$query = "SELECT texto FROM textos_talk ORDER BY id DESC";
$result = $mysqli->query($query);

// Início do HTML
echo '<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Textos</title>
    <style>
        /* Adicione seu estilo aqui */
        body { font-family: Arial, sans-serif; background-color: black;}
        h1{color: white; margin-left: 10px;}
        .texto { margin: 10px 0; padding: 10px; border: 1px solid #ccc; color: white; margin-left: 10px; margin-right: 10px; border-radius: 20px;}
    </style>
</head>
<body>
    <h1>Confira os TALKS</h1>';

// Verifica se há resultados e exibe
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="texto">' . htmlspecialchars($row["texto"]) . '</div>';
    }
} else {
    echo "Nenhum texto encontrado.";
}

// Finaliza o HTML
echo '</body>
</html>';

// Libera o resultado e fecha a conexão
$result->free();
$mysqli->close();
?>